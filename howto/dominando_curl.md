# Dominando CURL

## ¿Qué es CURL?

**cURL** es una herramienta ideal para interactuar con un sitio web o una API, enviando peticiones y mostrando las respuestas en la terminal o guardándolas en un archivo. Es fundamental para automatizar tareas en scripts.

## Descarga de archivos

El comando más básico descarga el contenido de un sitio web (HTML por defecto):

```bash
curl http://www.google.com
```

Para guardar la salida en un archivo, usamos la opción `-o` u `--output`:

```bash
curl www.ejemplo.com --output codigo.html
```

## Seguir el redireccionamiento

Si un sitio web redirige a otra URL, cURL no lo seguirá por defecto. Para habilitar esto, usamos la opción `-L`:

```bash
curl -L www.ejemplo.com
```

## Pausar y reanudar descargas

Si una descarga se interrumpe, puedes reanudarla usando la opción `-C -`:

```bash
curl -C - example.com/file.zip --output MyFile.zip
```
El guion `-` indica a cURL que determine automáticamente dónde retomar la descarga.

## Especificar el tiempo límite

*   **Tiempo total de ejecución (`-m`)**:
    ```bash
    curl -m 60 example.com
    ```
*   **Tiempo de conexión (`--connect-timeout`)**:
    ```bash
    curl --connect-timeout 60 example.com
    ```

## Utilizar un nombre de usuario y contraseña

Para autenticación básica o servidores FTP, usamos la opción `-u`:

```bash
curl -u usuario:contraseña ftp://example.com/archivo.txt
```

## Uso de proxies

Utilizamos la opción `-x` para definir un proxy:

```bash
curl -x 192.168.1.1:4546 http://example.com
```

## Descargar archivos grandes por partes

Podemos descargar rangos específicos de bytes usando `--range`:

```bash
curl --range 0-99999999 http://servidor.com/archivo.iso -o parte1
curl --range 100000000-199999999 http://servidor.com/archivo.iso -o parte2
```

Luego unimos las partes:
```bash
cat parte? > archivo_completo.iso
```

## Certificado del cliente

Para servidores que requieren autenticación por certificado:

```bash
curl --cert path/to/cert.crt:password ftp://example.com
```

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

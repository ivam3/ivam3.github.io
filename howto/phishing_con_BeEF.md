# Phishing Avanzado con BeeF y Metasploit

**BeeF (Browser Exploitation Framework)** es una herramienta potente para ataques dirigidos al navegador. En esta práctica lo integraremos con **Metasploit**.

## Configuración de BeeF

Edita el archivo `config.yaml` de BeeF:

1.  **Verbosidad**: Cambia `false` a `true` en las líneas 11 (servidor) y 13 (cliente) si deseas ver más detalles.
2.  **Credenciales**: Modifica el `user:password` en las líneas 20 y 21.
3.  **GeoIP**: Asegúrate de que la ruta a `GeoLite2-City.mmdb` sea la correcta (Línea 118).
4.  **Metasploit**: En la línea 147, activa la conexión cambiando `false` a `true`.

## Conexión con Metasploit

1.  Inicia la base de datos de PostgreSQL:
    ```bash
    pg_ctl -D $PREFIX/var/lib/postgresql start
    ```
2.  Inicia Metasploit y carga el servicio MSGRPC:
    ```bash
    msfconsole
    # Dentro de msf:
    load msgrpc ServerHost=127.0.0.1 ServerPort=55552 User=msf Pass='abc123'
    ```

## Ejecución

Inicia BeeF:
```bash
beef
```
Accede al panel de control y utiliza el link de "hook" (`http://127.0.0.1:3000/demos/basic.html`) para probar en tu propio navegador o en un entorno controlado.

## Módulos de Ataque: Google Phishing

Una vez que un navegador está "enganchado" (hooked):

1.  Ve a la pestaña **Commands**.
2.  Selecciona **Social Engineering** -> **Google Phishing**.
3.  Configura los parámetros:
    *   **Gmail logout interval**: Tiempo para forzar el cierre de sesión real.
    *   **Redirect delay**: Tiempo antes de redirigir al usuario al phishing.
4.  Cuando el usuario ingrese sus credenciales, aparecerán en la pestaña **Module Results History**.

> **Nota:** Este tipo de ataques son muy detectables por antivirus modernos si la verbosidad es alta. Úsalo con discreción en tus auditorías.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

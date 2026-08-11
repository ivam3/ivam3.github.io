# Vulnerabilidad HTTP Verb Tampering

**HTTP Verb Tampering** es un ataque que aprovecha las vulnerabilidades de los mecanismos de autenticación y control de acceso basados en los verbos o métodos HTTP.

## Concepto

Muchos administradores limitan el acceso solo a los métodos más comunes (`GET`, `POST`), pero dejan abiertos otros que pueden permitir el acceso no autorizado a recursos restringidos.

### Verbos HTTP Comunes:
*   **GET**: Recuperar información.
*   **POST**: Enviar datos al servidor.
*   **HEAD**: Igual que GET, pero solo devuelve cabeceras.
*   **PUT**: Cargar contenido a un URI.
*   **DELETE**: Eliminar un recurso.
*   **OPTIONS**: Obtener parámetros de conexión.

## Ejemplo de Configuración Insegura

En Java EE, un archivo `web.xml` mal configurado podría verse así:

```xml
<security-constraint>
    <web-resource-collection>
        <url-pattern>/admin/*</url-pattern>
        <http-method>GET</http-method>
        <http-method>POST</http-method>
    </web-resource-collection>
    <auth-constraint>
        <role-name>admin</role-name>
    </auth-constraint>
</security-constraint>
```
Este código bloquea `GET` y `POST` para no-administradores, pero permite cualquier otro método como `HEAD` u `OPTIONS`, que podrían revelar información sensible.

## El Ataque

Utilizaremos `curl` para probar diferentes métodos contra un servidor:

1.  **Petición GET (Bloqueada)**:
    ```bash
    curl -s http://challenge.com/admin/
    # Resultado: 401 Authorization Required
    ```
2.  **Petición OPTIONS (Posible Bypass)**:
    ```bash
    curl -sX OPTIONS http://challenge.com/admin/
    # Resultado: Contenido de la página (200 OK)
    ```

## Mitigación

*   Limita la lista de métodos HTTP disponibles en el servidor web.
*   Asegúrate de que la autenticación esté activada para **todos** los métodos, no solo los comunes.
*   En Apache, evita el uso de `LimitExcept` de forma insegura en el archivo `.htaccess`.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

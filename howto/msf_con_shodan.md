# Metasploit + Shodan

Practicaremos el uso de **Metasploit** para localizar diversos tipos de servidores (como cámaras de vigilancia) utilizando la base de datos de **Shodan**.

## Requerimientos
*   Cuenta en **Shodan**.
*   **API Key** de Shodan.
*   Metasploit-framework:
    ```bash
    apt install metasploit-framework
    ```

## Pasos de Configuración

1.  **Guardar tu API KEY**:
    ```bash
    mkdir -p ~/.msf4/logs # O la ruta de configuración de msf
    echo "TU_API_KEY" > ~/.msf4/shodan_api_key
    ```

2.  **Conexión a la base de datos PostgreSQL**:
    ```bash
    postgresql start # Si usas i-Haklab
    # O manualmente:
    pg_ctl -D $PREFIX/var/lib/postgresql start
    ```

3.  **Uso en MSFconsole**:
    Puedes crear un archivo de recursos (`.rc`) para automatizar la carga:
    ```bash
    use auxiliary/gather/shodan_search
    set SHODAN_APIKEY [TU_API_KEY]
    set QUERY [QUERY_A_ELEGIR]
    run
    ```

4.  **Queries Comunes**:
    *   Axis, Cisco, Samsung, Sony, WebcamXP, Nginx, Netgear, etc.

## Acceso y Credenciales Comunes

Si localizas un servidor que solicita autenticación, estas son algunas de las combinaciones más frecuentes:

| Usuario | Contraseña |
| :--- | :--- |
| admin | 123456 |
| root | root |
| admin | admin |
| root | system |
| admin | (en blanco) |

> **Nota:** Si no obtienes acceso con estas credenciales, el siguiente paso sería un ataque de fuerza bruta coordinado.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

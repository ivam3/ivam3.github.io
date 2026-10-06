# Anonimización con TOR + PRIVOXY en Termux

Ocultar nuestra presencia en la red es fundamental. En esta práctica aprenderemos a usar la red **TOR** mediante proxies con **PRIVOXY** en Termux, sin necesidad de ser root.

## ¿Cómo funciona?

Cuando usas TOR, tus paquetes no van directamente al destino. Pasan por una serie de nodos (circuitos) encriptados. Cada nodo solo conoce al anterior y al siguiente, lo que garantiza el anonimato.

## Instalación

En Termux:
```bash
apt install tor privoxy
```

## Configuración

### 1. Tor (`$PREFIX/etc/tor/torrc`)
Añade al final del archivo:
```text
AvoidDiskWrites 1
ControlPort 9051
Log notice stdout
SocksListenAddress 127.0.0.1
SocksPort 9050
DNSPort 53
AutomapHostsOnResolve 1
```

### 2. Privoxy (`$PREFIX/etc/privoxy/config`)
Añade al final del archivo para redirigir el tráfico a Tor:
```text
forward-socks5 / 127.0.0.1:9050 .
```

### 3. Navegador (Kiwi Browser)
Instala la extensión **Switchy Omega** y configura un perfil de proxy:
*   Protocolo: `HTTP`
*   Servidor: `127.0.0.1`
*   Puerto: `8118`

### 4. Configuración del Sistema (Opcional)
Si deseas torificar todo el sistema Android, ve a los ajustes de tu red Wi-Fi -> Opciones Avanzadas -> Proxy:
*   Nombre del host: `127.0.0.1`
*   Puerto: `8118`

## Implementación

Inicia los servicios en Termux:
```bash
tor &
privoxy --no-daemon $PREFIX/etc/privoxy/config &
```

Verifica que los puertos estén abiertos:
```bash
nmap -p 9050,8118 127.0.0.1
```

Comprueba tu IP pública en cualquier sitio de geolocalización. ¡Deberías aparecer en una ubicación diferente!

## Desactivar Proxy

1.  **Android**: Cambia el ajuste de Proxy de Wi-Fi a "Ninguno".
2.  **Navegador**: Selecciona "Direct" en Switchy Omega.
3.  **Termux**: Mata los procesos:
    ```bash
    killall tor privoxy
    ```

> **Nota:** TOR provee anonimato en la red, pero no protege la información que tú mismo envíes (como nombres de usuario en formularios).

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

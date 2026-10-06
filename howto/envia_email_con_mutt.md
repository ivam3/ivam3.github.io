# Envío de Correo Electrónico desde la Terminal con MUTT

Habrá ocasiones en las que nos veremos en la necesidad de enviar información o archivos desde la línea de comandos, ya sea de manera manual o automatizada. Para ello utilizaremos el comando **mutt**.

## Instalación
```bash
pkg install mutt -y
```

## Configuración (`.muttrc`)

Debes crear un archivo llamado `.muttrc` en tu `$HOME` con la configuración de tu servidor SMTP.

```text
set from="micorreo@gmail.com"
set realname="Tu Nombre"
set imap_user="micorreo@gmail.com"
set imap_pass="tu_contraseña_de_aplicacion"
set imap_authenticators="gssapi:cram-md5:login"

set folder="imaps://imap.gmail.com:993"
set spoolfile="imaps://imap.gmail.com:993/INBOX"
set smtp_url="smtp://tu_usuario@smtp.gmail.com:587"
set smtp_pass="tu_contraseña_de_aplicacion"

set ssl_starttls=yes
set ssl_force_tls=yes
set editor='vim'
```

> **Importante:** Para Gmail, debes generar una **Contraseña de Aplicación**. La opción de "Apps menos seguras" ha sido discontinuada en muchos casos.

## Ejecución y Uso

### Enviar un correo simple
```bash
mutt -s "Asunto del correo" correo_destino@mail.com
```

### Enviar con el cuerpo en una sola línea
```bash
mutt -s "Asunto" destino@mail.com <<< "Este es el cuerpo del mensaje"
```

### Enviar con un archivo adjunto (`-A`)
```bash
mutt -s "Archivo adjunto" destino@mail.com -A /ruta/al/archivo.pdf
```

### Uso de tuberías (Pipes)
Puedes enviar la salida de cualquier comando como cuerpo del correo:
```bash
cat reporte.txt | mutt -s "Reporte Diario" destino@mail.com
echo "Servidor activo" | mutt -s "Status" destino@mail.com
```

### Enviar con encabezados adicionales (`-a`)
```bash
mutt -s "Asunto" -a From:alias@correo.com destino@mail.com
```

> **Nota:** Revisa el manual con `man mutt` para más detalles técnicos.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

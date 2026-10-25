# Bash Scripting - El comando dialog

El comando **dialog** nos permite crear un estilo de interfaz simple en la salida estándar, dándole una mejor presentación a nuestros scripts y a su vez facilita su uso ante los usuarios ya que utiliza la pantalla táctil.

## Ejemplo

```bash
dialog --backtitle "TERMUX OPERATIVE SYSTEM ANDROID" --title "Bootloader" --radiolist "\nChoose a system :" 0 0 0 1 "i-Haklab" on 2 "Kali-Linux" on 3 "Kali-nethunter" on 2>$HOME/archivo.txt
```

### Detalles de la ejecución:

*   **Ejecuten esta línea de comando** para que comprendan el significado de cada texto (`backtitle`, `title` y `radiolist`).
*   La opción `0 0 0` asigna el largo y ancho de la ventana por defecto, pero este puede ser modificado según la necesidad (ej. `20 50`).
*   La enumeración `"1" "2" "3"` son referentes a la enumeración de las opciones a elegir.
*   La opción `"on"` puede ser cambiada a `"off"` e indica que la opción está disponible y será o no, mostrada en pantalla.
*   La opción `--radiolist` puede ser cambiado por algún mensaje de menú con la opción `--menu` o bien por un simple mensaje con `--msgbox` o `--alertbox` entre otros más que podrás encontrar en su menú de ayuda:

```bash
dialog --help
```

*   La opción `2>$HOME/archivo.txt` envía el número de opción del menú elegida por el usuario a un archivo, es decir 1, 2 o 3 (en base al ejemplo).
*   Al final de cada caja de diálogo se puede presentar dos opciones **"aceptar"** y **"cancelar"**. Donde aceptar obtiene el valor de `"1"` y cancelar el valor `"0"` y este valor es almacenado bajo la variable `$?`.

Bien, en base a esta información en esta práctica realizaremos un script donde tras la elección del usuario se ejecute una acción. La cual podemos definir con una simple condicional `if elif else` tomando el valor de cada variable como se muestra en el archivo que les dejo de ejemplo.

Sin embargo solo es una guía, y en la práctica tendrán que darle sus propias opciones junto a su ejecución a todas las opciones e incluso a la opción cancelar.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

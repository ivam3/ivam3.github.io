# Bash Scripting - El comando getopts

Conoceremos y practicaremos con el comando **getopts**, el cual tiene la tarea de obtener (**get**) las opciones (**options**) dadas por usuarios en la shell.

El comando toma tres parámetros. La primera es una especificación de qué opciones son válidas, enumeradas como una secuencia de letras. Por ejemplo, la cadena `'ht'` significa que las opciones `-h` y `-t` son válidas.

El segundo argumento de **getopts** es una variable que se completará con la opción o argumento que se procesará a continuación del bucle. En el siguiente bucle, `opt` mantendrá el valor de la opción actual que ha sido analizada por **getopts**.

## Ejemplo básico

```bash
while getopts ":ht" opt; do
  case ${opt} in
    h)
        # process option h
        ;;
    t)
        # process option t
        ;;
    \?)
        echo "Usage: miarchivo [-h] [-t]"
      ;;
  esac
done
```

Este ejemplo muestra algunas características adicionales de **getopts**:

*   Si se proporciona una opción no válida, a la variable de opción se le asigna el valor `?`. Puede detectar este caso y proporcionar un mensaje de uso apropiado al usuario.
*   Este comportamiento solo es cierto cuando antepone la lista de opciones válidas `":"` para deshabilitar el manejo de errores predeterminado de opciones no válidas. **Les recomiendo deshabilitar siempre el manejo de errores predeterminado en sus scripts.**
*   El tercer argumento para **getopts** es la lista de argumentos y opciones a procesar. Cuando no se proporciona, el valor predeterminado son los argumentos y las opciones proporcionados a la aplicación (`$@`). Puede proporcionar este tercer argumento para **getopts** y así analizar cualquier lista de argumentos y opciones que proporcione.

La variable `OPTIND` contiene el número de opciones analizadas anteriormente por **getopts**.

*   Es una práctica común llamar al comando `shift` al final del bucle para eliminar las opciones que ya se han manejado.

```bash
shift $((OPTIND -1))
```

## Opciones con argumentos

Las opciones que tienen argumentos en sí están representadas con `":"`. El argumento de una opción se coloca en la variable `OPTARG`.

En el siguiente ejemplo, la opción `"t"` toma un argumento. Cuando se proporciona el argumento, copiamos su valor a la variable `"target"`. Si el usuario no proporciona ningún argumento, **getopts** se establecerá en `":"` así que podemos reconocer esta condición de error captando el caso e imprimiendo un mensaje de error indicando que dicha opción necesita un argumento apropiado.

```bash
while getopts ":t:" opt; do
  case ${opt} in
    t)
      target=$OPTARG
      ;;
    \?)
      echo "Usage: miarchivo [-h] [-t]"
      ;;
    :)
      echo "Invalid option: $OPTARG requires an argument" 1>&2
      ;;
  esac
done
shift $((OPTIND -1))
```

## Ejercicio de práctica

Realizaremos la creación de un script que automatice los siguientes procesos:

*   Opción `-h`: mostrará el menú de ayuda.
*   Opción `-m`: abrirá la consola de **metasploit** ya conectado a su base de datos.
*   Opción `-s`: activará el servidor **php** donde se encuentra nuestro phishing.
*   Opción `\?`: mostrará el modo de uso.
*   Opción `:`: indicará que la opción necesita un parámetro o argumento.

Agreguen otras opciones o modifíquenlas, añadan un banner o denle color si lo desean... se agradece su proactividad.

> **Advertencia:** Apóyate con el tutorial de la práctica en **TELEGRAM**.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

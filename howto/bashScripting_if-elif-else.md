# Programación en Bash - Saludo Automático

Este mes practicaremos la programación en **bash**, y en esta ocasión haremos un sencillo script que nos diga "buenos días", "buenas tardes" o "buenas noches" según la hora del sistema.

## Script de la práctica

```bash
#!/bin/bash

# Script de la práctica I de la comunidad @Ivam3byCinderella
# En este script se obtiene el saludo correspondiente a la hora actual del sistema.

# DEFINIMOS LA VARIABLE HORA QUE CONTIENE LA HORA ACTUAL DEL SISTEMA
HORA=$(date | grep -oE '([0-9]{1,2}\:)([0-9]{1,2}\:)([0-9]{1,2})' | awk -F ":" '{print $1}')

# DEFINIMOS LA VARIABLE MINUTOS QUE CONTIENE EL MINUTO DE LA HORA DEL SISTEMA
# EN EL SCRIPT NO SE USA PERO LO DEJO COMO DATO ADICIONAL
MIN=$(date | grep -oE '([0-9]{1,2}\:)([0-9]{1,2}\:)([0-9]{1,2})' | awk -F ":" '{print $2}')

if [ $HORA -gt 00 ] && [ $HORA -lt 05 ]; then
    printf "Buenas madrugadas\n"

elif [ $HORA -gt 04 ] && [ $HORA -lt 12 ]; then
    printf "Buenos dias\n"

elif [ $HORA -gt 11 ] && [ $HORA -lt 19 ]; then
    printf "Buenas tardes\n"

else
    printf "Buenas noches\n"
fi
```

## Explicación detallada

*   **Línea 1: Shebang** - se define el intérprete bash.
*   **Línea 4: Variable HORA** - se define la variable que guardará la hora del sistema llamando al comando `date` que arroja la hora, minutos, segundos y fecha, por lo cual se realiza un filtrado con `grep` para obtener solo los números correspondientes a la hora, para posterior llamar a `awk` para filtrar el resultado de grep a solo la hora omitiendo los minutos y segundos.
*   **Línea 7: Variable MIN** - mismo proceso que en la línea 4, con la diferencia del filtrado con `awk` donde se pide el segundo parámetro, es decir los minutos, omitiendo la hora y los segundos.
*   **Línea 9: Condicional 1** - condicionamos si la variable `HORA` contiene el valor mayor a 00 y menor a 05, si esto se cumple procederá a imprimir en pantalla el saludo de la Línea 10.
*   **Línea 11: Condicional 2** - condicionamos si la variable `HORA` contiene el valor mayor a 04 y menor a 12, si esto se cumple procederá a imprimir en pantalla el saludo de la Línea 13.
*   **Línea 13: Condicional 3** - condicionamos si la variable `HORA` contiene el valor mayor a 11 y menor a 19, si esto se cumple procederá a imprimir en pantalla el saludo de la Línea 14.
*   **Línea 15: Condicional else** - concluimos las condición con `else` (sino) donde si no se cumplen ninguna de las condicionales anteriores se procedería con la impresión en pantalla de la Línea 16.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

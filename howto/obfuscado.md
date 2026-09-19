# Codificación y Ofuscación de Scripts BASH

Abordaremos la codificación y ofuscación de código **BASH** manteniendo su funcionalidad ejecutable.

## Términos Básicos

*   **Ofuscar (Obfuscate)**: Proceso de codificar texto plano o alterar su semántica para dificultar su lectura humana, manteniendo la legibilidad para el sistema.
*   **Compilar**: Transformar un programa de un lenguaje de programación a otro (ej. de Bash a binario ejecutable).

## Herramientas

### 1. SHC (Shell script Compiler)

Compilador genérico de la shell de Linux que convierte scripts en binarios.

**Instalación:**
```bash
pkg install shc -y
```

**Uso (Codificar):**
```bash
shc -v -r -T -e 01/08/2025 -m "Script expirado" -f mi_script.sh
```
*   **`-v`**: Verbosidad.
*   **`-r`**: Hace el binario redistribuible.
*   **`-e`**: Fecha de expiración.
*   **`-f`**: Archivo a compilar.

Esto creará un archivo `.x` (binario ejecutable) y uno `.c` (código fuente en C).

**Uso (Decodificar):**
Requiere la herramienta `unshc`:
```bash
unshc mi_script.sh.x -o script_recuperado.sh
```

### 2. bash-obfuscate

Herramienta basada en Node.js para ofuscar scripts de forma más agresiva.

**Instalación:**
```bash
pkg install nodejs -y
npm install -g bash-obfuscate
```

**Uso (Ofuscar):**
```bash
bash-obfuscate mi_script.sh -o script_ofuscado.sh
```

**Uso (Desofuscar):**
Un método simple es cambiar `eval` por `echo` en el archivo ofuscado:
```bash
sed 's|eval|echo|g' -i script_ofuscado.sh
bash script_ofuscado.sh > script_desofuscado.sh
```

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

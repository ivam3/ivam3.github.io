# Terminus: complete walkthrough / guía completa

> **Spoilers / Aviso de spoilers**: this guide reveals the full route and the solution to every puzzle. If this is your first playthrough, explore and read the in-game hints first.
>
> **English** | [Español](#español)

Tested with `terminus-game 1.0.0-4` on Termux. The package is available in English and Spanish.

---

# English

## What is Terminus?

Terminus is a text adventure game for learning Linux commands. You explore a world, collect items, talk to characters, and solve puzzles using commands such as `cd`, `ls`, `less`, `touch`, `mv`, `rm`, `cp`, `grep`, and `sudo`.

The Termux package runs the original JavaScript game with Node.js and replaces the browser terminal with a native command-line interface.

## Installation

```bash
pkg update
pkg install terminus-game
terminus-game
```

Useful options:

```bash
terminus-game --esp           # play in Spanish
terminus-game --lang es       # same as --esp
terminus-game --reset         # start a new game (removes the current save)
terminus-game --save FILE     # use a specific save file
terminus-game --no-save       # do not read or write a save file
terminus-game --script FILE   # run commands from a file and exit
terminus-game --images MODE   # auto, chafa, open, off
terminus-game --version       # show version information
terminus-game --help          # show all options
```

The default save file is:

```text
~/.local/share/terminus-game/save.json
```

You can also use the `TERMINUS_SAVE`, `TERMINUS_ROOT`, and `TERMINUS_LANG` environment variables.

## Language support

The game is available in English and Spanish:

```bash
terminus-game --esp
terminus-game --lang es
```

In Spanish mode the narrative text, room descriptions, item descriptions, and help pages are translated. The game commands themselves remain the same (`cd`, `ls`, `less`, `touch`, `mv`, `rm`, `cp`, `grep`, `sudo`...).

## Case sensitivity

Room and item names are case-sensitive. This matters in several puzzles:

- `touch Plank` creates the `Plank` item.
- `touch plank` creates a different item and **does not** open the bridge.
- `mv Boulder SmallHole`, `rm UglyTroll`, and `mv KidnappedChild` must be written exactly as shown.

If a command seems not to work, check the capitalization of the item name first.

## Main route: from Home to Paradise

### 1. From Home to the cave

```bash
cd NorthernMeadow
cd EasternMountains
cd Cave
cd DarkCorridor
cd DankRoom
```

In `DankRoom` there is a large boulder. Move it to open the passage:

```bash
mv Boulder SmallHole
```

### 2. The chamber and the portal

```bash
cd Tunnel
cd StoneChamber
cd Portal
cd TownSquare
```

### 3. Optional farm (before crossing the bridge)

The farm is optional, but it is best to do it now: after crossing the bridge there is no way back to `TownSquare`.

```bash
cd RockyPath
rm LargeBoulder
cd Farm
cp EarOfCorn AnotherEarOfCorn
cd ..
cd ..
```

The first `cd ..` takes you from `Farm` back to `RockyPath`; the second one takes you back to `TownSquare`.

### 4. The broken bridge

```bash
cd BrokenBridge
touch Plank
cd Clearing
```

Remember: `Plank` has a capital `P`. If you type `touch plank`, the bridge will remain broken.

### 5. Optional house

In `Clearing` you can build a house for the crying man:

```bash
mkdir House
```

This is optional and is not required to finish the game.

### 6. The path and the troll cave

```bash
cd OminousLookingPath
rm ThornyBrambles
cd CaveOfDisgruntledTrolls
rm UglyTroll
```

### 7. Optional child rescue (1.0.0-4)

In `CaveOfDisgruntledTrolls` you can free the kidnapped child:

```bash
mv KidnappedChild
```

The rescue is saved with the game: after saving and reloading, the child remains out of the cage. This fix is included in `terminus-game 1.0.0-4` and later. In `1.0.0-3` the command does not work; update the package.

### 8. The Slide and the KernelFiles

```bash
cd Slide
cd KernelFiles
cd MoreKernelFiles
grep password= U_txt
```

The search shows the password:

```text
password=IHTFP
```

### 9. Paradise

```bash
cd ..
sudo less Certificate
```

When `Password:` appears, type:

```text
IHTFP
```

If everything works, you will enter `Paradise` and see the congratulations message. This is the end of the main story.

## Speedrun

If you already know the game and just want a copy-paste sequence from Home to Paradise:

```bash
cd NorthernMeadow
cd EasternMountains
cd Cave
cd DarkCorridor
cd DankRoom
mv Boulder SmallHole
cd Tunnel
cd StoneChamber
cd Portal
cd TownSquare
cd BrokenBridge
touch Plank
cd Clearing
cd OminousLookingPath
rm ThornyBrambles
cd CaveOfDisgruntledTrolls
rm UglyTroll
cd Slide
cd KernelFiles
cd MoreKernelFiles
grep password= U_txt
cd ..
sudo less Certificate
IHTFP
```

This route does not include the optional missions. Add the farm, house, and child rescue steps before entering `Paradise` if you want to complete them.

## Optional missions

### The farm

Do this before crossing the bridge:

```bash
cd RockyPath
rm LargeBoulder
cd Farm
cp EarOfCorn AnotherEarOfCorn
cd ..
cd ..
```

### The crying man's house

Do this in `Clearing`, after crossing the bridge:

```bash
mkdir House
```

### The kidnapped child

Available from `terminus-game 1.0.0-4`. In `CaveOfDisgruntledTrolls`:

```bash
mv KidnappedChild
```

The child is freed in `Clearing`, and the state is preserved when you save and reload.

### MIT, AthenaCluster, and MagicLocker

This is an optional, unfinished branch from the original game. **It is not required to complete the main story** and does not change the ending in `Paradise`.

Do it before entering `Paradise`, because `Paradise` has no exit:

```bash
cd ~
cd MIT
cd AthenaCluster
tellme combo
terminus
add MagicLocker
cd ~
cd MagicLocker
less MoreComing
```

`MoreComing` is the only content in `MagicLocker`; the MIT branch was left unfinished in the original game. It is optional content, not an installation bug.

## Package versions

The Termux package uses its own revision number:

- `1.0.0-3`: baseline rebuild. Keeps the original case-sensitive behavior and does not include the child-rescue fix.
- `1.0.0-4`: adds the persistent kidnapped-child rescue. Everything else remains compatible with `1.0.0-3`.

The upstream game version is reported by `terminus-game --version` together with the vendored upstream commit.

## Troubleshooting

### `touch plank` does not open the bridge

This is intentional: the game is case-sensitive. Use exactly:

```bash
touch Plank
```

### `mv KidnappedChild` does not work

Update to `terminus-game 1.0.0-4` or later. The rescue is not available in `1.0.0-3`.

### I am stuck in `Farm`

From `Farm` you do not leave by typing the room name; use `cd ..` twice:

```bash
cd ..
cd ..
```

### I am stuck in `Paradise`

`Paradise` is the ending and has no exit. Use `--reset` to start another game, or `--save` to use a different save file:

```bash
terminus-game --reset
```

### Images are not displayed

Images are optional. You can disable them or change the rendering mode:

```bash
terminus-game --images off
terminus-game --images chafa
terminus-game --images open
```

`chafa` must be installed for the `chafa` mode. The `open` mode uses `termux-open` to open the image in another application.

## Command reference

| Command | What it does |
| --- | --- |
| `cd ROOM` | Move to a child room |
| `cd ..` | Move to the parent room |
| `cd ~` | Return to `Home` |
| `ls` | List rooms and items |
| `less ITEM` | Inspect an item or read a document |
| `pwd` | Show the current room |
| `touch ITEM` | Create an item, when the room allows it |
| `mv ITEM PLACE` | Move an item to another place |
| `rm ITEM` | Remove an item, when the room allows it |
| `cp ITEM NEW_ITEM` | Copy an item, when the room allows it |
| `grep TEXT FILE` | Search for text inside a file |
| `sudo COMMAND` | Run a privileged command |
| `mkdir ROOM` | Create a room, when the room allows it |
| `man` | Ask the OldMan for help |

## Final summary

- Main-story ending: `Paradise`, reached with `sudo less Certificate` and the password `IHTFP`.
- MIT/`MagicLocker`: optional and unfinished; `MoreComing` is all there is.
- Child rescue: optional, included from `1.0.0-4`, and persistent in the save.
- Case sensitivity is kept on purpose so the original difficulty is not changed.

<a id="español"></a>

##########################
## Traducción al español #
##########################

# Español

## ¿Qué es Terminus?

Terminus es un juego de aventuras de texto para aprender comandos de Linux. Exploras un mundo, recoges objetos, hablas con personajes y resuelves puzles usando comandos como `cd`, `ls`, `less`, `touch`, `mv`, `rm`, `cp`, `grep` y `sudo`.

El paquete de Termux ejecuta el juego JavaScript original con Node.js y sustituye la terminal del navegador por una interfaz de línea de comandos nativa.

## Instalación

```bash
pkg update
pkg install terminus-game
terminus-game
```

Opciones útiles:

```bash
terminus-game --esp           # jugar en español
terminus-game --lang es       # equivalente a --esp
terminus-game --reset         # empezar una partida nueva (elimina el guardado actual)
terminus-game --save ARCHIVO  # usar un archivo de guardado concreto
terminus-game --no-save       # no leer ni escribir el guardado
terminus-game --script ARCHIVO # ejecutar comandos de un archivo y salir
terminus-game --images MODO   # auto, chafa, open, off
terminus-game --version       # mostrar información de versión
terminus-game --help          # mostrar todas las opciones
```

El archivo de guardado por defecto es:

```text
~/.local/share/terminus-game/save.json
```

También puedes usar las variables de entorno `TERMINUS_SAVE`, `TERMINUS_ROOT` y `TERMINUS_LANG`.

## Idiomas disponibles

El juego está disponible en inglés y español:

```bash
terminus-game --esp
terminus-game --lang es
```

En el modo español se traducen el texto narrativo, las descripciones de salas y objetos y las páginas de ayuda. Los comandos del juego siguen siendo los mismos (`cd`, `ls`, `less`, `touch`, `mv`, `rm`, `cp`, `grep`, `sudo`...).

## Mayúsculas y minúsculas

Los nombres de salas y objetos distinguen mayúsculas de minúsculas. Esto es importante en varios puzles:

- `touch Plank` crea el objeto `Plank`.
- `touch plank` crea otro objeto distinto y **no** abre el puente.
- `mv Boulder SmallHole`, `rm UglyTroll` y `mv KidnappedChild` deben escribirse exactamente así.

Si un comando parece no funcionar, comprueba primero las mayúsculas y minúsculas del nombre.

## Ruta principal: de Home a Paradise

### 1. De Home a la cueva

```bash
cd NorthernMeadow
cd EasternMountains
cd Cave
cd DarkCorridor
cd DankRoom
```

En `DankRoom` hay una piedra enorme. Muévela para abrir el paso:

```bash
mv Boulder SmallHole
```

### 2. La cámara y el portal

```bash
cd Tunnel
cd StoneChamber
cd Portal
cd TownSquare
```

### 3. La granja opcional (antes de cruzar el puente)

La granja es opcional, pero conviene hacerla ahora: después de cruzar el puente no hay vuelta a `TownSquare`.

```bash
cd RockyPath
rm LargeBoulder
cd Farm
cp EarOfCorn AnotherEarOfCorn
cd ..
cd ..
```

El primer `cd ..` te devuelve de `Farm` a `RockyPath`; el segundo te devuelve a `TownSquare`.

### 4. El puente roto

```bash
cd BrokenBridge
touch Plank
cd Clearing
```

Recuerda: `Plank` va con mayúscula. Si escribes `touch plank`, el puente seguirá roto.

### 5. La casa opcional

En `Clearing` puedes crear una casa para el hombre que llora:

```bash
mkdir House
```

Es opcional y no es necesaria para terminar el juego.

### 6. El camino y la cueva de los trolls

```bash
cd OminousLookingPath
rm ThornyBrambles
cd CaveOfDisgruntledTrolls
rm UglyTroll
```

### 7. El rescate opcional (1.0.0-4)

En `CaveOfDisgruntledTrolls` puedes liberar a la niña secuestrada:

```bash
mv KidnappedChild
```

El rescate se guarda en la partida: al guardar y recargar, la niña sigue fuera de la jaula. Esta corrección está incluida desde `terminus-game 1.0.0-4`. En `1.0.0-3` el comando no funciona; actualiza el paquete.

### 8. El Slide y los KernelFiles

```bash
cd Slide
cd KernelFiles
cd MoreKernelFiles
grep password= U_txt
```

La búsqueda muestra la contraseña:

```text
password=IHTFP
```

### 9. Paradise

```bash
cd ..
sudo less Certificate
```

Cuando aparezca `Password:` o `Contraseña:`, escribe:

```text
IHTFP
```

Si todo va bien, entrarás en `Paradise` y verás el mensaje de felicitación. Es el final de la historia principal.

## Ruta rápida

Si ya conoces el juego y solo quieres una secuencia copiable de Home a Paradise:

```bash
cd NorthernMeadow
cd EasternMountains
cd Cave
cd DarkCorridor
cd DankRoom
mv Boulder SmallHole
cd Tunnel
cd StoneChamber
cd Portal
cd TownSquare
cd BrokenBridge
touch Plank
cd Clearing
cd OminousLookingPath
rm ThornyBrambles
cd CaveOfDisgruntledTrolls
rm UglyTroll
cd Slide
cd KernelFiles
cd MoreKernelFiles
grep password= U_txt
cd ..
sudo less Certificate
IHTFP
```

Esta ruta no incluye las misiones opcionales. Si quieres hacerlas, añade los pasos de la granja, la casa y el rescate antes de entrar en `Paradise`.

## Misiones opcionales

### La granja

Se hace antes de cruzar el puente:

```bash
cd RockyPath
rm LargeBoulder
cd Farm
cp EarOfCorn AnotherEarOfCorn
cd ..
cd ..
```

### La casa del hombre que llora

Se hace en `Clearing`, después de cruzar el puente:

```bash
mkdir House
```

### La niña secuestrada

Disponible desde `terminus-game 1.0.0-4`. En `CaveOfDisgruntledTrolls`:

```bash
mv KidnappedChild
```

La niña queda libre en `Clearing` y el estado se conserva al guardar y recargar.

### MIT, AthenaCluster y MagicLocker

Es una rama opcional e inacabada del juego original. **No es necesaria para completar la historia principal** y no cambia el final de `Paradise`.

Hazla antes de entrar en `Paradise`, porque `Paradise` no tiene salida:

```bash
cd ~
cd MIT
cd AthenaCluster
tellme combo
terminus
add MagicLocker
cd ~
cd MagicLocker
less MoreComing
```

`MoreComing` es el único contenido de `MagicLocker`; la rama MIT se quedó sin terminar en el juego original. Es contenido opcional, no un fallo de la instalación.

## Versiones del paquete

El paquete de Termux usa su propio número de revisión:

- `1.0.0-3`: reconstrucción de línea base. Mantiene el comportamiento original sensible a mayúsculas y no incluye el rescate de la niña.
- `1.0.0-4`: añade el rescate persistente de la niña secuestrada. El resto sigue siendo compatible con `1.0.0-3`.

La versión del juego original se muestra con `terminus-game --version` junto con el commit de origen incluido.

## Solución de problemas

### `touch plank` no abre el puente

Es intencionado: el juego distingue mayúsculas de minúsculas. Usa exactamente:

```bash
touch Plank
```

### `mv KidnappedChild` no funciona

Actualiza a `terminus-game 1.0.0-4` o superior. El rescate no está disponible en `1.0.0-3`.

### Estoy atrapado en `Farm`

Desde `Farm` no se sale escribiendo el nombre de la sala; usa `cd ..` dos veces:

```bash
cd ..
cd ..
```

### Estoy atrapado en `Paradise`

`Paradise` es el final y no tiene salida. Usa `--reset` para empezar otra partida o `--save` para usar otro archivo de guardado:

```bash
terminus-game --reset
```

### El juego no muestra imágenes

Las imágenes son opcionales. Puedes desactivarlas o cambiar el modo de renderizado:

```bash
terminus-game --images off
terminus-game --images chafa
terminus-game --images open
```

`chafa` debe estar instalado para el modo `chafa`. El modo `open` usa `termux-open` para abrir la imagen en otra aplicación.

## Referencia de comandos

| Comando | Qué hace |
| --- | --- |
| `cd SALA` | Moverse a una sala hija |
| `cd ..` | Moverse a la sala padre |
| `cd ~` | Volver a `Home` |
| `ls` | Listar salas y objetos |
| `less OBJETO` | Examinar un objeto o leer un documento |
| `pwd` | Mostrar la sala actual |
| `touch OBJETO` | Crear un objeto, cuando la sala lo permite |
| `mv OBJETO LUGAR` | Mover un objeto a otro lugar |
| `rm OBJETO` | Eliminar un objeto, cuando la sala lo permite |
| `cp OBJETO NUEVO_OBJETO` | Copiar un objeto, cuando la sala lo permite |
| `grep TEXTO ARCHIVO` | Buscar texto dentro de un archivo |
| `sudo COMANDO` | Ejecutar un comando con privilegios |
| `mkdir SALA` | Crear una sala, cuando la sala lo permite |
| `man` | Pedir ayuda al anciano |

## Resumen del final

- Final de la historia principal: `Paradise`, entrando con `sudo less Certificate` y la contraseña `IHTFP`.
- MIT/`MagicLocker`: epílogo opcional e inacabado; `MoreComing` es todo lo que hay.
- Rescate de la niña: opcional, incluido desde `1.0.0-4` y persistente en el guardado.
- La sensibilidad a mayúsculas y minúsculas se mantiene a propósito para no alterar la dificultad original.

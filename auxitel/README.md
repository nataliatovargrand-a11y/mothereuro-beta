# Auxitel website

| Path | What it is |
|---|---|
| `auxitel-theme.zip` | WordPress block theme, ready to upload (**Appearance → Themes → Add New → Upload Theme**). Follow `theme/README.md` for pages, forms and WPML. |
| `theme/` | Theme source (same as the zip). |
| `site/` | Static HTML build of the theme: home, `/contacto/`, `/trabaja-con-nosotros/`, `/noticias/`, `404.html`. For previewing, or hosting on any static host. |
| `build/` | Script that regenerates `site/` from `theme/`. |

## Preview locally

```bash
php auxitel/build/build.php          # rebuild site/ after editing theme/
cd auxitel/site && php -S localhost:8000
```

Open http://localhost:8000. The site must be served from the domain root, because its links are root-relative (`/contacto/`).

## Static build vs WordPress

- Forms show a preview notice. In WordPress, Contact Form 7 sends them.
- The language switcher is hidden. It appears in WordPress once WPML is active.
- Noticias shows "No hay noticias todavía". Posts come from WordPress.

## Changes from the delivered theme

- `assets/css/main.css`: `#empresa { overflow-x: clip; }`. Without it, the globe's glow scrolled the page sideways on phones.

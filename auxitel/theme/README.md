# Auxitel — tema WordPress (bloques)

Tema a medida para auxitel.com, creado por Dromos AI. Sustituye a Divi. Es un tema de bloques (FSE): las páginas y el pie se editan desde **Apariencia → Editor**.

## 1. Instalación
1. **Apariencia → Temas → Añadir nuevo → Subir tema** → `auxitel.zip` → Activar.
2. Haga una copia de seguridad antes de cambiar de tema. El contenido de Divi (shortcodes `[et_pb_…]`) no se migra; las páginas nuevas ya vienen maquetadas en el tema.

## 2. Páginas (slugs exactos)
| Página | Slug | Plantilla |
|---|---|---|
| Inicio | `inicio` | (portada automática) |
| Noticias | `noticias` | entradas |
| Contacto | `contacto` | *Contacto* |
| Trabaja con nosotros | `trabaja-con-nosotros` | *Trabaja con nosotros* |

**Ajustes → Lectura**: "Una página estática". Portada = Inicio, Entradas = Noticias.

## 3. Formularios (Contact Form 7)
Instale Contact Form 7 y cree dos formularios con estos **títulos exactos**: `Contacto` y `Trabaja con nosotros`. El tema los inserta solo. Si no existen, se muestra un enlace a comercial@auxitel.com.

**Contacto**
```
<label>Nombre [text* nombre]</label>
<label>Empresa [text empresa]</label>
<label>Email [email* email]</label>
<label>Teléfono [tel telefono]</label>
<label>Mensaje [textarea* mensaje]</label>
<label>Especificación técnica (PDF, máx. 10 MB) [file especificacion limit:10mb filetypes:pdf|zip|dwg]</label>
[acceptance privacidad] Acepto la <a href="/politica-de-privacidad/">política de privacidad</a>. [/acceptance]
[submit "Enviar"]
```

**Trabaja con nosotros**
```
<label>Nombre [text* nombre]</label>
<label>Email [email* email]</label>
<label>Teléfono [tel telefono]</label>
<label>Puesto de interés [text puesto]</label>
<label>Mensaje [textarea mensaje]</label>
<label>CV (PDF, máx. 5 MB) [file* cv limit:5mb filetypes:pdf|doc|docx]</label>
[acceptance privacidad] Acepto la <a href="/politica-de-privacidad/">política de privacidad</a>. [/acceptance]
[submit "Enviar candidatura"]
```
En la pestaña *Correo*, añada `[especificacion]` / `[cv]` en "Adjuntos de archivo".

## 4. Idiomas (WPML)
El selector compacto (globo + ES/EN/RO/PT) aparece en la cabecera cuando WPML está activo. Los textos del tema usan el dominio `auxitel` y se traducen en **WPML → Traducción de cadenas**.

## 5. Pendiente antes de publicar
- [ ] Enlaces de **Política de calidad** y **Política de RSC** (ahora `#`): Editor → Patrones → *Calidad*.
- [ ] Comprobar que las URL de los 3 certificados PDF siguen vigentes.
- [ ] Imágenes: la foto de la Tierra nocturna es de la NASA (dominio público, crédito recomendado). Revise la licencia de las fotos de soluciones y sectores, o sustitúyalas por fotos propias de planta.
- [ ] Logos de clientes: confirmar permiso para mostrarlos.
- [ ] Páginas legales: Aviso legal, Política de privacidad, Política de cookies.

## 6. Técnico
- WordPress ≥ 6.6, PHP ≥ 7.4. Sin dependencias de terceros, sin jQuery.
- Fuentes autoalojadas (Archivo + IBM Plex Mono, licencia OFL): no hay llamadas a Google Fonts (RGPD).
- Color de acento: burdeos `#8E2A3E` (Estilos globales).
- Patrones editables en `/patterns`, CSS en `assets/css/main.css`.

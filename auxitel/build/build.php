<?php
/**
 * Static build of the Auxitel block theme.
 *
 * Renders the theme's own templates and patterns (theme/) into plain HTML
 * (site/), emulating the parts of WordPress the theme relies on:
 * theme.json presets and styles, block layout classes, the navigation block,
 * template parts and the theme's two shortcodes.
 *
 * Usage: php auxitel/build/build.php
 */

$root  = dirname( __DIR__ );
$theme = $root . '/theme';
$out   = $root . '/site';
$base  = '/'; // site is served from the domain root

/* ------------------------------------------------------------------ */
/* Minimal WordPress API used by the patterns                          */
/* ------------------------------------------------------------------ */
define( 'ABSPATH', __DIR__ . '/' );
function __( $t, $d = null ) { return $t; }
function esc_html( $t ) { return htmlspecialchars( (string) $t, ENT_QUOTES, 'UTF-8' ); }
function esc_attr( $t ) { return esc_html( $t ); }
function esc_url( $t ) { return esc_html( $t ); }
function esc_html__( $t, $d = null ) { return esc_html( $t ); }
function esc_attr__( $t, $d = null ) { return esc_attr( $t ); }
function esc_html_e( $t, $d = null ) { echo esc_html( $t ); }
function esc_attr_e( $t, $d = null ) { echo esc_attr( $t ); }
function home_url( $p = '/' ) { global $base; return rtrim( $base, '/' ) . $p; }
function auxitel_img( $file ) { global $base; return esc_url( $base . 'assets/images/' . $file ); }

function render_pattern( $slug ) {
	global $theme;
	$file = $theme . '/patterns/' . preg_replace( '#^auxitel/#', '', $slug ) . '.php';
	ob_start();
	include $file;
	$html = ob_get_clean();
	return preg_replace( '#^\s*/\*\*.*?\*/\s*#s', '', $html ); // drop header docblock (already executed)
}

/* ------------------------------------------------------------------ */
/* Shortcodes                                                          */
/* ------------------------------------------------------------------ */
function shortcode_form( $title ) {
	$common_end = '<p><span class="wpcf7-form-control-wrap"><span class="wpcf7-form-control wpcf7-acceptance"><span class="wpcf7-list-item"><label><input type="checkbox" name="privacidad" value="1" required> <span class="wpcf7-list-item-label">Acepto la <a href="/politica-de-privacidad/">política de privacidad</a>.</span></label></span></span></span></p>';
	$field = function ( $label, $type, $name, $req = false, $extra = '' ) {
		$r = $req ? ' required aria-required="true"' : '';
		if ( 'textarea' === $type ) {
			$input = sprintf( '<textarea name="%s" rows="6" class="wpcf7-form-control wpcf7-textarea"%s></textarea>', $name, $r );
		} else {
			$input = sprintf( '<input type="%s" name="%s" class="wpcf7-form-control wpcf7-%s"%s%s>', $type, $name, $type, $r, $extra );
		}
		return sprintf( '<p><label>%s<span class="wpcf7-form-control-wrap" data-name="%s">%s</span></label></p>', esc_html( $label ), $name, $input );
	};
	if ( 'Trabaja con nosotros' === $title ) {
		$fields = $field( 'Nombre', 'text', 'nombre', true )
			. $field( 'Email', 'email', 'email', true )
			. $field( 'Teléfono', 'tel', 'telefono' )
			. $field( 'Puesto de interés', 'text', 'puesto' )
			. $field( 'Mensaje', 'textarea', 'mensaje' )
			. $field( 'CV (PDF, máx. 5 MB)', 'file', 'cv', true, ' accept=".pdf,.doc,.docx"' )
			. $common_end
			. '<p><input type="submit" value="Enviar candidatura" class="wpcf7-form-control wpcf7-submit"></p>';
	} else {
		$fields = $field( 'Nombre', 'text', 'nombre', true )
			. $field( 'Empresa', 'text', 'empresa' )
			. $field( 'Email', 'email', 'email', true )
			. $field( 'Teléfono', 'tel', 'telefono' )
			. $field( 'Mensaje', 'textarea', 'mensaje', true )
			. $field( 'Especificación técnica (PDF, máx. 10 MB)', 'file', 'especificacion', false, ' accept=".pdf,.zip,.dwg"' )
			. $common_end
			. '<p><input type="submit" value="Enviar" class="wpcf7-form-control wpcf7-submit"></p>';
	}
	return '<div class="wpcf7"><form class="wpcf7-form" data-static-form method="post" novalidate>' . $fields
		. '<div class="wpcf7-response-output" aria-live="polite" hidden></div></form></div>';
}

function do_shortcodes( $text ) {
	$text = trim( $text );
	if ( '[auxitel_idiomas]' === $text ) {
		return ''; // WPML not active: theme outputs nothing.
	}
	if ( preg_match( '/^\[auxitel_formulario titulo="([^"]+)"\]$/', $text, $m ) ) {
		return shortcode_form( $m[1] );
	}
	return $text;
}

/* ------------------------------------------------------------------ */
/* Block rendering                                                     */
/* ------------------------------------------------------------------ */
function add_classes( $tag, $classes ) {
	$classes = trim( $classes );
	if ( '' === $classes ) {
		return $tag;
	}
	if ( preg_match( '/\sclass="([^"]*)"/', $tag ) ) {
		return preg_replace( '/\sclass="([^"]*)"/', ' class="$1 ' . $classes . '"', $tag, 1 );
	}
	return preg_replace( '/^<(\w+)/', '<$1 class="' . $classes . '"', $tag );
}

function layout_classes( $layout, $default = 'flow' ) {
	$type = $layout['type'] ?? $default;
	if ( 'constrained' === $type ) {
		return 'is-layout-constrained has-global-padding';
	}
	if ( 'flex' === $type ) {
		$c = 'is-layout-flex';
		if ( ! empty( $layout['justifyContent'] ) ) {
			$c .= ' is-content-justification-' . $layout['justifyContent'];
		}
		if ( ( $layout['orientation'] ?? '' ) === 'vertical' ) {
			$c .= ' is-vertical';
		}
		return $c;
	}
	if ( 'grid' === $type ) {
		return 'is-layout-grid';
	}
	return 'is-layout-flow';
}

function render_navigation( $inner ) {
	preg_match_all( '#<!-- wp:navigation-link (\{.*?\}) /-->#', $inner, $m );
	$items = '';
	foreach ( $m[1] as $json ) {
		$a      = json_decode( $json, true );
		$items .= sprintf(
			'<li class="wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content" href="%s"><span class="wp-block-navigation-item__label">%s</span></a></li>',
			esc_url( $a['url'] ),
			esc_html( $a['label'] )
		);
	}
	return '<nav class="wp-block-navigation is-layout-flex is-content-justification-left" aria-label="Navegación principal">'
		. '<button type="button" class="wp-block-navigation__responsive-container-open" aria-label="Abrir menú" aria-expanded="false"><svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="1.6"/></svg></button>'
		. '<div class="wp-block-navigation__responsive-container"><button type="button" class="wp-block-navigation__responsive-container-close" aria-label="Cerrar menú"><svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="1.6"/></svg></button>'
		. '<ul class="wp-block-navigation__container">' . $items . '</ul></div></nav>';
}

function render_blocks( $html ) {
	// Patterns and template parts (recursive).
	$html = preg_replace_callback(
		'#<!-- wp:pattern \{"slug":"([^"]+)"\} /-->#',
		function ( $m ) { return render_blocks( render_pattern( $m[1] ) ); },
		$html
	);
	$html = preg_replace_callback(
		'#<!-- wp:template-part \{"slug":"(header|footer)"[^}]*\} /-->#',
		function ( $m ) {
			global $theme;
			$part = file_get_contents( "$theme/parts/{$m[1]}.html" );
			return "<{$m[1]} class=\"wp-block-template-part\">" . render_blocks( $part ) . "</{$m[1]}>";
		},
		$html
	);

	// Navigation block.
	$html = preg_replace_callback(
		'#<!-- wp:navigation (\{.*?\}) -->(.*?)<!-- /wp:navigation -->#s',
		function ( $m ) { return render_navigation( $m[2] ); },
		$html
	);

	// Shortcode blocks.
	$html = preg_replace_callback(
		'#<!-- wp:shortcode -->(.*?)<!-- /wp:shortcode -->#s',
		function ( $m ) { return do_shortcodes( $m[1] ); },
		$html
	);

	// Query loop (Noticias): no posts in a static build.
	$html = preg_replace(
		'#<!-- wp:query (\{.*?\}) -->\s*<div class="([^"]*)">.*?<!-- /wp:query -->#s',
		'<div class="$2"><p>No hay noticias todavía.</p></div>',
		$html
	);

	// Layout classes: inject into the element that follows each block comment.
	$html = preg_replace_callback(
		'#<!-- wp:(group|buttons|cover|quote|button|image|heading|paragraph)(?: (\{.*?\}))? -->\s*(<\w+[^>]*>)#s',
		function ( $m ) {
			$name  = $m[1];
			$attrs = ! empty( $m[2] ) ? json_decode( $m[2], true ) : array();
			$tag   = $m[3];
			switch ( $name ) {
				case 'group':
					$tag = add_classes( $tag, layout_classes( $attrs['layout'] ?? array() ) );
					break;
				case 'buttons':
					$tag = add_classes( $tag, layout_classes( $attrs['layout'] ?? array( 'type' => 'flex' ), 'flex' ) );
					break;
				case 'quote':
					$tag = add_classes( $tag, 'is-layout-flow' );
					break;
				case 'cover':
					$GLOBALS['cover_layout_stack'][] = layout_classes( $attrs['layout'] ?? array( 'type' => 'constrained' ) );
					break;
			}
			return $tag;
		},
		$html
	);
	// Cover inner containers, in document order.
	$html = preg_replace_callback(
		'#<div class="wp-block-cover__inner-container">#',
		function () {
			$c = array_shift( $GLOBALS['cover_layout_stack'] ) ?? 'is-layout-flow';
			return '<div class="wp-block-cover__inner-container ' . $c . '">';
		},
		$html
	);

	// Drop remaining block delimiters.
	$html = preg_replace( '#<!-- /?wp:[^>]*?-->\n?#s', '', $html );
	return $html;
}
$GLOBALS['cover_layout_stack'] = array();

/* ------------------------------------------------------------------ */
/* Global styles from theme.json                                       */
/* ------------------------------------------------------------------ */
function fluid_size( $size, $fluid, $min_vw = 20, $max_vw = 82.5 ) {
	if ( false === $fluid || ! preg_match( '/^([\d.]+)rem$/', $size, $m ) ) {
		return $size;
	}
	$max = (float) $m[1];
	if ( is_array( $fluid ) ) {
		$min = (float) $fluid['min'];
		$max = (float) $fluid['max'];
	} else {
		$factor = min( max( 1 - 0.075 * log( $max, 2 ), 0.25 ), 0.75 );
		$min    = max( round( $max * $factor, 3 ), 0.875 );
	}
	if ( $min >= $max ) {
		return $size;
	}
	$slope = round( 100 * ( $max - $min ) / ( $max_vw - $min_vw ), 3 );
	return sprintf( 'clamp(%srem, %srem + ((1vw - 0.2rem) * %s), %srem)', $min, $min, $slope, $max );
}

function global_styles( $json ) {
	$s   = $json['settings'];
	$st  = $json['styles'];
	$css = ":root{\n";
	foreach ( $s['color']['palette'] as $c ) {
		$css .= "--wp--preset--color--{$c['slug']}:{$c['color']};\n";
	}
	foreach ( $s['typography']['fontSizes'] as $f ) {
		$css .= "--wp--preset--font-size--{$f['slug']}:" . fluid_size( $f['size'], $f['fluid'] ?? true ) . ";\n";
	}
	foreach ( $s['typography']['fontFamilies'] as $f ) {
		$css .= "--wp--preset--font-family--{$f['slug']}:{$f['fontFamily']};\n";
	}
	foreach ( $s['spacing']['spacingSizes'] as $sp ) {
		$css .= "--wp--preset--spacing--{$sp['slug']}:{$sp['size']};\n";
	}
	$css .= "--wp--style--global--content-size:{$s['layout']['contentSize']};\n";
	$css .= "--wp--style--global--wide-size:{$s['layout']['wideSize']};\n";
	$css .= "--wp--style--root--padding-left:{$st['spacing']['padding']['left']};\n";
	$css .= "--wp--style--root--padding-right:{$st['spacing']['padding']['right']};\n";
	$css .= "--wp--style--block-gap:{$st['spacing']['blockGap']};\n}\n";

	foreach ( $s['typography']['fontFamilies'] as $f ) {
		foreach ( $f['fontFace'] as $ff ) {
			$src  = str_replace( 'file:./', '/', $ff['src'][0] );
			$css .= "@font-face{font-family:\"{$ff['fontFamily']}\";font-style:{$ff['fontStyle']};font-weight:{$ff['fontWeight']};font-display:{$ff['fontDisplay']};src:url('$src') format('woff2');}\n";
		}
	}
	foreach ( $s['color']['palette'] as $c ) {
		$css .= ".has-{$c['slug']}-color{color:var(--wp--preset--color--{$c['slug']}) !important;}";
		$css .= ".has-{$c['slug']}-background-color{background-color:var(--wp--preset--color--{$c['slug']}) !important;}\n";
	}
	foreach ( $s['typography']['fontSizes'] as $f ) {
		$css .= ".has-{$f['slug']}-font-size{font-size:var(--wp--preset--font-size--{$f['slug']}) !important;}\n";
	}

	$t    = $st['typography'];
	$css .= "body{margin:0;background-color:{$st['color']['background']};color:{$st['color']['text']};font-family:{$t['fontFamily']};font-size:{$t['fontSize']};line-height:{$t['lineHeight']};}\n";
	$e    = $st['elements'];
	$h    = $e['heading']['typography'];
	$css .= "h1,h2,h3,h4,h5,h6{font-weight:{$h['fontWeight']};line-height:{$h['lineHeight']};letter-spacing:{$h['letterSpacing']};}\n";
	foreach ( array( 'h1', 'h2', 'h3' ) as $lvl ) {
		$ty   = $e[ $lvl ]['typography'];
		$css .= "$lvl{font-size:{$ty['fontSize']};font-weight:{$ty['fontWeight']};" . ( isset( $ty['letterSpacing'] ) ? "letter-spacing:{$ty['letterSpacing']};" : '' ) . "}\n";
	}
	$css .= "a:where(:not(.wp-element-button)){color:{$e['link']['color']['text']};}\n";
	$css .= "a:where(:not(.wp-element-button)):hover{color:{$e['link'][':hover']['color']['text']};}\n";
	$b    = $e['button'];
	$p    = $b['spacing']['padding'];
	$css .= ".wp-element-button,.wp-block-button__link{background-color:{$b['color']['background']};color:{$b['color']['text']};border-radius:{$b['border']['radius']};padding:{$p['top']} {$p['right']} {$p['bottom']} {$p['left']};font-weight:{$b['typography']['fontWeight']};font-size:{$b['typography']['fontSize']};font-family:inherit;line-height:inherit;border-width:0;text-decoration:none;}\n";
	$css .= ".wp-element-button:hover,.wp-block-button__link:hover{background-color:{$b[':hover']['color']['background']};color:{$b[':hover']['color']['text']};}\n";
	return $css;
}

/* ------------------------------------------------------------------ */
/* Page shell                                                          */
/* ------------------------------------------------------------------ */
function page( $title, $template_html, $body_class, $desc, $preload = '' ) {
	return '<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>' . esc_html( $title ) . '</title>
<meta name="description" content="' . esc_attr( $desc ) . '">
' . $preload . '<link rel="stylesheet" href="/assets/css/wp-core.css">
<link rel="stylesheet" href="/assets/css/global-styles.css">
<link rel="stylesheet" href="/assets/css/main.css">
<link rel="icon" href="/assets/images/favicon.svg" type="image/svg+xml">
<script src="/assets/js/main.js" defer></script>
<script src="/assets/js/static.js" defer></script>
</head>
<body class="' . $body_class . '">
<div class="wp-site-blocks">
' . render_blocks( $template_html ) . '
</div>
</body>
</html>
';
}

/* ------------------------------------------------------------------ */
/* Build                                                               */
/* ------------------------------------------------------------------ */
function rrmdir( $d ) {
	if ( ! is_dir( $d ) ) { return; }
	foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $d, FilesystemIterator::SKIP_DOTS ), RecursiveIteratorIterator::CHILD_FIRST ) as $f ) {
		$f->isDir() ? rmdir( $f ) : unlink( $f );
	}
	rmdir( $d );
}
function rcopy( $src, $dst ) {
	@mkdir( $dst, 0755, true );
	foreach ( scandir( $src ) as $f ) {
		if ( '.' === $f || '..' === $f ) { continue; }
		is_dir( "$src/$f" ) ? rcopy( "$src/$f", "$dst/$f" ) : copy( "$src/$f", "$dst/$f" );
	}
}

rrmdir( $out );
rcopy( "$theme/assets", "$out/assets" );
copy( __DIR__ . '/wp-core.css', "$out/assets/css/wp-core.css" );
copy( __DIR__ . '/static.js', "$out/assets/js/static.js" );
copy( __DIR__ . '/favicon.svg', "$out/assets/images/favicon.svg" );
file_put_contents( "$out/assets/css/global-styles.css", global_styles( json_decode( file_get_contents( "$theme/theme.json" ), true ) ) );

$tpl  = function ( $name ) use ( $theme ) { return file_get_contents( "$theme/templates/$name.html" ); };
$desc = 'Auxitel: diseño y fabricación a medida de cableado e integración electromecánica. Más de 37 años, plantas en España, Rumanía y Brasil.';

$pages = array(
	'index.html'                           => array( 'Auxitel · Cableado e integración electromecánica', $tpl( 'front-page' ), 'home page-template-default', '<link rel="preload" as="image" href="/assets/images/hero-tierra-noche.webp" type="image/webp" fetchpriority="high">' . "\n" ),
	'contacto/index.html'                  => array( 'Contacto · Auxitel', $tpl( 'page-contacto' ), 'page page-template-page-contacto', '' ),
	'trabaja-con-nosotros/index.html'      => array( 'Trabaja con nosotros · Auxitel', $tpl( 'page-trabaja-con-nosotros' ), 'page page-template-page-trabaja-con-nosotros', '' ),
	'noticias/index.html'                  => array( 'Noticias · Auxitel', $tpl( 'home' ), 'blog', '' ),
	'404.html'                             => array( 'Página no encontrada · Auxitel', $tpl( '404' ), 'error404', '' ),
);
foreach ( $pages as $path => $p ) {
	@mkdir( dirname( "$out/$path" ), 0755, true );
	file_put_contents( "$out/$path", page( $p[0], $p[1], $p[2], $desc, $p[3] ) );
	echo "built $path\n";
}

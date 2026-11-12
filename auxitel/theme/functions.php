<?php
/**
 * Auxitel — funciones del tema.
 *
 * @package auxitel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AUXITEL_VERSION', '1.0.0' );

/**
 * Soportes del tema y textos traducibles.
 */
function auxitel_setup() {
	load_theme_textdomain( 'auxitel', get_template_directory() . '/languages' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
}
add_action( 'after_setup_theme', 'auxitel_setup' );

/**
 * Estilos y scripts del front.
 */
function auxitel_assets() {
	wp_enqueue_style( 'auxitel-main', get_theme_file_uri( 'assets/css/main.css' ), array(), AUXITEL_VERSION );
	wp_enqueue_script( 'auxitel-main', get_theme_file_uri( 'assets/js/main.js' ), array(), AUXITEL_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
}
add_action( 'wp_enqueue_scripts', 'auxitel_assets' );

/**
 * Precarga de la imagen de portada (mejora el LCP).
 */
function auxitel_preload_hero() {
	if ( is_front_page() ) {
		printf(
			'<link rel="preload" as="image" href="%s" type="image/webp" fetchpriority="high">' . "\n",
			esc_url( get_theme_file_uri( 'assets/images/hero-tierra-noche.webp' ) )
		);
	}
}
add_action( 'wp_head', 'auxitel_preload_hero', 1 );

/**
 * No mostrar la versión de WordPress en el código fuente.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Categoría propia para los patrones del tema.
 */
function auxitel_pattern_category() {
	register_block_pattern_category( 'auxitel', array( 'label' => __( 'Auxitel', 'auxitel' ) ) );
}
add_action( 'init', 'auxitel_pattern_category' );

/**
 * URL de una imagen del tema (para usar dentro de los patrones).
 *
 * @param string $file Nombre del archivo en assets/images.
 * @return string
 */
function auxitel_img( $file ) {
	return esc_url( get_theme_file_uri( 'assets/images/' . $file ) );
}

/**
 * [auxitel_idiomas] — selector de idioma compacto.
 * Usa los idiomas activos de WPML si está instalado; si no, no muestra nada.
 */
function auxitel_language_switcher() {
	$languages = apply_filters( 'wpml_active_languages', null, array( 'skip_missing' => 0 ) );
	if ( empty( $languages ) || ! is_array( $languages ) ) {
		return '';
	}
	$current = '';
	$items   = '';
	foreach ( $languages as $lang ) {
		$code = strtoupper( $lang['language_code'] );
		if ( ! empty( $lang['active'] ) ) {
			$current = $code;
		}
		$items .= sprintf(
			'<li><a href="%1$s" hreflang="%2$s" lang="%2$s"%3$s>%4$s</a></li>',
			esc_url( $lang['url'] ),
			esc_attr( $lang['language_code'] ),
			! empty( $lang['active'] ) ? ' aria-current="true"' : '',
			esc_html( $lang['native_name'] )
		);
	}
	$globe = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>';
	return sprintf(
		'<details class="auxi-lang"><summary aria-label="%1$s">%2$s<span>%3$s</span></summary><ul>%4$s</ul></details>',
		esc_attr__( 'Cambiar idioma', 'auxitel' ),
		$globe,
		esc_html( $current ),
		$items
	);
}
add_shortcode( 'auxitel_idiomas', 'auxitel_language_switcher' );

/**
 * [auxitel_formulario titulo="Contacto"] — muestra el formulario de Contact Form 7
 * con ese título. Si el plugin no está activo, muestra el email como alternativa.
 *
 * @param array $atts Atributos del shortcode.
 * @return string
 */
function auxitel_form( $atts ) {
	$atts = shortcode_atts( array( 'titulo' => 'Contacto' ), $atts, 'auxitel_formulario' );
	if ( function_exists( 'wpcf7_get_contact_form_by_title' ) ) {
		$form = wpcf7_get_contact_form_by_title( $atts['titulo'] );
		if ( $form ) {
			return do_shortcode( sprintf( '[contact-form-7 id="%d"]', (int) $form->id() ) );
		}
	}
	return sprintf(
		'<p class="auxi-form-fallback">%1$s <a href="mailto:comercial@auxitel.com">comercial@auxitel.com</a></p>',
		esc_html__( 'Escríbanos a', 'auxitel' )
	);
}
add_shortcode( 'auxitel_formulario', 'auxitel_form' );

/**
 * Ejecuta los shortcodes de los bloques "Shortcode" usados en plantillas y patrones.
 *
 * @param string $content Contenido renderizado.
 * @param array  $block   Bloque.
 * @return string
 */
function auxitel_render_shortcode_block( $content, $block ) {
	return do_shortcode( trim( $block['innerHTML'] ) );
}
add_filter( 'render_block_core/shortcode', 'auxitel_render_shortcode_block', 10, 2 );

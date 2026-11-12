<?php
/**
 * Title: Cabecera
 * Slug: auxitel/header
 * Categories: auxitel
 * Inserter: no
 */
?>
<!-- wp:group {"className": "auxi-header-wrap", "backgroundColor": "navy-950", "textColor": "white", "layout": {"type": "constrained"}} -->
<div class="wp-block-group auxi-header-wrap has-white-color has-text-color has-navy-950-background-color has-background">
<!-- wp:group {"className": "auxi-header alignwide", "layout": {"type": "default"}} -->
<div class="wp-block-group auxi-header alignwide">
<!-- wp:navigation {"overlayMenu":"mobile","layout":{"type":"flex","justifyContent":"left"},"style":{"spacing":{"blockGap":"1.75rem"}}} -->
<!-- wp:navigation-link {"label":"Soluciones","url":"/#soluciones","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Sectores","url":"/#sectores","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Empresa","url":"/#empresa","kind":"custom","isTopLevelLink":true} /-->
<!-- wp:navigation-link {"label":"Calidad","url":"/#calidad","kind":"custom","isTopLevelLink":true} /-->
<!-- /wp:navigation -->
<!-- wp:html -->
<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Auxitel, inicio"><img src="<?php echo auxitel_img( 'logo-auxitel-blanco.png' ); ?>" alt="Auxitel" width="176" height="49" style="width:176px;height:auto;display:block"/></a>
<!-- /wp:html -->
<!-- wp:group {"className": "auxi-header-actions", "layout": {"type": "default"}} -->
<div class="wp-block-group auxi-header-actions">
<!-- wp:shortcode -->
[auxitel_idiomas]
<!-- /wp:shortcode -->
<!-- wp:buttons {"layout": {"type": "flex"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/contacto/"><?php esc_html_e( 'Contacto', 'auxitel' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

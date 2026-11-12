/**
 * Static-build helpers (not part of the WordPress theme):
 * - mobile menu toggle for the navigation block
 * - form notice, since forms are sent by Contact Form 7 only inside WordPress
 */
( function () {
	document.querySelectorAll( '.wp-block-navigation' ).forEach( function ( nav ) {
		var open = nav.querySelector( '.wp-block-navigation__responsive-container-open' );
		var close = nav.querySelector( '.wp-block-navigation__responsive-container-close' );
		var panel = nav.querySelector( '.wp-block-navigation__responsive-container' );
		if ( ! open || ! panel ) {
			return;
		}
		function set( on ) {
			panel.classList.toggle( 'is-menu-open', on );
			open.setAttribute( 'aria-expanded', on ? 'true' : 'false' );
			document.documentElement.style.overflow = on ? 'hidden' : '';
			( on ? close : open ).focus();
		}
		open.addEventListener( 'click', function () { set( true ); } );
		close.addEventListener( 'click', function () { set( false ); } );
		panel.querySelectorAll( 'a' ).forEach( function ( a ) {
			a.addEventListener( 'click', function () { set( false ); } );
		} );
		document.addEventListener( 'keydown', function ( e ) {
			if ( e.key === 'Escape' && panel.classList.contains( 'is-menu-open' ) ) {
				set( false );
			}
		} );
	} );

	document.querySelectorAll( 'form[data-static-form]' ).forEach( function ( form ) {
		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var out = form.querySelector( '.wpcf7-response-output' );
			out.hidden = false;
			out.innerHTML = 'Vista previa: en WordPress este formulario lo envía Contact Form 7. Mientras tanto, escríbanos a <a href="mailto:comercial@auxitel.com">comercial@auxitel.com</a>.';
		} );
	} );
} )();

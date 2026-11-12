/**
 * Auxitel — interacciones ligeras (sin dependencias).
 * Sectores: convierte la lista en pestañas accesibles que muestran la imagen del sector.
 */
( function () {
	document.documentElement.classList.add( 'js' );

	document.querySelectorAll( '.auxi-sectors' ).forEach( function ( root ) {
		var tabs = Array.prototype.slice.call( root.querySelectorAll( '.auxi-sector-tab' ) );
		var panels = Array.prototype.slice.call( root.querySelectorAll( '.auxi-sector-panel' ) );
		if ( ! tabs.length || tabs.length !== panels.length ) {
			return;
		}
		var list = root.querySelector( '.auxi-sector-tabs' );
		if ( list ) {
			list.setAttribute( 'role', 'tablist' );
			list.setAttribute( 'aria-orientation', 'vertical' );
		}

		function select( index, focus ) {
			tabs.forEach( function ( tab, i ) {
				var on = i === index;
				tab.setAttribute( 'aria-selected', on ? 'true' : 'false' );
				tab.setAttribute( 'tabindex', on ? '0' : '-1' );
				panels[ i ].classList.toggle( 'is-active', on );
				panels[ i ].setAttribute( 'aria-hidden', on ? 'false' : 'true' );
			} );
			if ( focus ) {
				tabs[ index ].focus();
			}
		}

		tabs.forEach( function ( tab, i ) {
			var id = 'auxi-sector-' + i;
			tab.setAttribute( 'role', 'tab' );
			tab.setAttribute( 'id', id + '-tab' );
			tab.setAttribute( 'aria-controls', id );
			panels[ i ].setAttribute( 'id', id );
			panels[ i ].setAttribute( 'role', 'tabpanel' );
			panels[ i ].setAttribute( 'aria-labelledby', id + '-tab' );
			tab.addEventListener( 'click', function () {
				select( i, false );
			} );
			tab.addEventListener( 'keydown', function ( e ) {
				var next = null;
				if ( e.key === 'ArrowDown' || e.key === 'ArrowRight' ) {
					next = ( i + 1 ) % tabs.length;
				} else if ( e.key === 'ArrowUp' || e.key === 'ArrowLeft' ) {
					next = ( i - 1 + tabs.length ) % tabs.length;
				} else if ( e.key === 'Home' ) {
					next = 0;
				} else if ( e.key === 'End' ) {
					next = tabs.length - 1;
				}
				if ( next !== null ) {
					e.preventDefault();
					select( next, true );
				}
			} );
		} );
		select( 0, false );
	} );
} )();

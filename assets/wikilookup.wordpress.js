( function ( $ ) {
	$( document ).ready( function () {
		var settings,
			$popover,
			$container = $( '<div>' ).addClass( 'wikilookup-popover-container' );

		// Set container for the popovers so we don't pollute
		// the CSS if there's another plugin that uses some .popover class
		$( 'body' ).append( $container );

		wp_wikilookup_vars = wp_wikilookup_vars || {};

		settings = wp_wikilookup_vars.settings;

		// Popups
		$( 'body' ).wikilookup( {
			messages: settings.messages,
			trigger: 'mouseenter',
			sources: settings.sources,
			selector: '[data-wl-popup]'
		} );

		$( 'body' ).wikilookup( {
			messages: settings.messages,
			sources: settings.sources,
			selector: '[data-wl-card]',
			prefetch: true
		} );

		// Card displays
		$( '[data-wl-card]' ).each( function () {
			var widget = $( this ).data( 'wl-widget' ),
				$card = $( this ).siblings( '.wl-card' );

			$card.append( widget.$element );
		} );

		// Popup triggers
		if ( settings.trigger === 'click' ) {
			// Trigger == click
			$( '[data-wl-popup]' ).each( function () {
				var self = this;
				$( this ).popover( {
					trigger: 'click',
					delay: { show: 500, hide: 500 },
					animation: true,
					placement: 'auto',
					container: '.wikilookup-popover-container',
					boundary: 'window',
					html: true,
					content: function () {
						var widget = $( this ).data( 'wl-widget' );
						return widget.$element[ 0 ];
					}
				} );

				$( document ).click( function () {
					if (
						!$( self ).is( ':hover' ) &&
						!$( '.popover:hover' ).length
					) {
							$( self ).popover('hide');
					}
				} );
			} );
		} else {
			// Trigger == hover
			// Create the popups
			$( '[data-wl-popup]' ).each( function () {
				$( this ).popover( {
					trigger: 'manual',
					delay: { show: 500, hide: 500 },
					animation: true,
					placement: 'auto',
					container: '.wikilookup-popover-container',
					boundary: 'window',
					html: true,
					content: function () {
						var widget = $( this ).data( 'wl-widget' );
						return widget.$element[ 0 ];
					}
				} )
				.on( 'mouseenter', function () {
					var self = this;
					$( this ).popover( 'show' );

					$( '.popover' ).on( 'mouseleave', function () {
						$( self ).popover('hide');
					} );
				} )
				.on( 'mouseleave', function () {
					var self = this;

					setTimeout( function () {
						if ( !$( '.popover:hover' ).length ) {
							$( self ).popover( 'hide' )
						}
					}, 500 );
				} );
			} );
		}
	} );
}( jQuery) );

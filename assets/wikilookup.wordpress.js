( function ( $ ) {
	$( document ).ready( function () {
		var settings,
			$panel,
			$popover,
			isLoadingPanel = false,
			isMobile = $( window ).width() <= 600,
			$container = $( '<div>' )
				.addClass( 'wikilookup-popover-container' )
				.addClass( 'wl-bootstrap' );

		// Set container for the popovers so we don't pollute
		// the CSS if there's another plugin that uses some .popover class
		$( 'body' ).append( $container );

		wp_wikilookup_vars = wp_wikilookup_vars || {};
		settings = $.extend( { popup: {}, card: {} }, wp_wikilookup_vars.settings );
		// Popups
		$( 'body' ).wikilookup( {
			messages: settings.messages,
			trigger: 'mouseenter',
			sources: settings.sources,
			hideThumb: !!settings.popup.hideThumb,
			selector: '[data-wl-popup]',
			dark: !!settings.dark
		} );

		$( 'body' ).wikilookup( {
			messages: settings.messages,
			sources: settings.sources,
			selector: '[data-wl-card]',
			hideThumb: !!settings.card.hideThumb,
			dark: !!settings.dark,
			prefetch: true
		} );

		// Card displays
		$( '[data-wl-card]' ).each( function () {
			var widget = $( this ).data( 'wl-widget' ),
				$card = $( this ).siblings( '.wl-card' );

			$card.append( widget.$element );
		} );

		// A bit of a hack: We're going to check if we're on a mobile screen.
		// If we are, we'll cancel the popups, and instead show them in a panel
		// that shows up at the bottom (in 'sticky' mode) until the user clicks
		// away.
		// This isn't perfect because it is not fully responsive; if a user
		// loads the screen and then resizes, the initial state is the only thing
		// that counts. This should be fixed in future iterations.
		if ( isMobile ) {
			// For mobile:
			// - Always go on 'click' trigger
			// - Show in a panel and not in a popup

			// Create a panel
			$panel = $( '<div>' )
				.addClass( 'wl-mobile-panel' )
				.toggle( false );
			$( 'body' ).append( $panel );

			$( '[data-wl-popup]' ).on( 'click', function () {
				var widget = $( this ).data( 'wl-widget' ),
					currWidget = $panel.data( 'wl-current-widget' );

				if ( currWidget ) {
					currWidget.$element.detach();
				}

				$panel.append( widget.$element );
				$panel.toggle( true );
				$panel.data( 'wl-current-widget', widget );
				// Mark that this click is the loading click.
				// It will also be intercepted below, in the
				// document click, and by that point we are
				// hovering over the panel. We want to make
				// sure that click doesn't close the panel
				isLoadingPanel = true;
			} );

			// Hide on clicking outside the panel
			$( document ).click( function () {
				if (
					!isLoadingPanel &&
					!$panel.is( ':hover' ) &&
					!$( '.wl-mobile-panel:hover' ).length
				) {
					$panel.toggle( false );
				}
				isLoadingPanel = false;
			} );

		} else {
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

					} )
					.on( 'mouseleave', function () {
						var self = this;

						setTimeout( function () {
							if ( !$( '.popover:hover' ).length ) {
								$( self ).popover( 'hide' )
							}
						}, 500 );
					} );

					$( '.wikilookup-popover-container .popover' ).on( 'mouseleave', function () {
						$( self ).popover('hide');
					} );
				} );
			}

			$( '<style>' )
				.text( '.wikilookup-popover-container .popover { max-width: ' + ( settings.popup.width || '650px' ) + '}' )
				.appendTo( 'head' );
		}
	} );
}( jQuery) );

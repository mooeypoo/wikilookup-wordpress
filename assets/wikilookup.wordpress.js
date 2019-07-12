( function ( $ ) {
	$( document ).ready( function () {
		var settings;

		wp_wikilookup_vars = wp_wikilookup_vars || {};

		settings = wp_wikilookup_vars.settings;

		$( 'body' ).wikilookup( {
			messages: settings.messages,
			trigger: 'mouseenter',
			sources: settings.sources
		} );

		// Create the popups
		$( '[data-wikilookup]' ).each( function () {
			$( this ).popover( {
				trigger: 'manual',
				delay: { show: 500, hide: 500 },
				animation: true,
				placement: 'auto',
				container: 'body',
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
	} );
}( jQuery) );

( function ( $ ) {
	$( document ).ready( function () {
		var settings;

		wp_wikilookup_vars = wp_wikilookup_vars || {};

		settings = wp_wikilookup_vars.settings;

		$( 'body' ).wikilookup( {
			messages: settings.messages,
			trigger: settings.trigger || 'click',
			sources: settings.sources
		} );

		// Create the popups
		$( '[data-wikilookup]' ).each( function () {
			var widget = $( this ).data( 'wl-widget' ),
				popup = new OO.ui.PopupWidget( {
					width: 700,
					$floatableContainer: $( this ),
					$content: widget.$element,
					autoClose: true,
					hideWhenOutOfView: false
				} );

			$( 'body' ).append( popup.$element );
			if ( settings.trigger === 'mouseenter' ) {
				$( this ).hover(
					popup.toggle.bind( popup, true ), // Handler in
					popup.toggle.bind( popup, false ) // Handler out
				);
			} else {
				$( this ).on( 'click', popup.toggle.bind( popup ) );
			}
		} );
	} );
}( jQuery) );

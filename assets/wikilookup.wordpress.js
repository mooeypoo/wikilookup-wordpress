( function ( $ ) {
	$( document ).ready( function () {

		$( 'body' ).wikilookup( {
			sources: {
				'default': {
					useRestbase: true
				},
				'trek': {
					useRestbase: false,
					baseURL: 'https://sto.gamepedia.com/api.php'
				}
			}
		} );

		// Put the view in the display for this demo
		$( '[data-wikilookup]' ).each( function () {
			var widget = $( this ).data( 'wl-widget' ),
				popup = new OO.ui.PopupWidget( {
					width: 700,
					$floatableContainer: $( this ),
					$content: widget.$element,
					autoClose: true
				} );

			$( 'body' ).append( popup.$element );
			$( this ).on( 'click', popup.toggle.bind( popup ) );
		} );
	} );
}( jQuery) );

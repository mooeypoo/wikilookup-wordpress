( function ( $ ) {
	$( document ).ready( function () {
		var settings = $.extend( { popup: {}, card: {} }, wp_wikilookup_vars.settings ),
			popupWidget = new $.wikilookup.PageInfoWidget( { messages: settings.messages, dark: !!settings.dark } ),
			cardWidget = new $.wikilookup.PageInfoWidget( { messages: settings.messages, dark: !!settings.dark } ),
			mockData = {
				title: "Mountain",
				content: "<p class=\"mw-empty-elt\">\n\n</p>\n\n<p class=\"mw-empty-elt\">\n</p>\n\n<p>A <b>mountain</b> is a large landform that rises above the surrounding land in a limited area, usually in the form of a peak. A mountain is generally steeper than a hill. Mountains are formed through tectonic forces or volcanism. These forces can locally raise the surface of the earth. Mountains erode slowly through the action of rivers, weather conditions, and glaciers.</p>",
				thumbnail: {
					source: "https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Monasterio_Khor_Virap%2C_Armenia%2C_2016-10-01%2C_DD_25.jpg/300px-Monasterio_Khor_Virap%2C_Armenia%2C_2016-10-01%2C_DD_25.jpg",
					width: 300,
					height: 153
				},
				url: "https://en.wikipedia.org/wiki/Mountain",
				history: "https://en.wikipedia.org/wiki/Mountain?action=history",
				dir: "ltr",
				wikipedia: true
			},
			updateMessage = function ( widget, key, message ) {
				var $el = widget && widget.$element && widget.$element.find( '.wl-pageInfoWidget-view-' + key );

				if ( $el && $el.length ) {
					$el.text( message );
				}
			};

		popupWidget.setData( mockData );
		popupWidget.setState( 'ready' );
		cardWidget.setData( mockData );
		cardWidget.setState( 'ready' );

		$( '.wl-display-preview-card' ).append( cardWidget.$element );
		$( '.wl-display-preview-popup' ).append( popupWidget.$element );

		// Initialize values
		cardWidget.$element.css( {
			maxWidth: settings.card.width || '100%'
		} );
		popupWidget.$element.css( {
			maxWidth: settings.popup.width || '650px'
		} );
		cardWidget.$thumb.toggle(
			!$( '#wikilookup-card-hideThumb' ).is( ':checked' )
		);
		popupWidget.$thumb.toggle(
			!$( '#wikilookup-popup-hideThumb' ).is( ':checked' )
		);

		// Events
		$( '#wikilookup-dark' ).change( function () {
			cardWidget.toggleDarkMode( $( this ).is( ':checked' ) )
			popupWidget.toggleDarkMode( $( this ).is( ':checked' ) )
		} );
		$( '#wikilookup-popup-width' ).keyup( function () {
			var val = $( this ).val();

			popupWidget.$element.css( {
				maxWidth: val
			} );
		} );
		$( '#wikilookup-card-width' ).keyup( function () {
			var val = $( this ).val();

			cardWidget.$element.css( {
				maxWidth: val
			} );
		} );

		$( '[data-messages]' ).keyup( function () {
			var key = $( this ).attr( 'data-messages' ),
				val = $( this ).val();

			updateMessage( cardWidget, key, val );
			updateMessage( popupWidget, key, val );
		} );
		$( '#wikilookup-card-hideThumb' ).change( function () {
			cardWidget.$thumb.toggle( !$( this ).is( ':checked' ) );
		} );
		$( '#wikilookup-popup-hideThumb' ).change( function () {
			popupWidget.$thumb.toggle( !$( this ).is( ':checked' ) );
		} );
	} );
}( jQuery ) );

( function ( $ ) {
	$( document ).ready( function () {
		var settings;

		// Only loaded for gutenberg editor, to provide information
		// for the preview

		wp_wikilookup_vars = wp_wikilookup_vars || {};
		settings = $.extend( { popup: {}, card: {} }, wp_wikilookup_vars.settings );

		$( 'body' ).wikilookup( {
			messages: settings.messages,
			sources: settings.sources,
			selector: '[data-wl-card]',
			hideThumb: !!settings.card.hideThumb,
			dark: !!settings.dark,
			prefetch: true
		} );
	} );
}( jQuery ) );

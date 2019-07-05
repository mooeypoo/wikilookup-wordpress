( function ( $ ) {
	$( document ).ready( function () {
		var counter = 1;
			$container = $( '#wikilookup-sources' ),
			settings = $.extend( {}, wp_wikilookup_vars ),
			getNewSourceRow = function () {
				var $newSource = $( '.wl-sources-new' )
						.clone()
						.data( 'id', counter )
						.removeClass( 'wl-sources-new' ),
					getName = function ( type ) {
						return  'wikilookup[sources][' + counter + '][' + type + ']';
					};

				$newSource.find( '.wl-sources-inp-name' )
					.attr( 'name', getName( 'name' ) );
				$newSource.find( '.wl-sources-inp-url' )
					.attr( 'name', getName( 'baseURL' ) );
				$newSource.find( '.wl-sources-inp-lang' )
					.attr( 'name', getName( 'lang' ) )
					.val( 'en' );
				$newSource.find( '.wl-sources-inp-restbase' )
					.attr( 'name', getName( 'restBase' ) );

				counter++;
				return $newSource;
			};

		$( '.wl-sources' ).on( 'click', '.wl-sources-inp-delete', function () {
			$( this ).closest( 'tr' ).detach();
			return false;
		} );

		// Add source
		$( '.wl-sources-add' ).click( function () {
			var $newRow = getNewSourceRow();

			$( '#wl-sources-tbody' ).append( $newRow );

			return false;
		} );

		// Validation
		$( '.wl-sources' ).on( 'change', '.wl-sources-inp-name', function () {
			$( this ).removeClass( 'wl-inp-error' );
		} );

		$( '#submit' ).click( function () {
			$emptyNames = $( '.wl-sources-inp-name' )
				.filter( function () {
					return !$( this ).val() && !$( this ).closest( '.wl-sources-new' ).length;
				} )

			if ( $emptyNames.length > 0 ) {
				$emptyNames.addClass( 'wl-inp-error' );
				return false;
			}
		} );
	} );
}( jQuery ) );

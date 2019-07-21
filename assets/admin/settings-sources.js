( function ( $ ) {
	$( document ).ready( function () {
		// TODO: Organize this JS and add tests...
		var counter = 1;
			$container = $( '#wikilookup-sources' ),
			vars = $.extend( {}, wp_wikilookup_vars ),
			settings = vars.settings,
			isWikipediaURL = function ( url ) {
				var pattern = new RegExp(
					'^https?:\/\/({{)?([a-zA-z\-\_]+)?(}})?\.wikipedia\.org',
					'igm'
				);

				return pattern.test( url );
			},
			isUrlValid = function ( url ) {
				var pattern = new RegExp( '^(https?:\\/\\/)?' + // protocol
					'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
					'((\\d{1,3}\\.){3}\\d{1,3}))' + // ip (v4) address
					'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + //port
					'(\\?[;&amp;a-z\\d%_.~+=-]*)?' ); // query string

				return pattern.test( url );
			},
			setPreviewImageURL = function ( $textNode ) {
				var id = $textNode.attr( 'data-id' ),
					str = $textNode.val(),
					valid = isUrlValid( str ),
					// $img = $( '#logo-preview-' + id ),
					$img = $textNode.closest( 'tr' ).find( '.wl-logo-preview' ),
					$wikipediaWarning = $textNode.closest( 'tr' ).find( '.wl-logo-wikipedia-statement' ),
					sourceURL = $textNode.closest( 'tr' ).find( '.wl-sources-inp-url' ).val(),
					isWikipedia = isWikipediaURL( sourceURL );

				if ( !sourceURL ) {
					return;
				}
				$textNode.removeClass( 'wl-inp-error' );
				if ( str && valid && !isWikipedia ) {
					$img.attr( 'src', str );
				}

				$img.toggle( str && valid && !isWikipedia );
				$wikipediaWarning.toggle( isWikipedia );
				$textNode.toggle( !isWikipedia );
			},
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
				$newSource.find( '.wl-sources-inp-logo-url' )
					.attr( 'name', getName( 'logo' ) + '[url]' )
				$newSource.find( '.wl-sources-inp-logo-title' )
					.attr( 'name', getName( 'logo' ) + '[title]' );
				$newSource.find( '.wl-logo-preview' )
					.attr( 'id', 'logo-preview-' + counter );
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
		$( '.wl-sources' ).on( 'change', '.wl-sources-inp-url', function () {
			var val = $( this ).val(),
				urlValid = isUrlValid( val ),
				isWikipedia = isWikipediaURL( val ),
				$logoURLinp = $( this ).closest( 'tr' ).find( '.wl-sources-inp-logo-url' );

			$( this ).toggleClass( 'wl-inp-error', !urlValid );
			// $logoURLinp
			// 	.toggle( !isWikipedia )
			// 	.data( 'wikipedia', isWikipedia );

			setPreviewImageURL( $logoURLinp );
		} );

		$( '.wl-sources' ).on( 'change', '.wl-sources-inp-name', function () {
			$( this ).removeClass( 'wl-inp-error' );
		} );

		$( '.wl-sources' ).on( 'change', '.wl-sources-inp-logo-url', function () {
			setPreviewImageURL( $( this ) );
		} );


		$( '#submit' ).click( function () {
			var $emptyNames = $( '.wl-sources-inp-name' )
				.filter( function () {
					return !$( this ).val() && !$( this ).closest( '.wl-sources-new' ).length;
				} ),
				$invalidUrls = $( '.wl-sources-inp-logo-url' )
				.filter( function () {
					var str = $( this ).val();

					return str && !isUrlValid( str );
				} );

			if ( $emptyNames.length > 0 ) {
				$emptyNames.addClass( 'wl-inp-error' );
				return false;
			}

			if ( $invalidUrls.length > 0 ) {
				$invalidUrls.addClass( 'wl-inp-error' );
				return false;
			}
		} );

		// Initialize
		$( '.wl-sources-inp-logo-url' ).each( function () {
			var val = $( this ).val(),
				urlValid = isUrlValid( val ),
				isWikipedia = isWikipediaURL( val );

			$( this )
				.toggleClass( 'wl-inp-error', urlValid );
				// .toggle( !isWikipedia )
				// .data( 'wikipedia', isWikipedia );

			setPreviewImageURL( $( this ) );
		} );

		$( 'form#wikilookup_settings_form ' ).show();
		$( '.wl-spinner' ).hide();
	} );
}( jQuery ) );

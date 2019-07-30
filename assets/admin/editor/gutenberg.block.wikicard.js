const {registerBlockType} = wp.blocks; //Blocks API
const {createElement} = wp.element; //React.createElement
const {__} = wp.i18n; //translation functions
const {TextControl,SelectControl,ServerSideRender} = wp.components; //WordPress form inputs and server-side renderer

/**
 * Component presenting a preview for the 'card' block
 * using jQuery.Wikilookup library
 *
 * @extends React
 */
class WikilookupCardPreview extends React.Component {
	constructor( props ) {
		super( props );

		this.preview = React.createRef();
		this.widget = new $.wikilookup.PageInfoWidget();
		this.$placeholder = $( '<div>' )
			.addClass( 'wl-gutenberg-empty' )
			.text( __( 'Please select a lookup title.' ) )
			.toggle( false );
		this.processor = $( 'body' ).data( 'wl-processor' );

		// see https://davidwalsh.name/javascript-debounce-function
		this.debounce = function debounce(func, wait, immediate) {
			var timeout;
			return function() {
				var context = this, args = arguments;
				var later = function() {
					timeout = null;
					if (!immediate) func.apply(context, args);
				};
				var callNow = immediate && !timeout;
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
				if (callNow) func.apply(context, args);
			};
		};

		this.updateHandler = this.debounce( this.doUpdate.bind( this ), 250 );
		this.doUpdate();
	}

	doUpdate() {
		// Get the correct source
		const hasTitle = !!this.props.title,
			api = this.processor.getSource( this.props.source ) ||
				this.processor.getSource( 'default' );

		this.widget.$element.toggle( hasTitle );
		this.$placeholder.toggle( !hasTitle );

		if ( hasTitle ) {
			// Fetch the title
			api.getPageInfo( this.props.title, this.props.lang )
			.then(
				function ( result ) {
					this.widget.resetData();
					this.widget.setData( result );
					this.widget.setState( 'ready' );
					this.widget.$element.toggle( true );
				}.bind( this ),
				this.widget.setState.bind( this.widget, 'error' )
			);
		}
	}

	// Update the render with a debounce
	componentDidUpdate() {
		this.updateHandler();
	}

	componentDidMount() {
		const hasTitle = !!this.props.title;
		// Set up the external DOM for jQuery to hook into
		this.$dom = $( this.preview.current );
		this.$dom.append(
			this.$placeholder.toggle( !hasTitle ),
			this.widget.$element.toggle( hasTitle )
		);
	}
	componentWillUnmount() {}

	render( props ) {
		return createElement( 'div',
			{
				className: 'wl-card-wrapper'
			},
			createElement( 'div', {
				className: 'wl-card',
				ref: this.preview
			} )
		)
	}
}

registerBlockType( 'wikilookup/card', {
	title: __( 'Add a Wikilookup Card', 'wikilookup' ),
	category:  __( 'common' ),
	icon: 'feedback',
	attributes:  {
		title : {
			type: 'string'
		},
		source: {
			type: 'string',
			default: ''
		},
		lang: {
			type: 'string',
			default: 'en'
		}
	},
	//display the post title
	edit(props){
		const attributes =  props.attributes;
		const setAttributes =  props.setAttributes;
		const processor = $( 'body' ).data( 'wl-processor' );
		const sourceNames = Object.keys( processor.sources )
			.filter( function ( source ) {
				return source !== 'default'
			} );

		function changeTitle( title ){
			setAttributes( { title } );
		}

		function changeSource( source ){
			setAttributes( { source } );
		}
		function changeLang( lang ){
			setAttributes( { lang } );
		}

		function getLanguageControl() {
			// Only show language control if the baseURL supports it
			const api = processor.getSource( attributes.source );
			if ( api.baseURL.indexOf( '{{lang}}' ) > -1 ) {
				// Show language control
				return createElement( TextControl, {
					value: attributes.lang,
					label: __( 'Wiki language code', 'wikilookup' ),
					onChange: changeLang,
					type: 'string'
				} );
			}

			return null;
		}

		function getSourceDropdown() {
			if ( !sourceNames.length ) {
				return null;
			}
			const options = [ { label: __( 'Default source' ), value: '' } ];

			sourceNames.forEach( function ( name ) {
				options.push( {
					label: name, value: name
				} );
			} );

			return createElement( SelectControl, {
				label: __( 'Wiki source', 'wikilookup' ),
				value: attributes.source,
				options: options,
				onChange: changeSource
			} );
		}

		//Display block preview and UI
		return createElement('div', {}, [
			createElement( WikilookupCardPreview, {
				title: attributes.title,
				lang: attributes.lang,
				source: attributes.source
			} ),
			//Block inspector
			createElement( 'div', null,
				[
					createElement( TextControl, {
						value: attributes.title,
						label: __( 'Lookup term', 'wikilookup' ),
						onChange: changeTitle,
						type: 'string'
					} ),
					getLanguageControl(),
					getSourceDropdown()
				]
			)
		] )
	},
	save( props ){
		return createElement( 'div',
			{ className: 'wl-card-wrapper' },
			createElement( 'span', {
				'data-wl-title': props.attributes.title,
				'data-wl-source': props.attributes.source,
				'data-wl-lang': props.attributes.lang,
				'data-wl-card': '1'
			} ),
			createElement( 'div', { className: 'wl-card' } )
		)
	}
});

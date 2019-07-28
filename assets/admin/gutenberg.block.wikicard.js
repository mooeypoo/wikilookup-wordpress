const {registerBlockType} = wp.blocks; //Blocks API
const {createElement} = wp.element; //React.createElement
const {__} = wp.i18n; //translation functions
const {TextControl,SelectControl,ServerSideRender} = wp.components; //WordPress form inputs and server-side renderer

class WikilookupCardPreview extends React.Component {
	constructor( props ) {
		super( props );

		this.preview = React.createRef();
		this.widget = new $.wikilookup.PageInfoWidget();
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
	}

	doUpdate() {
		// Get the correct source
		const api = this.processor.getSource( this.props.source ) ||
			this.processor.getSource( 'default' );

		// Fetch the title
		api.getPageInfo( this.props.title, this.props.lang )
			.then(
				function ( result ) {
					this.widget.resetData();
					this.widget.setData( result );
					this.widget.setState( 'ready' );
				}.bind( this ),
				this.widget.setState.bind( this.widget, 'error' )
			);
	}

	// Update the render with a debounce
	componentDidUpdate() {
		this.updateHandler();
	}

	componentDidMount() {
		this.$dom = $( this.preview.current );
		this.$dom.append( this.widget.$element );
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
	title: __( 'Add a Wikilookup Card' ), // Block title.
	category:  __( 'common' ), //category
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
					createElement( TextControl, {
						value: attributes.lang,
						label: __( 'Wiki language', 'wikilookup' ),
						onChange: changeLang,
						type: 'string'
					} ),
					sourceNames.length > 0 ?
						createElement( TextControl, {
							value: attributes.source,
							label: __( 'External wiki name', 'wikilookup' ),
							onChange: changeSource,
							type: 'string'
						} ) : null,
				]
			)
		] )
	},
	save(){
		return null;//save has to exist. This all we need
	}
});

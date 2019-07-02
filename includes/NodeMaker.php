<?php

namespace Wikilookup;

class NodeMaker {
	protected $dom;
	protected $shortcode = 'wikilookup';

	function __construct() {
		$this->dom = new \DOMDocument('1.0', 'utf-8');
	}

	public function makeNode( $content, $domAttributes ) {
		$domElement = $this->dom->createElement( 'span' );
		$domElement->nodeValue = $content;
		$domElement->setAttribute( 'data-wikilookup', null );

		foreach ( $domAttributes as $attr => $val ) {
			$domElement->setAttribute( $attr, $val );
		}
		return $domElement->ownerDocument->saveXML( $domElement );
	}
}

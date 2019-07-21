<?php

namespace Wikilookup;

class NodeMaker {
	protected $dom;
	protected $shortcode = 'wikilookup';

	function __construct() {
		$this->dom = new \DOMDocument('1.0', 'utf-8');
	}

	public function makeNode( $content, $domAttributes, $nodeType = 'span', $outputHTML = true ) {
		$domElement = $this->dom->createElement( $nodeType );
		$domElement->nodeValue = $content;

		foreach ( $domAttributes as $attr => $val ) {
			$domElement->setAttribute( $attr, $val );
		}

		if ( $outputHTML ) {
			return $domElement->ownerDocument->saveXML( $domElement );
		}
		return $domElement;
	}

	public function wrap( $nodes, $attrs ) {
		$domElement = $this->dom->createElement( 'div' );

		foreach ( $nodes as $node ) {
			$domElement->appendChild( $node );
		}

		foreach ( $attrs as $attr => $val ) {
			$domElement->setAttribute( $attr, $val );
		}
		return $domElement->ownerDocument->saveXML( $domElement );
	}
}

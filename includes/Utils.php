<?php

namespace Wikilookup;

class Utils {
	static function getIfExists( $arr, $prop, $default = null ) {
		return isset( $arr[ $prop ] ) ?
			$arr[ $prop ] : $default;
	}

	static function getPropValue( $arr, $props, $default = null ) {
		$ref = $arr;

		if ( !is_array( $props) ) {
			$props = [ $props ];
		}

		foreach ( $props as $p ) {
			if ( !isset( $ref[ $p ] ) ) {
				return $default;
			}

			$ref = $ref[ $p ];
		}

		return $ref;
	}
}

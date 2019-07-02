<?php

namespace Wikilookup;

class Loader {
	public static function loadAssets() {
		$scripts = [
			// ooui popup widgets
			'oojs' => [
				'src' => 'assets/ooui/oojs.jquery.js',
				'dependencies' => [ 'jquery' ],
			],
			'ooui-core' => [
				'src' => 'assets/ooui/oojs-ui-core.js',
				'dependencies' => [ 'oojs' ],
			],
			'ooui-widgets' => [
				'src' => 'assets/ooui/oojs-ui-widgets.js',
				'dependencies' => [ 'ooui-core' ],
			],
			'ooui-wikimediaui' => [
				'src' => 'assets/ooui/oojs-ui-wikimediaui.js',
				'dependencies' => [ 'ooui-widgets' ],
			],
			// wikilookup
			'wikilookup' => [
				'src' => 'assets/jquery.wikilookup-0.1.0.min.js',
				'dependencies' => [ 'jquery' ]
			],
			// popup code
			'popup' => [
				'src' => 'assets/wikilookup.wordpress.js',
				'dependencies' => [  'jquery', 'wikilookup', 'ooui-wikimediaui' ],
			]
		];

		$styles = [
			'wikimediaui' => 'assets/css/oojs-ui-wikimediaui.min.css',
			'widgets.wikimediaui' => 'assets/css/oojs-ui-widgets-wikimediaui.min.css',
			'wikilookup' => 'assets/jquery.wikilookup-0.1.0.min.css',
			'popup' => 'assets/css/wikilookup.wordpress.css',
		];

		foreach ( $scripts as $name => $data ) {
			wp_enqueue_script(
				'wikilookup-js-' . $name,
				WIKILOOKUP_PLUGIN_DIR_URL . $data[ 'src'],
				array_map(
					function ( $item ) {
						return $item === 'jquery' ?
							'jquery' :
							'wikilookup-js-' . $item;
					},
					$data[ 'dependencies' ]
				),
				false,
				true // in footer
			);
		}

		foreach ( $styles as $name => $src ) {
			// CSS
			wp_enqueue_style(
				'wikilookup-css-' . $name,
				WIKILOOKUP_PLUGIN_DIR_URL . $src
			);
		}

		// $dataToBePassed = array(
		// 	'home'            => get_stylesheet_directory_uri(),
		// 	'pleaseWaitLabel' => __( 'Please wait...', 'default' )
		// );
		// wp_localize_script( 'popup', 'wp_wikilookup_config', $datatoBePassed );
	}

}

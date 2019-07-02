<?php
/*
* Plugin Name: Wikilookup
* Description: Add popups from wikis to your content posts.
* Version: 1.0
* Author: Moriel Schottlender
* Author URI: https://moriel.smarterthanthat.com
*/
include 'vendor/autoload.php';

define( 'WIKILOOKUP_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

$loader = new Wikilookup\Loader();

// Add Shortcode
function wikilookup_shortcode( $atts , $content = null ) {
	$nodeMaker = new \Wikilookup\NodeMaker();

	return $nodeMaker->makeNode(
		$content,
		[
			'data-wl-title' => Wikilookup\Utils::getPropValue( $atts, 'title', $content ),
			'data-wl-source' => Wikilookup\Utils::getPropValue( $atts, 'source', null ),
			'data-wl-lang' => Wikilookup\Utils::getPropValue( $atts, 'lang', null ),
		]
	);
}

function wikilookup_scripts() {
	$loader->loadAssets();
}

// Register shortcode
add_shortcode( 'wikilookup', 'wikilookup_shortcode' );

// Add plugin file
// add_action( 'wp_enqueue_scripts', 'wikilookup_scripts' );
add_action( 'wp_enqueue_scripts', [ 'Wikilookup\Loader', 'loadAssets'  ] );

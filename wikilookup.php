<?php
/*
* Plugin Name: Wikilookup
* Description: Add popups from wikis to your content posts.
* Version: 1.0
* Author: Moriel Schottlender
* Author URI: https://moriel.smarterthanthat.com
*/
include 'vendor/autoload.php';

define( 'WIKILOOKUP_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'WIKILOOKUP_DIR_PATH', plugin_dir_path( __FILE__ ) );

if ( is_admin() ) {
	// Register Script
	add_action( 'admin_enqueue_scripts', 'Wikilookup\Loader::loadSettingsPageAssets' );
	$wikilookup_settings = new Wikilookup\Settings();
}


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

// add_filter( 'plugin_action_links', [ 'Wikilookup\Loader', 'addSettingsLink' ], 10, 5 );
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ 'Wikilookup\Loader', 'addSettingsLink' ], 10, 5 );

// Register shortcode
add_shortcode( 'wikilookup', 'wikilookup_shortcode' );

// Add plugin file
add_action( 'wp_enqueue_scripts', [ 'Wikilookup\Loader', 'loadAssets'  ] );

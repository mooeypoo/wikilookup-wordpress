<?php
/**
 * Wikilookup for Wordpress
 *
 * @package     Wikilookup
 * @author      Moriel Schottlender
 * @copyright   2019 Moriel Schottlender
 * @license     GPL-3.0
 *
 * @wordpress-plugin
 * Plugin Name: Wikilookup
 * Plugin URI:  https://github.com/mooeypoo/wikilookup-wordpress
 * Description: Description of the plugin.
 * Version:     1.0.1
 * Author:      Moriel Schottlender
 * Author URI:  http://moriel.smarterthanthat.com/
 * Text Domain: wikilookup
 * License:     GPL-3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */
include 'vendor/autoload.php';

define( 'WIKILOOKUP_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'WIKILOOKUP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WIKILOOKUP_DIST_VERSION', '0.1.0' );

if ( is_admin() ) {
	// Register Script
	add_action( 'admin_enqueue_scripts', 'Wikilookup\Loader::loadSettingsPageAssets' );
	$wikilookup_settings = new Wikilookup\Settings();
}

// Add Shortcode
function wikipopup_shortcode( $atts , $content = null ) {
	$nodeMaker = new \Wikilookup\NodeMaker();

	return $nodeMaker->makeNode(
		$content,
		[
			'data-wikilookup' => null,
			'data-wl-title' => Wikilookup\Utils::getPropValue( $atts, 'title', $content ),
			'data-wl-source' => Wikilookup\Utils::getPropValue( $atts, 'source', null ),
			'data-wl-lang' => Wikilookup\Utils::getPropValue( $atts, 'lang', null ),
			'data-wl-popup' => true,
		]
	);
}

// Add Shortcode
function wikicard_shortcode( $atts , $content = null ) {
	$nodeMaker = new \Wikilookup\NodeMaker();

	$term = $nodeMaker->makeNode(
		$content,
		[
			'data-wl-title' => Wikilookup\Utils::getPropValue( $atts, 'title', $content ),
			'data-wl-source' => Wikilookup\Utils::getPropValue( $atts, 'source', null ),
			'data-wl-lang' => Wikilookup\Utils::getPropValue( $atts, 'lang', null ),
			'data-wl-card' => true,
			'style' => 'display: none;'
		],
		'span',
		false
	);

	$panel = $nodeMaker->makeNode(
		'',
		[
			'class' => 'wl-card',
		],
		'div',
		false
	);

	return $nodeMaker->wrap(
		[ $term, $panel ],
		[
			'class' => 'wl-card-wrapper'
		]
	);
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ 'Wikilookup\Loader', 'addSettingsLink' ], 10, 5 );

// Register shortcode
add_shortcode( 'wikipopup', 'wikipopup_shortcode' );
add_shortcode( 'wikicard', 'wikicard_shortcode' );

// Add plugin file
add_action( 'wp_enqueue_scripts', [ 'Wikilookup\Loader', 'loadAssets'  ] );

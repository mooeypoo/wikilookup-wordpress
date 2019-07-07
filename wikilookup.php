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
 * Plugin URI:  http://moriel.smarterthanthat.com/
 * Description: Description of the plugin.
 * Version:     1.0.0
 * Author:      Your Name
 * Author URI:  http://moriel.smarterthanthat.com/
 * Text Domain: wikilookup
 * License:     GPL-3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
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

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ 'Wikilookup\Loader', 'addSettingsLink' ], 10, 5 );

// Register shortcode
add_shortcode( 'wikilookup', 'wikilookup_shortcode' );

// Add plugin file
add_action( 'wp_enqueue_scripts', [ 'Wikilookup\Loader', 'loadAssets'  ] );

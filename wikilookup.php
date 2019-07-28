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
 * Description: Add content from Wikipedia and other wikis into your WordPress blog
 * Version:     @@currentTag
 * Author:      Moriel Schottlender
 * Author URI:  http://moriel.smarterthanthat.com/
 * Text Domain: wikilookup
 * License:     GPL-3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include 'vendor/autoload.php';

define( 'WIKILOOKUP_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'WIKILOOKUP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WIKILOOKUP_DIST_VERSION', '0.2.2' );

// Languages
function loadTextDomain() {
	$domain = 'wikilookup';
	$mo_file = WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . get_locale() . '.mo';

	load_textdomain( $domain, $mo_file );
	load_plugin_textdomain(
		$domain,
		false,
		WIKILOOKUP_DIR_PATH . '/languages/'
	);
}
add_action( 'init', 'loadTextDomain' );

if ( is_admin() ) {
	// Register Script
	add_action( 'admin_enqueue_scripts', 'Wikilookup\Loader::loadSettingsPageAssets' );
	$wikilookup_settings = new Wikilookup\Settings();
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ 'Wikilookup\Loader', 'addSettingsLink' ], 10, 5 );

// Register shortcode
add_shortcode( 'wikipopup', 'Wikilookup\Editor::shortcodeWikipopup' );
add_shortcode( 'wikicard', 'Wikilookup\Editor::shortcodeWikicard' );
// Register gutenberg block
add_action( 'init', 'Wikilookup\Editor::registerGutenbergBlock' );

// Add plugin file
add_action( 'wp_enqueue_scripts', [ 'Wikilookup\Loader', 'loadAssets'  ] );

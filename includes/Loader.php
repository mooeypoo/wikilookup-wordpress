<?php

namespace Wikilookup;

class Loader {
	public static function addSettingsLink( $links ) {
		$links['settings'] = '<a href="' .
			admin_url( 'admin.php?page=wikilookup-settings' ) .
			'">' . __('Settings') . '</a>';
		return $links;
	}

	public static function loadSettingsPageAssets( $hook ) {
		if ( $hook !== 'toplevel_page_wikilookup-settings' ) {
			return;
		}

		// jQuery TABS
		wp_enqueue_script(
			'wl-jquery-ui-tabs-js',
			WIKILOOKUP_DIR_URL . 'assets/admin/tabs/jquery-ui.min.js',
			[ 'jquery' ],
			false,
			true // in footer
		);
		wp_enqueue_style(
			'wl-jquery-ui-tabs-css',
			WIKILOOKUP_DIR_URL . 'assets/admin/tabs/jquery-ui.min.css'
		);
		wp_enqueue_style(
			'wl-jquery-ui-tabs-theme.css',
			WIKILOOKUP_DIR_URL . 'assets/admin/tabs/jquery-ui.theme.min.css'
		);
		wp_enqueue_style(
			'wl-jquery-ui-tabs-theme.css',
			WIKILOOKUP_DIR_URL . 'assets/admin/tabs/jquery-ui.structure.min.css'
		);

		// Plugin JS
		wp_enqueue_script(
			'wikilookup-settings-js',
			WIKILOOKUP_DIR_URL . 'assets/admin/settings.js',
			[ 'jquery' ],
			false,
			true // in footer
		);
		// Plugin CSS
		wp_enqueue_style(
			'wikilookup-settings-css',
			WIKILOOKUP_DIR_URL . 'assets/admin/settings.css'
		);

		$jsVars = [
			'settings' => get_option( 'wikilookup_settings' ),
			'currentTab' => \Wikilookup\Utils::getPropValue( $_GET, [ 'tab' ] ),
		];
		wp_localize_script( 'wikilookup-settings-js', 'wp_wikilookup_vars', $jsVars );
	}

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
				'src' => 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.js',
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
			'wikilookup' => 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.css',
			'popup' => 'assets/css/wikilookup.wordpress.css',
			'popup-mobile' => 'assets/css/popup.mobile.corrections.css',
		];

		if ( is_rtl() ) {
			// Replace stylesheets with RTL-specific ones.
			$styles[ 'wikimediaui' ] = 'assets/css/oojs-ui-wikimediaui.rtl.min.css';
			$styles[ 'widgets.wikimediaui' ] = 'assets/css/oojs-ui-widgets-wikimediaui.rtl.min.css';
		}

		foreach ( $scripts as $name => $data ) {
			wp_enqueue_script(
				'wikilookup-js-' . $name,
				WIKILOOKUP_DIR_URL . $data[ 'src'],
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
				WIKILOOKUP_DIR_URL . $src
			);
		}

		$jsVars = [
			// 'home'            => get_stylesheet_directory_uri(),
			'settings' => get_option( 'wikilookup_settings' ),
		];
		wp_localize_script( 'wikilookup-js-popup', 'wp_wikilookup_vars', $jsVars );
	}

}

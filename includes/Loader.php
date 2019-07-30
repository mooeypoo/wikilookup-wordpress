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
		$shouldLoad = false;

		if ( $hook === 'toplevel_page_wikilookup-settings' ) {
			$shouldLoad = true;
			$jsFile = 'settings-main.js';
		} else if ( $hook === 'wikilookup_page_wikilookup-settings-display' ) {
			$shouldLoad = true;
			$jsFile = 'settings-display.js';

			// wikilookup
			wp_enqueue_script(
				'wikilookup-js-settings',
				WIKILOOKUP_DIR_URL . 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.js',
				[ 'jquery' ],
				false,
				true // in footer
			);

			wp_enqueue_style(
				'wikilookup-css-settings',
				WIKILOOKUP_DIR_URL . 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.css'
			);

		} else if ( $hook === 'wikilookup_page_wikilookup-settings-sources' ) {
			$shouldLoad = true;
			$jsFile = 'settings-sources.js';
		}

		if ( !$shouldLoad ) {
			return;
		}

		// Plugin JS
		if ( $jsFile ) {
			wp_enqueue_script(
				'wikilookup-settings-js',
				WIKILOOKUP_DIR_URL . 'assets/admin/' . $jsFile,
				[ 'jquery' ],
				false
				// true // in footer
			);
			$jsVars = [
				'settings' => get_option( 'wikilookup_settings' ),
			];
			wp_localize_script( 'wikilookup-settings-js', 'wp_wikilookup_vars', $jsVars );
		}

		// Plugin CSS
		wp_enqueue_style(
			'wikilookup-settings-css',
			WIKILOOKUP_DIR_URL . 'assets/admin/settings.css'
		);
	}

	public static function loadAssets() {
		$scripts = [
			'bootstrap-bundle-js' => [
				'src' => 'assets/popover/bootstrap.bundle.min.js',
				'dependencies' => [ 'jquery' ],
			],

			// wikilookup
			'wikilookup' => [
				'src' => 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.js',
				'dependencies' => [ 'jquery' ]
			],
			// popup code
			'popup' => [
				'src' => 'assets/wikilookup.wordpress.js',
				'dependencies' => [  'jquery', 'wikilookup' ],
			]
		];
		$styles = [
			'wikilookup' => 'assets/jquery.wikilookup-' . WIKILOOKUP_DIST_VERSION . '.min.css',
			'bootstrap-bundle-css' => 'assets/popover/bootstrap.min.css',
			'popup' => 'assets/css/wikilookup.wordpress.css',
		];

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

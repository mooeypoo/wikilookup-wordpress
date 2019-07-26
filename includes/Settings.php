<?php

namespace Wikilookup;

class Settings {
	protected $settings = [];
	protected $defaults = [];

	public function __construct() {
		$this->settings = get_option( 'wikilookup_settings' );
		$this->defaults = [
			'trigger' => 'mouseenter',
			'dark' => false,
			'messages' => [
				'link' => 'Read more',
				'articleLink' => 'Go to the original article',
				'articleHistory' => 'Article history',
				'pending' => 'Loading...',
				'error' => 'There was a problem loading this page information.'
			],
			'popup' => [
				'width' => '650px',
				'hideThumb' => false,
			],
			'card' => [
				'width' => '100%',
				'hideThumb' => false,
			],
			'sources' => [
				'default' => [
					'baseURL' => 'https://{{lang}}.wikipedia.org/w/api.php',
					'lang' => 'en',
					'useRestbase' => false,
					'logo' => [
						'url' => '',
						'title' => '',
					],
				]
			]
		];
		if ( !$this->settings ) {
			$this->settings = $this->defaults;
		}
		$this->register();
	}

	public function processFormResponse() {
		$view = isset( $_POST['viewName'] ) ? $_POST['viewName'] : 'main';
		$nonceName = 'wikilookup_settings_' . $view . '_form_nonce';
		if (
			!isset( $_POST['wikilookup_settings_form_nonce'] ) ||
			!wp_verify_nonce( $_POST[ 'wikilookup_settings_form_nonce' ], $nonceName )
		) {
			wp_die(
				__( 'Invalid nonce specified', 'Wikilookup' ),
				__( 'Error', 'Wikilookup' ),
				[
							'response' 	=> 403,
							'back_link' => 'admin.php?page=' . $this->plugin_name,
				]
			);
		}
		$results = $_POST[ 'wikilookup' ];
		$page = $_POST[ 'viewName' ];

		// Build sources
		if ( $page === 'sources' ) {
			$sources = [];
			foreach ( $results['sources'] as $index => $data ) {
				$sources[ $data['name'] ] = [
					'baseURL' => Utils::getPropValue( $data, 'baseURL' ),
					'lang' => Utils::getPropValue( $data, 'lang' ),
					'useRestbase' => !!Utils::getPropValue( $data, 'useRestbase' ),
					'logo' => [
						'url' => Utils::getPropValue( $data, [ 'logo', 'url' ] ),
						'title' => Utils::getPropValue( $data, [ 'logo', 'title' ] ),
					]
				];
			}

			$newSettings = [
				'sources' => $sources,
			];
		} else if ( $page === 'display' ) {
			$newSettings = [
				'dark' => isset( $results['dark'] ),
				'messages' => [
					'link' => sanitize_text_field( $results['messages']['link'] ),
					'articleLink' => sanitize_text_field( $results['messages']['articleLink'] ),
					'articleHistory' => sanitize_text_field( $results['messages']['articleHistory'] ),
					'pending' => sanitize_text_field( $results['messages']['pending'] ),
					'error' => sanitize_text_field( $results['messages']['error'] ),
				],
				'popup' => [
					'width' => sanitize_text_field( $results['popup']['width'] ),
					'hideThumb' => isset( $results['popup']['hideThumb'] ),
				],
				'card' => [
					'width' => sanitize_text_field( $results['card']['width'] ),
					'hideThumb' => isset( $results['card']['hideThumb'] ),
				],
			];
		} else if ( $page === 'main' ) {
			$newSettings = [ 'trigger' => $results['trigger'] ];
		}

		// Save
		update_option(
			'wikilookup_settings',
			array_merge(
				$this->settings,
				$newSettings
			)
		);

		$redirectPage = 'wikilookup-settings';
		if ( $view === 'display' ) {
			$redirectPage = 'wikilookup-settings-display';
		} else if ( $view === 'sources' ) {
			$redirectPage = 'wikilookup-settings-sources';
		}

		// Redirect
		wp_redirect(
			esc_url_raw(
				add_query_arg(
					[
						'wl_notice' => 'success',
					],
				admin_url('admin.php?page=' . $redirectPage )
				)
			)
		);
	}

	protected function outputNoticeBox( $type, $message ) {
		if ( $type === 'error' ) {
			$class = 'notice notice-error';
		} else {
			$class = 'notice notice-success';
		}

		return printf(
			'<div class="%1$s"><p>%2$s</p></div>',
			esc_attr( $class ),
			esc_html( $message )
		);
	}

	public function getSettingValue( $param, $default = '' ) {
		$set = Utils::getPropValue( $this->settings, $param, null );
		if ( $set ) {
			return $set;
		}
		return Utils::getPropValue( $this->defaults, $param, $default );
	}

	// TODO: The 'actions' registration should probably go out of this class
	protected function register() {
		// Add post form action
		add_action(
			'admin_post_wikilookup_settings_form_response',
			[ $this, 'processFormResponse' ]
		);

		// Add settings menu
		add_action(
			'admin_menu',
			[ $this, 'createAdminMenus' ]
		);

		// Add settings to the db
		add_action(
			'admin_init',
			[ $this, 'registerSettings' ]
		);
	}

	public function createAdminMenus() {
		// Top menu
		add_menu_page(
			'Wikilookup information', // page_title
			'Wikilookup', // menu_title
			'edit_posts', // capability
			'wikilookup-settings', // menu_slug
			function () {
				$this->outputSettingsPage( 'general_info' );
			},
			'dashicons-admin-comments', // icon_url
			100 // position
		);

		add_submenu_page(
			'wikilookup-settings', // Parent slug
			'Wikilookup : General settings', // Page title
			'General settings', // menu title
			'manage_options', // capability
			'wikilookup-settings-main', // menu_slug
			function () {
				$this->outputSettingsPage( 'main' );
			}
		);

		add_submenu_page(
			'wikilookup-settings', // Parent slug
			'Wikilookup : Display', // Page title
			'Display settings', // menu title
			'manage_options', // capability
			'wikilookup-settings-display', // menu_slug
			function () {
				$this->outputSettingsPage( 'display' );
			}
		);
		add_submenu_page(
			'wikilookup-settings', // Parent slug
			'Wikilookup : External wikis', // Page title
			'External wikis', // menu title
			'manage_options', // capability
			'wikilookup-settings-sources', // menu_slug
			function () {
				$this->outputSettingsPage( 'sources' );
			}
		);
	}

	public function registerSettings() {
		register_setting(
			'wikilookup_settings_group', // option_group
			'wikilookup_settings', // option_name
			[ $this, 'sanitize' ] // sanitize_callback
		);
	}
	public function outputSettingsPage( $page ) {
		$permissions = 'manage_options';
		switch ( $page ) {
			case 'display':
				$title = 'Wikilookup settings : Display settings';
				break;
			case 'sources':
				$title = 'Wikilookup settings : External wikis';
				break;
			case 'main':
				$title = 'Wikilookup : General settings';
				break;
			default:
			case 'general_info':
				$title = 'Wikilookup : General information';
				$permissions = 'edit_posts';
				break;
		}

		$view = new View( $this, $page, $title, $permissions );
		$view->render();
	}

}

<?php

namespace Wikilookup;

class Settings {
	protected $settings = [];
	protected $defaults = [];

	public function __construct() {
		$this->settings = get_option( 'wikilookup_settings' );
		$this->defaults = [
			'trigger' => 'click',
			'messages' => [
				'articleLink' => 'Go to the original article',
				'articleHistory' => 'Article history',
				'pending' => 'Loading...',
				'error' => 'There was a problem loading this page information.'
			],
			'sources' => [
				'default' => [
					'baseURL' => 'https://{{lang}}.wikipedia.org/w/api.php',
					'lang' => 'en',
					'useRestbase' => false
				]
			]
		];

		$this->register();
	}

	public function processFormResponse() {
		if (
			!isset( $_POST['wikilookup_settings_form_nonce'] ) ||
			!wp_verify_nonce( $_POST['wikilookup_settings_form_nonce'], 'wikilookup_settings_form_nonce' )
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
		// Build sources
		$sources = [];
		foreach ( $results['sources'] as $index => $data ) {
			$sources[ $data['name'] ] = [
				'baseURL' => Utils::getPropValue( $data, 'baseURL' ),
				'lang' => Utils::getPropValue( $data, 'lang' ),
				'useRestbase' => !!Utils::getPropValue( $data, 'useRestbase' ),
			];
		}

		$newSettings = [
			'trigger' => $results['trigger'],
			'messages' => [
				'articleLink' => sanitize_text_field( $results['messages']['articleLink'] ),
				'articleHistory' => sanitize_text_field( $results['messages']['articleHistory'] ),
				'pending' => sanitize_text_field( $results['messages']['pending'] ),
				'error' => sanitize_text_field( $results['messages']['error'] ),
			],
			'sources' => $sources,
		];

		// Save
		update_option( 'wikilookup_settings', $newSettings );

		// Redirect
		wp_redirect(
			esc_url_raw(
				add_query_arg(
					[
						'wl_notice' => 'success',
					],
				admin_url('admin.php?page=wikilookup-settings' )
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

	protected function getSettingValue( $param, $default = '' ) {
		$set = Utils::getPropValue( $this->settings, $param, null );
		if ( $set ) {
			return $set;
		}
		return Utils::getPropValue( $this->defaults, $param, $default );
	}

	protected function register() {
		// Add post form action
		add_action(
			'admin_post_wikilookup_settings_form_response',
			[ $this, 'processFormResponse' ]
		);

		// Add settings menu
		add_action(
			'admin_menu',
			// [ $this, 'addMenuPage' ]
			function () {
				add_menu_page(
					'Wikilookup settings', // page_title
					'Wikilookup', // menu_title
					'manage_options', // capability
					'wikilookup-settings', // menu_slug
					[ $this, 'outputSettingsPage' ], // function
					'dashicons-admin-comments', // icon_url
					100 // position
				);
			}
		);
		// Add settings page
		add_action(
			'admin_init',
			[ $this, 'registerSettings' ]
		);
	}

	public function registerSettings() {
		register_setting(
			'wikilookup_settings_group', // option_group
			'wikilookup_settings', // option_name
			[ $this, 'sanitize' ] // sanitize_callback
		);
	}

	public function outputSettingsPage() {
		include_once( WIKILOOKUP_DIR_PATH . '/views/admin_wikilookup.php' );
	}
/*
	public function outputFieldMessagesReadmore( $var ) {

	private function getSettingValue( $key ) {
		return isset( $this->settings[$key] ) ?
			esc_attr( $this->settings[$key] ) : '';
	}

	public function outputField( $type, $key ) {
		var_dump( $type, $key );
		$input = '';
		if ( $type === 'text' ) {
			$input = '<input class="regular-text" type="text" name="wikilookup_settings['.$key.']" id="' .$key .'" value="%s">';
		}

		if ( !$input ) {
			return;
		}

		printf(
			$input,
			$this->getSettingValue( $key )
		);
	}

	public function sanitize( $input ) {}

	/**
	 * Output the HTML for the settings page
	 *
	 * @return [type] [description]
	 *
	public function outputSettingsPage() {
		$this->settings = get_option( 'wikilookup_settings' );
?>
		<div class="wrap">
			<h2>Wikilookup settings</h2>
			<p>Set up your wikilookup popups</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'wikilookup_settings_group' );
					do_settings_sections( 'wikilookup-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
<?php
	// $messages = [
	// 	'pending' => [
	// 		'desc' => 'Loading state',
	// 		'default' => 'Loading...',
	// 	],
	// 	'error' => [
	// 		'desc' => 'Error state',
	// 		'default' => 'There was a problem loading this page information.',
	// 	],
	// 	'link' => [
	// 		'desc' => '"Read more" message',
	// 		'default' => 'Read more',
	// 	],
	// ];
// 	echo '<table class="form-table">';
// 	foreach ( $messages as $type => $data ) {
// 		$value = $messages[$type]['default'];
// 		if (
// 			isset( $this->settings['messages'] ) &&
// 			isset( $this->settings['messages' ][ $type ] )
// 		) {
// 			$value = $this->settings['messages' ][ $type ];
// 		}
// ?>
	<!-- <tr>
		<th><label for="messages-<?php echo $type ?>"><?php echo $data['desc']; ?></label></th>
		<td><input
			type="text"
			id="messages-<?php echo $type ?>"
			name="<?php echo $this->$optionName;?>['messages']['<?php echo $type ?>']"
			value="<?php echo $value;?>"
			style="width: 100%;"
			/>
		</td>
	</tr> -->
<?php
	// }
	// echo '</table>';
					// settings_fields( 'wikilookup_settings_option_group' );
					// do_settings_sections( 'wikilookup-settings-admin' );
					// submit_button();
				// ?>
			<!-- </form>
		</div> -->

<?php
}*/
}

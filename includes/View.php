<?php

namespace Wikilookup;

class View {
	protected $settings;
	protected $name;
	protected $title;
	protected $nonce;
	protected $allowed;

	public function __construct( $settings, $name, $title = 'Wikilookup settings', $permissions = 'manage_options' ) {
		$legalPages = [ 'main', 'display', 'sources' ];

		$this->settings = $settings;
		$this->name = $name;
		$this->title = $title;

		$this->viewFile = in_array( $name, $legalPages ) ?
			'admin_wikilookup_' . $name :
			'admin_wikilookup_general_info';
		$this->action = 'wikilookup_settings_form_response';
		$this->nonce = wp_create_nonce( 'wikilookup_settings_' . $this->name . '_form_nonce' );
		$this->allowed = current_user_can( $permissions );
	}

	public function render() {
		$this->outputHeader();
		$this->outputContent();
		$this->outputFooter();
	}

	/**
	 * Output a notice box
	 *
	 * @param  string $type Notice box type; 'error' or 'success'
	 * @param  string $message The translated message
	 * @return string HTML for the notice box
	 */
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

	/**
	 * Include a php fragment
	 *
	 * @param  string $fileName Fragment filename
	 * @return string Included fragment file
	 */
	protected function includeFragment( $fileName ) {
		include_once( WIKILOOKUP_DIR_PATH . '/views/' . $fileName . '.php' );
	}

	protected function outputContent() {
		if ( !$this->allowed ) {
			return;
		}

		$this->includeFragment( $this->viewFile );
	}

	protected function openForm() {
		echo '<form action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" method="post" id="wikilookup_settings_form">';
		echo '<input type="hidden" name="action" value="wikilookup_settings_form_response" />';
		echo '<input type="hidden" name="viewName" value="' . $this->name . '" />';
		echo '<input type="hidden" name="wikilookup_settings_form_nonce" value="' . $this->nonce .'" />';
	}

	protected function closeForm() {
		submit_button( 'Save settings', 'primary' );
		echo '</form>';
	}
	/**
	 * Output page header
	 *
	 * @return string Page header html
	 */
	protected function outputHeader() {
		if ( !$this->allowed ) {
			$this->outputNoticeBox(
				'error',
				__( 'You do not have permissions to manage these settings.', 'wikilookup' )
			);
			return;
		}

		$this->includeFragment( '_admin_header' );
	}

	/**
	 * Output page footer
	 *
	 * @return string Page footer html
	 */
	protected function outputFooter() {
		$this->includeFragment( '_admin_footer' );
	}
}

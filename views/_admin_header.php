<div class="wrap wl-settings wikilookup">
	<h2><?php echo $this->title; ?></h2>
<?php
	if ( isset($_GET[ 'wl_notice' ]) && ($_GET[ 'wl_notice' ] === 'success' )) {
		$this->outputNoticeBox( 'success', __( 'Settings saved successfully', 'wikilookup' ) );
	} else if ( isset($_GET[ 'wl_notice' ]) && ($_GET[ 'wl_notice' ] === 'fail' )) {
		$this->outputNoticeBox( 'error', __( 'There was a problem saving settings.', 'wikilookup' ) );
	}
?>

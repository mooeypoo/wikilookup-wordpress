<?php
if ( !current_user_can( 'manage_options' ) ) {
?>
	<div class="notice notice-error">
		<p><?php _e( 'You do not have permissions to manage these settings.', 'wikillokup' ); ?></p>
	</div>
<?php
}

$wikilookup_nonce = wp_create_nonce( 'wikilookup_settings_form_nonce' );
?>

<div class="wrap wl-settings wikilookup">
	<h2><?php _e( 'Wikilookup Popup Settings' ) ?></h2>
<?php
	if ( $_GET[ 'wl_notice' ] === 'success' ) {
		$this->outputNoticeBox( 'success', __( 'Settings saved successfully', 'wikilookup' ) );
	} else if ( $_GET[ 'wl_notice' ] === 'fail' ) {
		$this->outputNoticeBox( 'error', __( 'There was a problem saving settings.', 'wikilookup' ) );
	}
?>

	<div style="background-image: url( '<?php echo WIKILOOKUP_DIR_URL; ?>/assets/spinner.gif' );" class="wl-spinner"></div>

	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="wikilookup_settings_form" >
		<input type="hidden" name="action" value="wikilookup_settings_form_response">
		<input type="hidden" name="wikilookup_settings_form_nonce" value="<?php echo $wikilookup_nonce ?>" />
		<input type="hidden" name="wl_tab" value="" />

		<div id="tabs">
			<ul>
				<li><a href="#tabs-messages">Popup display</a></li>
				<li><a href="#tabs-sources">Sources</a></li>
			</ul>
			<div id="tabs-messages">
				<h3>Display Text</h3>
				<table class="form-table">
					<tbody>
						<tr>
							<th><?php _e( 'Text for the "Read more" link' ) ?></td>
							<td><input class="regular-text" id="wikilookup-messages-link" type="text" name="wikilookup[messages][link]" value="<?php echo $this->getSettingValue([ 'messages', 'link']); ?>" /></td>
						</tr>
						<tr>
							<th><?php _e( 'Text for the link to the original article' ) ?></td>
							<td><input class="regular-text" id="wikilookup-messages-articleLink" type="text" name="wikilookup[messages][articleLink]" value="<?php echo $this->getSettingValue([ 'messages', 'articleLink']); ?>" /></td>
						</tr>
						<tr>
							<th><?php _e( 'Text for the link to the article history' ) ?></td>
							<td><input class="regular-text" id="wikilookup-messages-history" type="text" name="wikilookup[messages][articleHistory]" value="<?php echo $this->getSettingValue([ 'messages', 'articleHistory']); ?>" /></td>
						</tr>
						<tr>
							<th><?php _e( 'Text for the pending state' ) ?></td>
							<td><input class="regular-text" id="wikilookup-messages-pending" type="text" name="wikilookup[messages][pending]" value="<?php echo $this->getSettingValue([ 'messages', 'pending']); ?>" /></td>
						</tr>
						<tr>
							<th><?php _e( 'Text for an error state' ) ?></td>
							<td><input class="regular-text" id="wikilookup-messages-error" type="text" name="wikilookup[messages][error]" value="<?php echo $this->getSettingValue([ 'messages', 'error']); ?>" /></td>
						</tr>
					</tbody>
				</table>
			</div><!-- end messages tab -->
			<div id="tabs-sources">
				<div class="wl-sources">
					<h3>Sources <a href="#" class="button button-secondary wl-sources-add"><?php _e( 'Add new' ) ?></a></h3>
					<p class="description">Add sources to be referenced from the shortcode.</p>
					<ul>
						<li><strong>Usage:</strong> To reference a source in your post, use <code>[wikilookup source="source_name"]</code>. Any shortcode without the explicit source reference will use the default source. If the source uses a dynamic language, you can utilize that by using <code>[wikilookup source="sourceName" lang="langCode"]</code></li>
						<li><strong>Display name:</strong> This will appear as the name of the source in the popup. <em>Cannot be overriden if the source is Wikipedia.</em></li>
						<li><strong>Source URL:</strong> If the source uses dynamic language in its URL, use <code>{{lang}}</code>. If it accepts the title in the URL, use <code>{{pageName}}</code></li>
						<li><strong>Logo URL:</strong> Provide a custom logo image for your source. The logo is adjusted to max height of 50px. <em>Cannot be overriden if the source is Wikipedia.</em></li>
						<!-- <li><strong>Restbase:</strong> Only use this option if you know that your source uses Restbase response format.</li> -->
					</ul>
					<table class="form-table" class="wl-sources-table">
						<thead>
							<tr>
								<th class="wl-sources-head-actions">&nbsp;</th>
								<th class="wl-sources-head-name"><?php _e( 'Source name' ) ?></th>
								<th class="wl-sources-head-title"><?php _e( 'Source display name' ) ?></th>
								<th class="wl-sources-head-url"><?php _e( 'Source URL' ) ?></th>
								<th class="wl-sources-head-lang"><?php _e( 'Default language code for {{lang}} (optional)' ) ?></th>
								<th class="wl-sources-head-logo"><?php _e( 'Logo URL' ) ?></th>
								<!-- <th class="wl-sources-head-restbase"><?php _e( 'Expects Restbase response (optional)' ) ?></th> -->
								<th class="wl-sources-head-logo-preview">&nbsp;</th>
							</tr>
						</thead>
						<tbody id="wl-sources-tbody">
		<?php
						$sources = $this->getSettingValue( 'sources' );
						$defaultSource = \Wikilookup\Utils::getPropValue( $sources, 'default' );
						if (
							// If there are no sources
							!count( array_keys( $sources ) ) ||
							// Or if default doesn't exist
							!$defaultSource ||
							(
								count( array_keys( $sources ) ) &&
								$defaultSource
							)
						) {
							// Output the default
		?>
							<tr class="wl-sources-default">
								<td>&nbsp;</td>
								<td>Default
									<input type="hidden" name="wikilookup[sources][0][name]" value="default" />
								</td>
								<td>
									<input class="wl-sources-inp-logo-title" type="text" id="wikilookup-sources-default-logo-title" name="wikilookup[sources][0][logo][title]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, [ 'logo', 'title' ] ); ?>" />
								</td>
								<td>
									<input class="wl-sources-inp-url" type="text" id="wikilookup-sources-default-url" name="wikilookup[sources][0][baseURL]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'baseURL' ); ?>" />
								</td>
								<td><input class="wl-sources-inp-lang" type="text" id="wikilookup-sources-default-lang" name="wikilookup[sources][0][lang]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'lang' ); ?>" /></td>
								<!-- <td><input class="wl-sources-inp-restbase" type="checkbox" id="wikilookup-sources-default-restbase" name="wikilookup[sources][0][useRestbase]" <?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'useRestbase' ) ? 'checked="checked"' : ''; ?>></td> -->
								<td><input data-id="default" class="wl-sources-inp-logo-url" type="text" id="wikilookup-sources-default-logo-url" name="wikilookup[sources][0][logo][url]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, [ 'logo', 'url' ] ); ?>" /></td>
								<td><div class="wl-logo-preview-wrapper"><img class="wl-logo-preview" id="logo-preview-default" /></div></td>
							</tr>
		<?php
						}

						// Output existing sources
						$counter = 1;
						foreach ( $sources as $name => $data ) {
							if ( $name === 'default' ) {
								// We already dealt with the default above
								continue;
							}
		?>
							<tr>
								<td><a href="#" title="<?php _e( 'Remove' ) ?>" class="button button-secondary wl-sources-inp-delete"></a></td>
								<td><input name="wikilookup[sources][<?php echo $counter ?>][name]" class="wl-sources-inp-name" type="text" value="<?php echo $name; ?>" /></td>
								<td><input name="wikilookup[sources][<?php echo $counter ?>][logo][title]" class="wl-sources-inp-logo-title" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['logo', 'title'] ); ?>" /></td>
								<td><input name="wikilookup[sources][<?php echo $counter ?>][baseURL]" class="wl-sources-inp-url" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['baseURL'] ); ?>" /></td>
								<td><input name="wikilookup[sources][<?php echo $counter ?>][lang]" class="wl-sources-inp-lang" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['lang'] ); ?>" /></td>
								<td><input data-id="<?php echo $counter ?>" name="wikilookup[sources][<?php echo $counter ?>][logo][url]" class="wl-sources-inp-logo-url" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['logo', 'url'] ); ?>" /><div class="wl-logo-preview-wrapper"></td>
								<td><img class="wl-logo-preview" id="logo-preview-<?php echo $counter; ?>" /></div></td>
								<!-- <td><input name="wikilookup[sources][<?php echo $counter ?>][useRestbase]" class="wl-sources-inp-restbase" type="checkbox" <?php echo $data['useRestbase'] ? 'checked="checked"' : ''; ?>></td> -->
							</tr>
		<?php
							$counter++;
						}
		?>
							<tr class="wl-sources-new">
								<td><a href="#" class="button button-secondary wl-sources-inp-delete" title="<?php _e( 'Remove' ) ?>"></a></td>
								<td><input class="wl-sources-inp-name" type="text" /></td>
								<td><input class="wl-sources-inp-logo-title" type="text" /></td>
								<td><input class="wl-sources-inp-url" type="text" /></td>
								<td><input class="wl-sources-inp-lang" type="text" /></td>
								<td><input data-id="<?php echo $counter ?>" class="wl-sources-inp-logo-url" type="text" /><div class="wl-logo-preview-wrapper"><img class="wl-logo-preview" id="logo-preview-<?php echo $counter; ?>" /></div></td>
								<td><img class="wl-logo-preview" id="logo-preview-<?php echo $counter; ?>" /></div></td>
								<!-- <td><input class="wl-sources-inp-restbase" type="checkbox"></td> -->
							</tr>
						</tbody>
					</table>
				</div>

			</div><!-- end sources tab -->
		</div>


<?php /*
		// Holding back on this setting until this is resolved https://github.com/mooeypoo/wikilookup-wordpress/issues/5
		<h3>General behavior</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th><?php _e( 'Popup trigger' ) ?></td>
					<td>
						<?php $trigger = $this->getSettingValue('trigger', 'click'); ?>
						<select id="wikilookup-trigger" name="wikilookup[trigger]">
							<option value="click" <?php echo $trigger === 'click' ? 'selected' : ''; ?>>Click</option>
							<option value="mouseenter" <?php echo $trigger === 'mouseenter' ? 'selected' : ''; ?>>Hover</option>
						</select>
						<p class="description">Determines how the popup appears.</p>

					</td>
				</tr>
			</tbody>
		</table>
*/ ?>


		<?php submit_button( 'Save settings', 'primary' ); ?>
	</form>

	<hr />
	<p><a href="https://github.com/mooeypoo/wikilookup-wordpress" target="_blank">Wikilookup for Wordpress</a> was developed by <a href="http://moriel.smarterthanthat.com/" target="_blank">Moriel Schottlender</a>, under an open source license. Please consider <a href="https://github.com/mooeypoo/wikilookup-wordpress" target="_blank">contributing</a>.</p>
</div>

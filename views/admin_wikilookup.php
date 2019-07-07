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

<div class="wrap wl-settings">
	<h2><?php _e( 'Wikilookup Popup Settings' ) ?></h2>
<?php
	if ( $_GET[ 'wl_notice' ] === 'success' ) {
		$this->outputNoticeBox( 'success', __( 'Settings saved successfully', 'wikilookup' ) );
	} else if ( $_GET[ 'wl_notice' ] === 'fail' ) {
		$this->outputNoticeBox( 'error', __( 'There was a problem saving settings.', 'wikilookup' ) );
	}
?>


	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" id="wikilookup_settings_form" >
		<input type="hidden" name="action" value="wikilookup_settings_form_response">
		<input type="hidden" name="wikilookup_settings_form_nonce" value="<?php echo $wikilookup_nonce ?>" />

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

		<h3>Display Text</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th><?php _e( 'Text for the link to the original article' ) ?></td>
					<td><input class="regular-text" id="wikilookup-messages-link" type="text" name="wikilookup[messages][articleLink]" value="<?php echo $this->getSettingValue([ 'messages', 'articleLink']); ?>" /></td>
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

		<div class="wl-sources">
			<h3>Sources <a href="#" class="button button-secondary wl-sources-add"><?php _e( 'Add new' ) ?></a></h3>
			<p class="description">Add sources to be referenced from the shortcode.</p>
			<ul>
				<li><strong>Usage:</strong> To reference a source in your post, use <code>[wikilookup source="source_name"]</code>. Any shortcode without the explicit source reference will use the default source. If the source uses a dynamic language, you can utilize that by using <code>[wikilookup source="sourceName" lang="langCode"]</code></li>
				<li><strong>Source URL:</strong> If the source uses dynamic language in its URL, use <code>{{lang}}</code>. If it accepts the title in the URL, use <code>{{pageName}}</code></li>
				<li><strong>Restbase:</strong> Only use this option if you know that your source uses Restbase response format.</li>
			</ul>
			<table class="form-table" class="wl-sources-table">
				<thead>
					<tr>
						<th class="wl-sources-head-name"><?php _e( 'Source name' ) ?></th>
						<th class="wl-sources-head-url"><?php _e( 'Source URL' ) ?></th>
						<th class="wl-sources-head-lang"><?php _e( 'Default language code (optional)' ) ?></th>
						<th class="wl-sources-head-restbase"><?php _e( 'Expects Restbase response (optional)' ) ?></th>
						<th class="wl-sources-head-actions">&nbsp;</th>
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
						<td>Default
							<input type="hidden" name="wikilookup[sources][0][name]" value="default" />
						</td>
						<td>
							<input class="wl-sources-inp-url" type="text" id="wikilookup-sources-default-url" name="wikilookup[sources][0][baseURL]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'baseURL' ); ?>" />
						</td>
						<td><input class="wl-sources-inp-lang" type="text" id="wikilookup-sources-default-lang" name="wikilookup[sources][0][lang]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'lang' ); ?>" /></td>
						<td><input class="wl-sources-inp-restbase" type="checkbox" id="wikilookup-sources-default-restbase" name="wikilookup[sources][0][useRestbase]" <?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'useRestbase' ) ? 'checked="checked"' : ''; ?>></td>
						<td>&nbsp;</td>
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
						<td><input name="wikilookup[sources][<?php echo $counter ?>][name]" class="wl-sources-inp-name" type="text" value="<?php echo $name ?>" />
						<td><input name="wikilookup[sources][<?php echo $counter ?>][baseURL]" class="wl-sources-inp-url" type="text" value="<?php echo $data['baseURL']; ?>" />
						<td><input name="wikilookup[sources][<?php echo $counter ?>][lang]" class="wl-sources-inp-lang" type="text" value="<?php echo $data['lang']; ?>" />
						<td><input name="wikilookup[sources][<?php echo $counter ?>][useRestbase]" class="wl-sources-inp-restbase" type="checkbox" <?php echo $data['useRestbase'] ? 'checked="checked"' : ''; ?>></td>
						<td><a href="#" class="button button-secondary wl-sources-inp-delete"><?php _e( 'Remove' ) ?></a></td>
					</tr>
<?php
					$counter++;
				}
?>
					<tr class="wl-sources-new">
						<td><input class="wl-sources-inp-name" type="text" />
						<td><input class="wl-sources-inp-url" type="text" />
						<td><input class="wl-sources-inp-lang" type="text" />
						<td><input class="wl-sources-inp-restbase" type="checkbox"></td>
						<td><a href="#" class="button button-secondary wl-sources-inp-delete"><?php _e( 'Remove' ) ?></a></td>
					</tr>
				</tbody>
			</table>
		</div>


		<?php submit_button( 'Save settings', 'primary' ); ?>
	</form>
</div>

<p>Configure the display of Wikilookup's elements.</p>

<h4><?php _e( 'Popup Preview' ); ?></h4>
<p class="description"><code>[wikipopup]mountain[/wikipopup]</code></p>
<div class="wl-display-preview-popup"></div>
<h4><?php _e( 'Card Preview' ); ?></h4>
<p class="description"><code>[wikicard title="mountain"]</code></p>
<div class="wl-display-preview-card"></div>

<?php $this->openForm(); ?>
<h3><?php _e( 'General display settings' ); ?></h3>
<table class="form-table">
	<tbody>
		<tr>
			<th>&nbsp;</td>
			<td>
				<label for="wikilookup[dark]">
					<input type="checkbox" class="regular-text" id="wikilookup-dark" name="wikilookup[dark]" value="1" data-setting="dark" <?php echo $this->settings->getSettingValue(['dark']) ? 'checked' : ''; ?> />
					<?php _e( 'Use dark theme' ) ?>
				</label>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Popup width' ) ?></td>
			<td>
				<input class="regular-text" id="wikilookup-popup-width" type="text" name="wikilookup[popup][width]" value="<?php echo $this->settings->getSettingValue([ 'popup', 'width']); ?>" data-setting="popup-width" />
				<p class="description"><?php _e( 'The popup is best viewed at 650px and above.' ); ?></p>
			</td>
		</tr>
		<tr>
			<th>&nbsp;</td>
			<td>
				<label for="wikilookup[popup][hideThumb]">
					<input type="checkbox" class="regular-text" id="wikilookup-popup-hideThumb" name="wikilookup[popup][hideThumb]" value="1" data-setting="popup-hideThumb" <?php echo $this->settings->getSettingValue([ 'popup', 'hideThumb']) ? 'checked' : ''; ?> />
					<?php _e( 'Hide images in popups' ) ?>
				</label>
			</td>
		</tr>
		<tr>
			<th><?php _e( 'Card width' ) ?></td>
			<td>
				<input class="regular-text" id="wikilookup-card-width" type="text" name="wikilookup[card][width]" value="<?php echo $this->settings->getSettingValue([ 'card', 'width']); ?>" data-setting="card-width" />
			</td>
		</tr>
		<tr>
			<th>&nbsp;</td>
			<td>
				<label for="wikilookup[card][hideThumb]">
					<input type="checkbox" class="regular-text" id="wikilookup-card-hideThumb" name="wikilookup[card][hideThumb]" value="1" data-setting="card-hideThumb" <?php echo $this->settings->getSettingValue([ 'card', 'hideThumb']) ? 'checked' : ''; ?> />
					<?php _e( 'Hide images in cards' ) ?>
				</label>
			</td>
		</tr>
	</tbody>
</table>

<h3><?php _e( 'Display Text' ); ?></h3>
<table class="form-table wl-messages">
	<tbody>
		<tr>
			<th><?php _e( 'Text for the "Read more" link' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-link" type="text" name="wikilookup[messages][link]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'link']); ?>" data-messages="link" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for the link to the article history' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-history" type="text" name="wikilookup[messages][articleHistory]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'articleHistory']); ?>"  data-messages="articleHistory" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for the pending state' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-pending" type="text" name="wikilookup[messages][pending]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'pending']); ?>" data-messages="pending" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for an error state' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-error" type="text" name="wikilookup[messages][error]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'error']); ?>"  data-messages="error" /></td>
		</tr>
	</tbody>
</table>


<?php $this->closeForm(); ?>

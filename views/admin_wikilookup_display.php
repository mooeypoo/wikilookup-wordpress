<p>Configure the display of Wikilookup's elements.</p>

<h3>Display Text</h3>
<?php $this->openForm(); ?>
<table class="form-table">
	<tbody>
		<tr>
			<th><?php _e( 'Text for the "Read more" link' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-link" type="text" name="wikilookup[messages][link]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'link']); ?>" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for the link to the original article' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-articleLink" type="text" name="wikilookup[messages][articleLink]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'articleLink']); ?>" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for the link to the article history' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-history" type="text" name="wikilookup[messages][articleHistory]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'articleHistory']); ?>" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for the pending state' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-pending" type="text" name="wikilookup[messages][pending]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'pending']); ?>" /></td>
		</tr>
		<tr>
			<th><?php _e( 'Text for an error state' ) ?></td>
			<td><input class="regular-text" id="wikilookup-messages-error" type="text" name="wikilookup[messages][error]" value="<?php echo $this->settings->getSettingValue([ 'messages', 'error']); ?>" /></td>
		</tr>
	</tbody>
</table>
<?php $this->closeForm(); ?>

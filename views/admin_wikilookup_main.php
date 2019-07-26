<p><?php _e( 'General configuration of the Wikilookup plugin behavior.', 'wikilookup' ); ?></p>

<?php $this->openForm(); ?>
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e( 'Popup trigger', 'wikilookup' ) ?></td>
				<td>
					<?php $trigger = $this->settings->getSettingValue('trigger', 'click'); ?>
					<select id="wikilookup-trigger" name="wikilookup[trigger]">
						<option value="click" <?php echo $trigger === 'click' ? 'selected' : ''; ?>><?php _e( 'On click', 'wikilookup' ); ?></option>
						<option value="mouseenter" <?php echo $trigger === 'mouseenter' ? 'selected' : ''; ?>><?php _e( 'On hover', 'wikilookup' ); ?></option>
					</select>
					<p class="description"><?php _e( 'Determines how the popup appears.', 'wikilookup' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>

<?php $this->closeForm(); ?>

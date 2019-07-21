<p>General configuration of the Wikilookup plugin behavior.</p>

<?php $this->openForm(); ?>

	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e( 'Popup trigger' ) ?></td>
				<td>
					<?php $trigger = $this->settings->getSettingValue('trigger', 'click'); ?>
					<select id="wikilookup-trigger" name="wikilookup[trigger]">
						<option value="click" <?php echo $trigger === 'click' ? 'selected' : ''; ?>>Click</option>
						<option value="mouseenter" <?php echo $trigger === 'mouseenter' ? 'selected' : ''; ?>>Hover</option>
					</select>
					<p class="description">Determines how the popup appears.</p>
				</td>
			</tr>
		</tbody>
	</table>

<?php $this->closeForm(); ?>

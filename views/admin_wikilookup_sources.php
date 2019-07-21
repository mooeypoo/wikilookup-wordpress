<p><?php _e( 'Wikilookup allows you to pull information from other wikis, not just Wikipedia.' ); ?></p>
<p><?php _e( 'When you edit or write your post, you can reference a source for a specific lookup term by adding <code>source="sourceName"</code>' ); ?></p>
<p><?php _e( 'Define the source names below; the sources must be set to a wiki that runs <a href="https://www.mediawiki.org/" target="_blank">MediaWiki</a> with an entrypoint that includes the <code>api.php</code> at the end. ' ); ?></p>

<?php $this->openForm(); ?>
<div class="wl-sources">
	<h3>
		<?php _e( 'Sources' ); ?>
		<a href="#" class="button button-secondary wl-sources-add"><?php _e( 'Add new source' ) ?></a>
	</h3>
	<table class="form-table" class="wl-sources-table">
		<thead>
			<tr>
				<th class="wl-sources-head-actions">&nbsp;</th>
				<th class="wl-sources-head-name"><?php _e( 'Source name' ) ?></th>
				<th class="wl-sources-head-url"><?php _e( 'Source URL' ) ?></th>
				<th class="wl-sources-head-lang"><?php _e( 'Default language code for {{lang}}' ) ?></th>
				<th class="wl-sources-head-logo"><?php _e( 'Logo URL' ) ?></th>
				<th class="wl-sources-head-logo-preview">&nbsp;</th>
			</tr>
		</thead>
		<tbody id="wl-sources-tbody">
<?php
		$sources = $this->settings->getSettingValue( 'sources' );
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
				<td><?php _e( 'Default source' ); ?>
					<input type="hidden" name="wikilookup[sources][0][name]" value="default" />
				</td>
				<td>
					<input class="wl-sources-inp-url" type="text" id="wikilookup-sources-default-url" name="wikilookup[sources][0][baseURL]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'baseURL' ); ?>" />
				</td>
				<td><input class="wl-sources-inp-lang" type="text" id="wikilookup-sources-default-lang" name="wikilookup[sources][0][lang]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, 'lang' ); ?>" /></td>
				<td><input data-id="default" class="wl-sources-inp-logo-url" type="text" id="wikilookup-sources-default-logo-url" name="wikilookup[sources][0][logo][url]" value="<?php echo \Wikilookup\Utils::getPropValue( $defaultSource, [ 'logo', 'url' ] ); ?>" /><p class="wl-logo-wikipedia-statement description">Wikipedia logo cannot be changed.</p></td>
				<td><img class="wl-logo-preview" id="logo-preview-default" /></td>
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
				<td><input name="wikilookup[sources][<?php echo $counter ?>][baseURL]" class="wl-sources-inp-url" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['baseURL'] ); ?>" /></td>
				<td><input name="wikilookup[sources][<?php echo $counter ?>][lang]" class="wl-sources-inp-lang" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['lang'] ); ?>" /></td>
				<td><input data-id="<?php echo $counter ?>" name="wikilookup[sources][<?php echo $counter ?>][logo][url]" class="wl-sources-inp-logo-url" type="text" value="<?php echo \Wikilookup\Utils::getPropValue( $data, ['logo', 'url'] ); ?>" /><p class="wl-logo-wikipedia-statement description">Wikipedia logo cannot be changed.</p></td>
				<td><img class="wl-logo-preview" id="logo-preview-<?php echo $counter; ?>" /></td>
			</tr>
<?php
			$counter++;
		}
?>
			<tr class="wl-sources-new">
				<td><a href="#" class="button button-secondary wl-sources-inp-delete" title="<?php _e( 'Remove' ) ?>"></a></td>
				<td><input class="wl-sources-inp-name" type="text" /></td>
				<td><input class="wl-sources-inp-url" type="text" /></td>
				<td><input class="wl-sources-inp-lang" type="text" /></td>
				<td><input data-id="<?php echo $counter ?>" class="wl-sources-inp-logo-url" type="text" /><p class="wl-logo-wikipedia-statement description">Wikipedia logo cannot be changed.</p></td>
				<td><img class="wl-logo-preview"/></td>
			</tr>
		</tbody>
	</table>
</div>
<?php $this->closeForm(); ?>

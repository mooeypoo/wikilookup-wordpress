<div class="wl-info">
<?php
	echo '<h2>' . __( 'Welcome to Wikilookup!', 'wikilookup' ) . '</h2>';
	echo '<p>' .
		__( 'This plugin allows you to add popups from <a href="https://www.wikipedia.org/" target="_blank">Wikipedia</a> (and other wikis) into your post content.', 'wikilookup' ) .
		'</p>';
	echo '<p>' .
		__( 'There are two ways to use this plugin: A <strong>popup</strong> and a <strong>card</strong> (poster). Both methods have similar configurable parameters, but are being called in different ways.' ,'wikilookup' ) .
		'</p>';
?>
<h2><?php _e( 'Inserting shortcodes', 'wikilookup' ); ?></h2>
<p><?php _e( 'You can insert popups and cards with <em>shortcodes</em>. These are codes you type into your post as you write. Below is a reference to how to use the shortcodes and what options you can utilize.', 'wikilookup' ); ?></p>

<h3><?php _e( 'Popup options', 'wikilookup' ); ?></h3>
<p><?php _e( 'You can use multiple combinations of the examples below.', 'wikilookup' ); ?></p>
<table class="form-table">
	<tr>
		<th><?php _e( 'Shortcode', 'wikilookup' ); ?></th>
		<th><?php _e( 'Popup trigger', 'wikilookup' ); ?></th>
		<th><?php _e( 'Popup article topic', 'wikilookup' ); ?></th>
		<th><?php _e( 'Description', 'wikilookup' ); ?></th>
	</tr>
	<tr>
		<td><code>[wikipopup]mountains[/wikipopup]</code></td>
		<td><code>mountain</code></td>
		<td>Mountains</td>
		<td><?php _e( 'Creates a popup that shows the article from your default wiki about "Mountains"', 'wikilookup' ); ?></td>
	</tr>
	<tr>
		<td><code>[wikipopup title="mountains"]very high hills[/wikipopup]</code></td>
		<td><code>very high hills</code></td>
		<td>Mountains</td>
		<td><?php _e( 'Creates a popup that shows the article from your default wiki about "Mountains", but the popup appears over the words "very high hills"', 'wikilookup' ); ?></td>
	</tr>
	<tr>
		<td><code>[wikipopup lang="es" title="Montaña"]mountains[/wikipopup]</code></td>
		<td><code>mountains</code></td>
		<td>Montaña</td>
		<td><?php _e( 'Creates a popup that shows the article from the Spanish version of your default wiki about "Montaña"', 'wikilookup' ); ?></td>
	</tr>
	<tr>
		<td><code>[wikipopup source="trek"]Picard[/wikipopup]</code></td>
		<td><code>Picard</code></td>
		<td>Picard</td>
		<td><?php _e( 'Creates a popup that shows the article about "Picard" that is pulled from the external wiki you named "trek"', 'wikilookup' ); ?></td>
	</tr>
</table>

<h3><?php _e( 'Card options', 'wikilookup' ); ?></h3>
<p><?php _e( 'You can use multiple combinations of the examples below.', 'wikilookup' ); ?></p>
<p><?php _e( 'Notice that you do not need to close a <code>[wikicard]</code> shortcode.', 'wikilookup' ); ?></p>
<table class="form-table">
	<tr>
		<th><?php _e( 'Shortcode', 'wikilookup' ); ?></th>
		<th><?php _e( 'Card article topic', 'wikilookup' ); ?></th>
		<th><?php _e( 'Description', 'wikilookup' ); ?></th>
	</tr>
	<tr>
		<td><code>[wikicard title="mountains"]</code></td>
		<td>Mountains</td>
		<td><?php _e( 'Creates a card that shows the article from your default wiki about "Mountains"', 'wikilookup' ); ?></td>
	</tr>
	<tr>
		<td><code>[wikicard title="Montaña" lang="es"]</code></td>
		<td>Mountains</td>
		<td><?php _e( 'Creates a card that shows the article "Montaña" taken from the Spanish version of your default wiki', 'wikilookup' ); ?></td>
	</tr>
	<tr>
		<td><code>[wikicard source="trek" title="Picard"]</code></td>
		<td>Picard</td>
		<td><?php _e( 'Creates a card that shows the article about "Picard" that is pulled from the external wiki you named "trek"', 'wikilookup' ); ?></td>
	</tr>
</table>


<?php if ( current_user_can( 'manage_options' ) ) { ?>
	<h2><?php _e( 'Creating external sources', 'wikilookup' ); ?></h2>
	<?php
	echo '<p>' .
		__( 'You can add more wikis to your blog and pull information from them by adding "External wikis" in the settings. To do that, go to the Wikilookup settings and choose "External wikis."', 'wikilookup' ) .
		'</p>';
	echo '<p>' .
		__( 'You can define any wiki that operates on <a href="https://www.mediawiki.org/" target="_blank">MediaWiki</a>, and provide its api endpoint (usually ending with <code>api.php</code>)' ,'wikilookup' ) .
		'</p>';
	echo '<p>' .
		__( 'Adding a source allows you to reference it when creating popups and cards, by explicitly adding <code>source="sourceName"</code> in the shortcodes.' ,'wikilookup' ) .
		'</p>';
	?>
	<a class="button button-primary" href="<?php echo admin_url( 'admin.php?page=wikilookup-settings-sources' ); ?>"><?php _e( 'Click here to add external wikis to your blog.', 'wikilookup' ); ?></a>
<?php }?>
</div>

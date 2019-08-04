=== Wikilookup ===
Contributors: mooeypoo
Donate link:
Tags: wikipedia, wiki, facts, card, popup, embed
Requires at least: 5.0
Tested up to: 5.2
Requires PHP: 5.6
Stable tag: @@currentTag
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Add the power of Wikipedia to your Blog.

== Description ==
Wikilookup allows you to easily add popups and info cards from Wikipedia (and other wikis) to your posts.

= Features =
* Easily mark words and terms in your posts to pop information from Wikipedia articles
* Easily add a stylized card in your post and pages that displays information from Wikipedia article
* Pull from multiple language Wikipedias and dictate the default language for your blog content
* Pull information from other wikis easily, like specialized wikis and game wikis
* Robust settings allowing you to control the text and general behavior of the popups and cards
* Support displaying content in Right to Left languages

== Usage ==
This plugin offers two pieces: a popup, and a 'card', or a static poster, from Wikipedia or other wikis that operate on MediaWiki software.

= Adding popups =
To add a popup, while editing a post, surround your text with `[wikipopup]` shortcode. You can reference a language or a different source, if you've set one up.

For example:
- `[wikipopup]WordPress[/wikipopup]` - Displays a popup from English Wikipedia about the article "WordPress"
- `[wikipopup title="WordPress"]This is some text[/wikipopup]` - Displays a popup from English Wikipedia about the article "WordPress", while the trigger text is 'This is some text'
- `[wikipopup title="WordPress" source="ext"]This is some text[/wikipopup]` - Displays a popup from the external source you've defined as "ext", about the article "WordPress", while the trigger text is 'This is some text'

You can define sources in "Settings -> Wikilookup -> External wikis".

= Adding cards =
To add a card, while editing a post, add a line with `[wikicard title="term"]`. You can reference a language or a different source, if you've set one up.

For example:
- `[wikicard title="WordPress"]` - Displays a static card from English Wikipedia about the article "WordPress".
- `[wikicard title="WordPress" lang="es"]` - Displays a static card from Spanish Wikipedia about the article "WordPress".
- `[wikicard title="WordPress" source="ext"]` - Displays a static card from the external source you've defined as "ext", about the article "WordPress".

You can define sources in "Settings -> Wikilookup -> External wikis".

= Settings =
You can find the settings page in your Dashboard -> Wikilookup.

= Languages =
* This plugin is available in English
* התוסף זמין בשפה העברית

= Translate this plugin =
This plugin is community translated. Please help translate it!

The base translation file is `languages/wikilookup.pot` and the textdomain is `wikilookup`.

== Development ==
The code for this plugin is available on [github for development](https://github.com/mooeypoo/wikilookup-wordpress). Please feel free to participate!

== Installation ==
This plugin was developed for and tested on WordPress 5.0 and above.

= Automatic installation =
* Go to your Dashboard
* Click on Plugins -> Add new
* Search for "Wikilookup"
* Click on "Install now"
* Click on "activate"

The plugin works out-of-the-box with the given shortcodes `[wikipopup]term[/wikipopup]` and `[wikicard title="term"]`.
Please visit the plugin settings for more display options, and to set up any external sources you may want.

= Manual installation =
For manual installation, download the plugin and upload it to your site. See [instructions on how to manually install a plugin here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =
Automatic updates should always work. However, as always, please ensure you backup your site, just in case.

== Screenshots ==
01. Popup view in Twenty Nineteen theme
02. Card view in Twenty Nineteen theme
03. Wikilookup general settings
04. Wikilookup display settings
05. Wikilookup external sources settings
06. Wikilookup shortcodes in the editor

== Upgrade Notice ==

= 1.1.4 =
Bug fix: Fix "Wikipedia" logo SVG to display in all browsers. Add Gutenberg block for wiki cards.

= 1.1.3 =
Bug fix: Prevent bootstrap styling from interfering with blog styles.

= 1.1.2 =
Added detailed information and instructions for the shortcodes, and an ability to toggle dark mode.

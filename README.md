# Wikilookup for WordPress
Add the power of Wikipdia to your WordPress website!


## Install
**Please note: This plugin is in beta testing mode. When beta testing ends, it will be avilable in the WordPress plugin store, and installation will be possible through the installer.**

* Download the plugin files.
* Extract the folder in your `wp-content/plugins/` in your WordPress installation.
* The plugin works out-of-the-box with the `[wikilookup]` shortcode. To change configuration, visit the configuration page under your administration area.

## Features
With this plugin activated, you can use the shortcode `[wikilookup]` to wrap words in your WordPress posts. Those words will then display a popup with information from Wikipedia.

### Shortcode properties
There are several features the shortcode accepts:
* **lang** - Pull data from a different language Wikipedia. Use with `[wikilookup lang="es"]word[/wikilookup]`
* **title** - Use a different title. By default, the title used to pull from Wikipedia is the text inside the shortcode. If you want to display a different title, use the `title` property. For example, `[wikilookup title="Randomness"]This is random[/wikilookup]` will display the information from Wikipedia page "Randomness".
* **source** - Use a different source for this lookup. If you've defined sources in your settings page (see below) you can use them in your post with the `source` property. For example, `[wikilookup source="trek"]Star Trek[/wikilookup]` will look for 'Star Trek' through the source defined as 'trek' in your settings. If the source is not found (or not given) the system falls back to search in the default source.

### Settings
You can change several aspects of the popup display through the settings page.

* **Popup Trigger** - Dictates what triggers the popups. By default, it is a "click" action, but you can change it to "Hover".
* **Display text** - You can change the way some of the messaging appears in the popup, from the loading text, to the credits and links.
* **Sources** - Define the source information that Wikilookup will use.

### Sources
The sources are where Wikilookup popup searches for the page information it will display.

The default source is defined as the Wikipedia sites with the default language set to 'en'. You can change the default or add your own sources.

#### Source baseURL
Source definitions must be wiki websites that use [MediaWiki](https://www.mediawiki.org) as software, since they expect the API response from a wiki.

#### Source languages
If your defined source is in a wiki farm that has dynamic language (similar to Wikipedia where `en.wikipedia.org` is English and `es.wikipedia.org` is Spanish, etc) you will need to represent that in your `baseURL` by the `{{lang}}` attribute. The system will then allow you to use `lang="xx"` in the shortcode to switch the language without defining a new source name.

#### Source Restbase
Restbase is an API technology and format. It is offered for wikis that run MediaWiki but needs to be set up separately, and offers slightly different format than the base API technology.

You should only use this if the wiki you are fetching from uses Restbase and you intentionally mean to use it instead of the base API.

**Note that if you mark "Restbase" without the wiki use restbase, the popups will never display any pages.**

## Credits and contribution
This plugin was written by [Moriel Schottlender](http://moriel.smarterthanthat.com), under a GPL-v3 license.

For a standalone plugin, see [jQuery.Wikilookup](https://github.com/mooeypoo/jquery.wikilookup)

Please feel free to submit issues and pull requests.

[OOUI](https://www.mediawiki.org/wiki/OOUI) is a widget library by the Wikimedia Foundation, used for the display popups.

# Wikilookup for WordPress
Add the power of Wikipedia to your WordPress Blog

## Install

* Download the plugin files from the official WordPress plugin store: https://wordpress.org/plugins/wikilookup/
* Extract the folder in your `wp-content/plugins/` in your WordPress installation.
* The plugin works out-of-the-box with the `[wikipopup]` and `[wikicard]` shortcodes.
* To change configuration, visit the configuration page under your administration area.

## Features
With this plugin activated, you can use the shortcode `[wikipopup]` to wrap words in your WordPress posts. Those words will then display a popup with information from Wikipedia.

You can also use `[wikicard]` to display Wikipedia content in the form of a static card within your post.

### Shortcode properties
There are several features that both shortcodes accept:
* **lang** - Pull data from a different language Wikipedia. Use with `[wikipopup lang="es"]word[/wikipopup]`
* **title** - Use a different title. By default, the title used to pull from Wikipedia is the text inside the shortcode. If you want to display a different title, use the `title` property. For example, `[wikipopup title="Randomness"]This is random[/wikipopup]` will display the information from Wikipedia page "Randomness".
* **source** - Use a different source for this lookup. If you've defined sources in your settings page (see below) you can use them in your post with the `source` property. For example, `[wikipopup source="trek"]Star Trek[/wikipopup]` will look for 'Star Trek' through the source defined as 'trek' in your settings. If the source is not found (or not given) the system falls back to search in the default source.

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

Please feel free to submit issues and pull requests.

## Contributing
To contribute and develop this plugin:

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Start writing code! :)

Note: `grunt build` will create a releasable plugin directory in `_release/trunk`; that is the best way to test whether the changes you've made will work for a standalone plugin. To continuously test, you can add the plugin folder to a local WordPress installation and use that to develop and debug.

### Using the Docker container
The repository comes ready-made with a docker container that activates a new WordPress installation with the wikilookup plugin read from the `_release/trunk` folder.

1. Create the trunk files by running `grunt trunk`
2. Run docker-compose `docker-compose up`
3. Change the code.... and to update, run `grunt trunk` again

The docker container reads from the `_release/trunk` folder to mimic, as close as possible, the real plugin files, without the development files.

## Credits
* This plugin was written by [Moriel Schottlender](http://moriel.smarterthanthat.com), under a GPL-v3 license.
* Design guidance by Nirzar Pangarkar
* For a standalone plugin, see [jQuery.Wikilookup](https://github.com/mooeypoo/jquery.wikilookup)

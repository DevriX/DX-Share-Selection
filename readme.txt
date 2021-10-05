=== DX Share Selection ===
Contributors: nofearinc, devrix
Author URI: https://devrix.com/
Tags: posts, page, links, plugin, share, search, jquery, content, social, social bookmarking, tweet, Facebook, twitter, bitly
Requires at least: 4.9
Tested up to: 5.8.1
Stable tag: 1.5
Requires PHP: 5.6

Allows you to share/search selected text from your site - select a snippet, search for it or share it to popular social networks.

== Description ==

This is a fork of WP Selected Text Sharer which hasn't been maintained for a few years.

Allows you to share/search selected text from your site - select a snippet, search for it or share it to popular social networks. A small popup is displayed above the selected text which contains links to share/search selected text.

= Instructions =

* When a user selects a text snippet in a page or post of your site, a popup is displayed. When that quote is tweeted (or shared in another social network), the selected Quote and the link to that blog post is also shared in the following network. Hence increasing site visibility.

* Search engines (Your site's search / Google adsense search / Yahoo search etc ...) can also be added to the popup.

* Apart from sharing texts only, this plugin also acts like a social bookmarking button.

= Features =

* Lightweight, 4KB jquery plugin is required.
* Various color/style and option arguments.
* Automatic selected text truncation for Twitter.
* Shorten the post link using Bitly.
* Load the scripts either in header or footer.
* Simple and light interface.
* Template system for adding links to the popup.
* No knowledge of coding required.
* Integration with [WP Socializer plugin](https://wordpress.org/plugins/wp-socializer//)

== Installation ==

1. Upload `dx-share-selection` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Customize the plugin in the DX Share Selection admin page (Settings -> DX Share Selection).

== Frequently Asked Questions ==

= Can I add custom class to the popup to customize? =

Yes, you can add classes accordingly.

= Can I select a given area to be captured only? =

Yes, define the given selector in the admin section.

== Screenshots ==

1. Popup show, when a text is selected. List of share links that can be added.
2. Admin Page

== Changelog ==

= 1.4 =
* Use WordPress Coding Standarts
* Improve Share popup styling
* Add Restore default settings option
* Add more description in plugin's settings
* Add option to specify Share Selection for jQuery selector
* Improve Preview section with working shareable links
* Fix WP Socializer plugin integration
* Fix Bit.ly integration
* Fix some button links
* Fixed 'Install plugin' link

= 1.3 =
* Fixed some errors

= 1.2 =
* Fork and fixes from the original plugin version

== Credits ==

Core jQuery plugin, original WP Selected Text Sharer plugin by Aakash Chakravarthy ([vaakash](https://profiles.wordpress.org/vaakash/))

== Upgrade Notice ==

Initial Version. No upgrade required

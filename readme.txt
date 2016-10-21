=== JSM's file_get_contents() Shortcode ===
Plugin Name: JSM's file_get_contents() Shortcode
Plugin Slug: wp-file-get-contents
Text Domain: wp-file-get-contents
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Donate Link:
Assets URI: https://jsmoriss.github.io/wp-file-get-contents/assets/
Tags: file_get_contents, shortcode, include, file, url, body, content
Contributors: jsmoriss
Requires At Least: 3.5
Tested Up To: 4.6.1
Stable Tag: 1.3.0-1

A WordPress shortcode for PHP's file_get_contents() function.

== Description ==

A WordPress shortcode for PHP's file_get_contents() function.

= Shortcode Attributes =

* url = http, https, or file URI.
* file = path to a local file (relative to the wp-content/ folder).
* cache = number of seconds to cache the content in the transient cache (defaults to 3600 seconds).
* pre = wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags.
* class = wrap the content in the specified div class.
* filter = apply the specified filter to the content.

All file paths are relative to the wp-content/ folder &mdash; you cannot include files outside of the wp-content/ folder. For example, the shortcode attributes `url="file://dir/file.html"` and `file="/dir/file.html"` are read as wordpress/wp-contents/dir/file.html. The `..` folder name is removed from file paths to prevent backing out of the wp-content/ folder.

= Shortcode Name =

The WPFGC_SHORTCODE_NAME constant can be defined in your wp-config.php file to change the default shortcode name (the default shortcode name is 'wp-file-get-contents').

<pre>
define( 'WPFGC_SHORTCODE_NAME', 'wpfgc' );
</pre>

= Shortcode Examples =

<pre>
&#91;wp-file-get-contents url="http://example.com/dir/file.html"&#93;
&#91;wp-file-get-contents url="http://example.com/counter/" cache="7200"&#93;
&#91;wp-file-get-contents url="file://dir/file.html"&#93;
&#91;wp-file-get-contents file="/dir/file.txt" pre="true" filter="my_custom_filters" cache="600"&#93;
</pre>

== Installation ==

= Automated Install =

1. Go to the wp-admin/ section of your website
1. Select the *Plugins* menu item
1. Select the *Add New* sub-menu item
1. In the *Search* box, enter the plugin name
1. Click the *Search Plugins* button
1. Click the *Install Now* link for the plugin
1. Click the *Activate Plugin* link

= Semi-Automated Install =

1. Download the plugin archive file
1. Go to the wp-admin/ section of your website
1. Select the *Plugins* menu item
1. Select the *Add New* sub-menu item
1. Click on *Upload* link (just under the Install Plugins page title)
1. Click the *Browse...* button
1. Navigate your local folders / directories and choose the zip file you downloaded previously
1. Click on the *Install Now* button
1. Click the *Activate Plugin* link

== Frequently Asked Questions ==

= Frequently Asked Questions =

* None

== Other Notes ==

= Additional Documentation =

* None

== Screenshots ==

== Changelog ==

= Repositories =

* [GitHub](https://github.com/jsmoriss/wp-file-get-contents)
* [WordPress.org](https://wordpress.org/plugins/wp-file-get-contents/developers/)

= Changelog / Release Notes =

**Version 1.3.0-1 (2016/08/24)**

* *New Features*
	* None
* *Improvements*
	* Added a `save_post()` action to clear the cached content.
* *Bugfixes*
	* None
* *Developer Notes*
	* None

**Version 1.2.0 (2016/02/06)**

* *New Features*
	* None
* *Improvements*
	* Added support for a WPFGC_SHORTCODE_NAME constant to change the default shortcode name.
* *Bugfixes*
	* None
* *Developer Notes*
	* None

== Upgrade Notice ==

= 1.3.0-1 =

(2016/08/24) Added a save_post() action to clear the cached content.


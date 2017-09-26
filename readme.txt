=== JSM's file_get_contents() Shortcode ===
Plugin Name: JSM's file_get_contents() Shortcode
Plugin Slug: wp-file-get-contents
Text Domain: wp-file-get-contents
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://jsmoriss.github.io/wp-file-get-contents/assets/
Tags: file_get_contents, shortcode, include, file, url, body, content
Contributors: jsmoriss
Requires At Least: 3.7
Tested Up To: 4.8.2
Requires PHP: 5.3
Stable Tag: 1.5.0

A WordPress shortcode for PHP's file_get_contents() function.

== Description ==

A WordPress shortcode for PHP's file_get_contents() function.

= Shortcode Attributes =

* url = http, https, or file URI.
* file = path to a local file (relative to the wp-content/ folder).
* cache = number of seconds to cache the content in the transient cache (defaults is 3600 seconds).
* pre = wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags (default is false).
* class = wrap the content in the specified div class (default is none).
* filter = apply the specified filter to the content (default is none).
* more = add more link on non-singular web pages (default is true).
* body = keep only the content between &lt;body&gt;&lt;/body&gt; HTML tags (default is true).

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

1. Go to the wp-admin/ section of your website.
1. Select the *Plugins* menu item.
1. Select the *Add New* sub-menu item.
1. In the *Search* box, enter the plugin name.
1. Click the *Search Plugins* button.
1. Click the *Install Now* link for the plugin.
1. Click the *Activate Plugin* link.

= Semi-Automated Install =

1. Download the plugin ZIP file.
1. Go to the wp-admin/ section of your website.
1. Select the *Plugins* menu item.
1. Select the *Add New* sub-menu item.
1. Click on *Upload* link (just under the Install Plugins page title).
1. Click the *Browse...* button.
1. Navigate your local folders / directories and choose the ZIP file you downloaded previously.
1. Click on the *Install Now* button.
1. Click the *Activate Plugin* link.

== Frequently Asked Questions ==

= Frequently Asked Questions =

* None

== Other Notes ==

= Additional Documentation =

* None

== Screenshots ==

== Changelog ==

= Repositories =

* [GitHub](https://jsmoriss.github.io/wp-file-get-contents/)
* [WordPress.org](https://wordpress.org/plugins/wp-file-get-contents/developers/)

= Version Numbering =

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

= Changelog / Release Notes =

**Version 1.5.0 (2017/09/25)**

* *New Features*
	* None
* *Improvements*
	* None
* *Bugfixes*
	* None
* *Developer Notes*
	* Added a method hooked to the WordPress 'plugins_loaded' action to load the text domain.

== Upgrade Notice ==

= 1.5.0 =

(2017/09/25) Added a method hooked to the WordPress 'plugins_loaded' action to load the text domain.


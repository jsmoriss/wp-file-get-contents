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
Requires PHP: 5.6
Requires At Least: 3.9
Tested Up To: 5.2.2
Stable Tag: 2.0.0

A WordPress shortcode for PHP's file_get_contents() function.

== Description ==

A WordPress shortcode for PHP's file_get_contents() function.

= Shortcode Attributes =

* url = URL or file URI.
* file = Path to a local file (relative to the wp-content/ folder).
* cache = Number of seconds to cache the content in the transient cache (defaults is 3600 seconds).
* pre = Wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags (default is false).
* class = Wrap the content in the specified div class (default is none).
* filter = Apply the specified filter to the content (default is none).
* more = Add more link on non-singular web pages (default is true).
* body = Keep only the content between &lt;body&gt;&lt;/body&gt; HTML tags (default is true).

All local file paths are relative to the wp-content/ folder &mdash; you cannot include files outside of the wp-content/ folder. For example, the shortcode attributes `url="file://dir/file.html"` and `file="/dir/file.html"` are both read as wordpress/wp-contents/dir/file.html. The `..` folder name is also removed from file paths to prevent backing out of the wp-content/ folder.

= Shortcode Name =

The WPFGC_SHORTCODE_NAME constant can be defined in your wp-config.php file to add an additional custom shortcode name (the default shortcode names are 'wp-file-get-contents' and 'wpfgc').

<pre>
define( 'WPFGC_SHORTCODE_NAME', 'include' );
</pre>

= Shortcode Examples =

<pre>
&#91;wpfgc url="http://example.com/dir/file.html"&#93;
&#91;wpfgc url="http://example.com/counter/" cache="7200"&#93;
&#91;wpfgc url="file://dir/file.html"&#93;
&#91;wpfgc file="/dir/file.txt" pre="true" filter="my_custom_filters" cache="600"&#93;
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

== Screenshots ==

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Repositories</h3>

* [GitHub](https://jsmoriss.github.io/wp-file-get-contents/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wp-file-get-contents/)

<h3>Changelog / Release Notes</h3>

**Version 2.0.0 (2019/08/05)**

* **New Features**
	* None.
* **Improvements**
	* Added support for both short and long default shortcode names, plus an additional custom shortcode name.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.

== Upgrade Notice ==

= 2.0.0 =

(2019/08/05) Added support for both short and long default shortcode names, plus an additional custom shortcode name.


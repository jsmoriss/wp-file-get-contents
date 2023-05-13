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
Requires PHP: 7.2.5
Requires At Least: 5.5
Tested Up To: 6.2.0
Stable Tag: 2.5.0

A safe and reliable WordPress shortcode for PHP's file_get_contents() function.

== Description ==

A safe and reliable WordPress shortcode for PHP's file_get_contents() function.

= Shortcode Attributes =

* body = Keep only the content between &lt;body&gt;&lt;/body&gt; HTML tags (default is true).
* cache = Number of seconds to cache the contents (defaults is 3600 seconds).
* class = Wrap the content in the specified div class (default is none).
* code = Wrap the content in &lt;code&gt;&lt;/code&gt; HTML tags (default is false).
* esc_html = Escape HTML characters (default is false).
* file = Path to a local file (relative to the wp-content/ folder).
* filter = Apply the specified filter to the content (default is none).
* more = Add more link on non-singular web pages (default is true).
* pre = Wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags (default is false).
* pre_code_esc_html = Escape HTML characters and wrap the content in &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; HTML tags (default is false).
* url = URL or file URI.
* utf8 = Encode HTML entities (default is true).

**Note that all local file paths are relative to the wp-content/ folder** - you cannot include files outside the wp-content/ folder. For example, the shortcode attributes `url="file://dir/file.html"` and `file="/dir/file.html"` are both read as wordpress/wp-contents/dir/file.html. The `..` folder name is stripped from file paths to prevent backing out of the wp-content/ folder.

= Shortcode Name =

The WPFGC_SHORTCODE_NAME constant can be defined in your wp-config.php file to add an additional custom shortcode name (the default shortcode names are 'wp-file-get-contents' and 'wpfgc').

<pre>define( 'WPFGC_SHORTCODE_NAME', 'include' );</pre>

= Shortcode Examples =

<pre>&#91;wpfgc url="http://example.com/dir/file.html"&#93;
&#91;wpfgc url="http://example.com/counter/" cache="7200"&#93;
&#91;wpfgc url="file://dir/file.html"&#93;
&#91;wpfgc file="/dir/file.txt" pre="true" filter="my_custom_filter_name" cache="600"&#93;</pre>

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes and/or incompatible API changes (ie. breaking changes).
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Repositories</h3>

* [GitHub](https://jsmoriss.github.io/wp-file-get-contents/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wp-file-get-contents/)

<h3>Changelog / Release Notes</h3>

**Version 2.6.0 (2023/05/13)**

* **New Features**
	* Added the 'code' shortcode attribute (default is false).
	* Added the 'pre_code_esc_html' shortcode attribute (default is false).
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.2.5.
	* WordPress v5.5.

== Upgrade Notice ==

= 2.6.0 =

(2023/05/13) Added the 'code' and 'pre_code_esc_html' shortcode attributes (default is false).


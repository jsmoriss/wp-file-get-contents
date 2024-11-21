=== JSM file_get_contents() Shortcode ===
Plugin Name: JSM file_get_contents() Shortcode
Plugin Slug: wp-file-get-contents
Text Domain: wp-file-get-contents
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://jsmoriss.github.io/wp-file-get-contents/assets/
Tags: file_get_contents, shortcode, include, file, url
Contributors: jsmoriss
Requires PHP: 7.4.33
Requires At Least: 5.9
Tested Up To: 6.7.1
Stable Tag: 2.7.1

A safe and reliable WordPress shortcode for PHP's file_get_contents() function.

== Description ==

A safe and reliable WordPress shortcode for PHP's file_get_contents() function.

= Shortcode Attributes =

* body = Keep only the content between &lt;body&gt;&lt;/body&gt; HTML tags (default is true).
* cache = Number of seconds to cache the contents (defaults is 3600 seconds).
* class = Add a class to the content 'div' container (default is none).
* code = Wrap the content in a &lt;code&gt;&lt;/code&gt; container (default is false).
* code_class = Add a class to the 'code' container (default is none).
* code_lang = Escape HTML characters, wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container, and add a language class to the 'code' container (default is none).
* esc_html = Escape HTML characters (default is false).
* esc_html_pre_code = Escape HTML characters and wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container (default is false).
* file = Path to a local file (**relative** to the wp-content/ folder).
* filter = Apply the named filter to the content (default is none).
* more = Add a more link on non-singular web pages (default is true).
* pre = Wrap the content in a &lt;pre&gt;&lt;/pre&gt; container (default is false).
* pre_class = Add a class to the 'pre' container (default is none).
* pre_code = Wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container (default is false).
* pre_lang = Escape HTML characters, wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container, and add a language class to the 'pre' container (default is none).
* pre_title = Add a title to the 'pre' container (default is none).
* url = URL or file URI.
* utf8 = Encode HTML entities (default is true).

> Note that all file paths (not URLs) are **relative** to the wp-content/ folder. For security reasons, it is not possible to include files outside the wp-content/ folder. As an example, the shortcode attributes `url="file://dir/file.html"` and `file="/dir/file.html"` are both read as wordpress/wp-contents/dir/file.html. The `..` folder name is also stripped from file paths to prevent backing out of the wp-content/ folder.

= Shortcode Name =

The WPFGC_SHORTCODE_NAME constant can be defined in your wp-config.php file to add an additional custom shortcode name (the default shortcode names are 'wp-file-get-contents' and 'wpfgc').

<pre><code>
define( 'WPFGC_SHORTCODE_NAME', 'include' );
</code></pre>

= Shortcode Examples =

<pre><code>
&#91;wpfgc url="http://example.com/dir/file.html"&#93;

&#91;wpfgc url="http://example.com/counter/" cache="7200"&#93;

&#91;wpfgc url="file://dir/file.html"&#93;

&#91;wpfgc file="/dir/file.txt" pre="true" filter="my_custom_filter_name" cache="600"&#93;

&#91;wpfgc file="examples/example-1.php" code_lang="php"&#93;
</code></pre>

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

**Version 2.7.1 (2023/12/20)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* Added `sanitize_text_field()` sanitation for file path value.
	* Added `wp_http_validate_url()` sanitation for URL value (props Erwan Le Rousseau @ WPScan).
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v7.4.33.
	* WordPress v5.9.

== Upgrade Notice ==

= 2.7.1 =

(2023/12/20) Added sanitation for file path and URL values.


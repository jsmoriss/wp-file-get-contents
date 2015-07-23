=== WP file_get_contents() ===
Plugin Name: WP file_get_contents()
Plugin Splug: wp-file-get-contents
Contributors: jsmoriss
Tags: file_get_contents, shortcode, include, file, url, body, content
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Requires At Least: 3.0
Tested Up To: 4.2.3
Stable Tag: 1.1

A WordPress shortcode for PHP's file_get_contents() function.

== Description ==

A WordPress shortcode for PHP's file_get_contents() function.

Examples:

`
[wp-file-get-contents url="http://example.com/dir/file.html"]

[wp-file-get-contents url="http://example.com/counter/" cache="0"]

[wp-file-get-contents url="file://dir/file.html"]

[wp-file-get-contents file="/dir/file.txt" pre="true" filter="my_custom_filters" cache="3600"]
`

<strong>Note that all local file paths are relative to the `wp-contents/` folder</strong>. You cannot include files outside of the `wp-contents/` folder. As an example, `file://dir/file.html` and/or `/dir/file.html` will be interpreted as `wordpress/wp-contents/dir/file.html`. The `..` folder name is also removed from file paths to prevent backing out of the `wp-content/` folder.

Shortcode attributes:

* url = http, https, or file URI.
* file = path to a local file (relative to the `wp-content/` folder).
* cache = number of seconds to cache the content in the transient cache (defaults to 3600 seconds).
* pre = wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags.
* class = wrap the content in the specified div class.
* filter = apply the specified filter to the content.

== Installation ==

*Using the WordPress Dashboard*

1. Login to your weblog
1. Go to Plugins
1. Select Add New
1. Search for *Get URL*
1. Select Install
1. Select Install Now
1. Select Activate Plugin

*Manual*

1. Download and unzip the plugin
1. Transfer the entire `wp-file-get-contents/` folder to the web server's `wp-content/plugins/` folder
1. Activate the plugin through the Plugins menu in WordPress

== Frequently Asked Questions ==

== Changelog ==

= Version 1.1 (2015/05/07) =

* **New Features**
	* Added new 'pre', 'class', and 'filter' shortcode attributes.
* **Improvements**
	* *None*
* **Bugfixes**
	* *None*

== Upgrade Notice ==

= 1.1 =

Added new 'pre', 'class', and 'filter' shortcode attributes.


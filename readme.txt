=== JSM's file_get_contents() Shortcode ===
Plugin Name: JSM's file_get_contents() Shortcode
Plugin Splug: wp-file-get-contents
Contributors: jsmoriss
Tags: file_get_contents, shortcode, include, file, url, body, content
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.txt
Requires At Least: 3.0
Tested Up To: 4.6
Stable Tag: 1.2.0

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

<strong>Note that all local file paths are relative to the `wp-contents/` folder</strong>.

You cannot include files outside of the `wp-contents/` folder. As an example, `file://dir/file.html` and/or `/dir/file.html` will be interpreted as `wordpress/wp-contents/dir/file.html`. The `..` folder name is also removed from file paths to prevent backing out of the `wp-content/` folder.

The WPFGC_SHORTCODE_NAME constant can be defined to change the default shortcode name.

Shortcode attributes:

* url = http, https, or file URI.
* file = path to a local file (relative to the `wp-content/` folder).
* cache = number of seconds to cache the content in the transient cache (defaults to 3600 seconds).
* pre = wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags.
* class = wrap the content in the specified div class.
* filter = apply the specified filter to the content.

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

= 1.2.0 =

(2016/02/06) Added support for a WPFGC_SHORTCODE_NAME constant to change the default shortcode name.


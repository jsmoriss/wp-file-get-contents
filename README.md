<h1>JSM&#039;s file_get_contents() Shortcode</h1>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>JSM&#039;s file_get_contents() Shortcode</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>A WordPress shortcode for PHP&#039;s file_get_contents() function.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>1.2.0</td></tr>
<tr><th align="right" valign="top" nowrap>Requires At Least</th><td>WordPress 3.0</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To</th><td>WordPress 4.4.2</td></tr>
<tr><th align="right" valign="top" nowrap>Contributors</th><td>jsmoriss</td></tr>
<tr><th align="right" valign="top" nowrap>License</th><td><a href="http://www.gnu.org/licenses/gpl.txt">GPLv3</a></td></tr>
<tr><th align="right" valign="top" nowrap>Tags / Keywords</th><td>file_get_contents, shortcode, include, file, url, body, content</td></tr>
</table>

<h2>Description</h2>

<p>A WordPress shortcode for PHP's file_get_contents() function.</p>

<p>Examples:</p>

<pre><code>[wp-file-get-contents url="http://example.com/dir/file.html"]

[wp-file-get-contents url="http://example.com/counter/" cache="0"]

[wp-file-get-contents url="file://dir/file.html"]

[wp-file-get-contents file="/dir/file.txt" pre="true" filter="my_custom_filters" cache="3600"]
</code></pre>

<p><strong>Note that all local file paths are relative to the <code>wp-contents/</code> folder</strong>.</p>

<p>You cannot include files outside of the <code>wp-contents/</code> folder. As an example, <code>file://dir/file.html</code> and/or <code>/dir/file.html</code> will be interpreted as <code>wordpress/wp-contents/dir/file.html</code>. The <code>..</code> folder name is also removed from file paths to prevent backing out of the <code>wp-content/</code> folder.</p>

<p>The WPFGC_SHORTCODE_NAME constant can be defined to change the default shortcode name.</p>

<p>Shortcode attributes:</p>

<ul>
<li>url = http, https, or file URI.</li>
<li>file = path to a local file (relative to the <code>wp-content/</code> folder).</li>
<li>cache = number of seconds to cache the content in the transient cache (defaults to 3600 seconds).</li>
<li>pre = wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags.</li>
<li>class = wrap the content in the specified div class.</li>
<li>filter = apply the specified filter to the content.</li>
</ul>


<h2>Installation</h2>

<h4>Automated Install</h4>

<ol>
<li>Go to the wp-admin/ section of your website</li>
<li>Select the <em>Plugins</em> menu item</li>
<li>Select the <em>Add New</em> sub-menu item</li>
<li>In the <em>Search</em> box, enter the plugin name</li>
<li>Click the <em>Search Plugins</em> button</li>
<li>Click the <em>Install Now</em> link for the plugin</li>
<li>Click the <em>Activate Plugin</em> link</li>
</ol>

<h4>Semi-Automated Install</h4>

<ol>
<li>Download the plugin archive file</li>
<li>Go to the wp-admin/ section of your website</li>
<li>Select the <em>Plugins</em> menu item</li>
<li>Select the <em>Add New</em> sub-menu item</li>
<li>Click on <em>Upload</em> link (just under the Install Plugins page title)</li>
<li>Click the <em>Browse...</em> button</li>
<li>Navigate your local folders / directories and choose the zip file you downloaded previously</li>
<li>Click on the <em>Install Now</em> button</li>
<li>Click the <em>Activate Plugin</em> link</li>
</ol>


<h2>Frequently Asked Questions</h2>

<h4>Frequently Asked Questions</h4>

<ul>
<li>None</li>
</ul>


<h2>Other Notes</h2>

<h3>Other Notes</h3>
<h4>Additional Documentation</h4>

<ul>
<li>None</li>
</ul>


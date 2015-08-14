<h1>WP file_get_contents()</h1>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>WP file_get_contents()</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>A WordPress shortcode for PHP&#039;s file_get_contents() function.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>1.1</td></tr>
<tr><th align="right" valign="top" nowrap>Requires At Least</th><td>WordPress 3.0</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To</th><td>WordPress 4.2.4</td></tr>
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

<p><strong>Note that all local file paths are relative to the <code>wp-contents/</code> folder</strong>. You cannot include files outside of the <code>wp-contents/</code> folder. As an example, <code>file://dir/file.html</code> and/or <code>/dir/file.html</code> will be interpreted as <code>wordpress/wp-contents/dir/file.html</code>. The <code>..</code> folder name is also removed from file paths to prevent backing out of the <code>wp-content/</code> folder.</p>

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

<p><em>Using the WordPress Dashboard</em></p>

<ol>
<li>Login to your weblog</li>
<li>Go to Plugins</li>
<li>Select Add New</li>
<li>Search for <em>Get URL</em></li>
<li>Select Install</li>
<li>Select Install Now</li>
<li>Select Activate Plugin</li>
</ol>

<p><em>Manual</em></p>

<ol>
<li>Download and unzip the plugin</li>
<li>Transfer the entire <code>wp-file-get-contents/</code> folder to the web server's <code>wp-content/plugins/</code> folder</li>
<li>Activate the plugin through the Plugins menu in WordPress</li>
</ol>


<h2>Frequently Asked Questions</h2>




<h2>Other Notes</h2>




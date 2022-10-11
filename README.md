<h1>JSM&#039;s file_get_contents() Shortcode</h1>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>JSM&#039;s file_get_contents() Shortcode</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>A safe and reliable WordPress shortcode for PHP&#039;s file_get_contents() function.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>2.4.0</td></tr>
<tr><th align="right" valign="top" nowrap>Requires PHP</th><td>7.2 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Requires WordPress</th><td>5.2 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To WordPress</th><td>6.1.0</td></tr>
<tr><th align="right" valign="top" nowrap>Contributors</th><td>jsmoriss</td></tr>
<tr><th align="right" valign="top" nowrap>License</th><td><a href="https://www.gnu.org/licenses/gpl.txt">GPLv3</a></td></tr>
<tr><th align="right" valign="top" nowrap>Tags / Keywords</th><td>file_get_contents, shortcode, include, file, url, body, content</td></tr>
</table>

<h2>Description</h2>

<p>A safe and reliable WordPress shortcode for PHP's file_get_contents() function.</p>

<h4>Shortcode Attributes</h4>

<ul>
<li>body = Keep only the content between &lt;body&gt;&lt;/body&gt; HTML tags (default is true).</li>
<li>cache = Number of seconds to cache the contents (defaults is 3600 seconds).</li>
<li>class = Wrap the content in the specified div class (default is none).</li>
<li>esc_html = Escape HTML characters (default is false).</li>
<li>file = Path to a local file (relative to the wp-content/ folder).</li>
<li>filter = Apply the specified filter to the content (default is none).</li>
<li>more = Add more link on non-singular web pages (default is true).</li>
<li>pre = Wrap the content in &lt;pre&gt;&lt;/pre&gt; HTML tags (default is false).</li>
<li>url = URL or file URI.</li>
<li>utf8 = Encode HTML entities (default is true).</li>
</ul>

<p><strong>Note that all local file paths are relative to the wp-content/ folder</strong> - you cannot include files outside the wp-content/ folder. For example, the shortcode attributes <code>url="file://dir/file.html"</code> and <code>file="/dir/file.html"</code> are both read as wordpress/wp-contents/dir/file.html. The <code>..</code> folder name is stripped from file paths to prevent backing out of the wp-content/ folder.</p>

<h4>Shortcode Name</h4>

<p>The WPFGC_SHORTCODE_NAME constant can be defined in your wp-config.php file to add an additional custom shortcode name (the default shortcode names are 'wp-file-get-contents' and 'wpfgc').</p>

<pre>define( 'WPFGC_SHORTCODE_NAME', 'include' );</pre>

<h4>Shortcode Examples</h4>

<pre>&#91;wpfgc url="http://example.com/dir/file.html"&#93;
&#91;wpfgc url="http://example.com/counter/" cache="7200"&#93;
&#91;wpfgc url="file://dir/file.html"&#93;
&#91;wpfgc file="/dir/file.txt" pre="true" filter="my_custom_filter_name" cache="600"&#93;</pre>


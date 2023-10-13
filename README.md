<h1>JSM file_get_contents() Shortcode</h1>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>JSM file_get_contents() Shortcode</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>A safe and reliable WordPress shortcode for PHP&#039;s file_get_contents() function.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>2.7.0</td></tr>
<tr><th align="right" valign="top" nowrap>Requires PHP</th><td>7.2.34 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Requires WordPress</th><td>5.5 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To WordPress</th><td>6.3.2</td></tr>
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
<li>class = Add a class to the content 'div' container (default is none).</li>
<li>code = Wrap the content in a &lt;code&gt;&lt;/code&gt; container (default is false).</li>
<li>code_class = Add a class to the 'code' container (default is none).</li>
<li>code_lang = Escape HTML characters, wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container, and add a language class to the 'code' container (default is none).</li>
<li>esc_html = Escape HTML characters (default is false).</li>
<li>esc_html_pre_code = Escape HTML characters and wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container (default is false).</li>
<li>file = Path to a local file (relative to the wp-content/ folder).</li>
<li>filter = Apply the named filter to the content (default is none).</li>
<li>more = Add a more link on non-singular web pages (default is true).</li>
<li>pre = Wrap the content in a &lt;pre&gt;&lt;/pre&gt; container (default is false).</li>
<li>pre_class = Add a class to the 'pre' container (default is none).</li>
<li>pre_code = Wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container (default is false).</li>
<li>pre_lang = Escape HTML characters, wrap the content in a &lt;pre&gt;&lt;code&gt;&lt;/code&gt;&lt;/pre&gt; container, and add a language class to the 'pre' container (default is none).</li>
<li>pre_title = Add a title to the 'pre' container (default is none).</li>
<li>url = URL or file URI.</li>
<li>utf8 = Encode HTML entities (default is true).</li>
</ul>

<blockquote>
  <p><strong>Note that all file paths (not URLs) are relative to the wp-content/ folder</strong> -- for security reasons, it is not possible to include files outside the wp-content/ folder. As an example, the shortcode attributes <code>url="file://dir/file.html"</code> and <code>file="/dir/file.html"</code> are both read as wordpress/wp-contents/dir/file.html. The <code>..</code> folder name is also stripped from file paths to prevent backing out of the wp-content/ folder.</p>
</blockquote>

<h4>Shortcode Name</h4>

<p>The WPFGC_SHORTCODE_NAME constant can be defined in your wp-config.php file to add an additional custom shortcode name (the default shortcode names are 'wp-file-get-contents' and 'wpfgc').</p>

<pre><code>
define( 'WPFGC_SHORTCODE_NAME', 'include' );
</code></pre>

<h4>Shortcode Examples</h4>

<pre><code>
&#91;wpfgc url="http://example.com/dir/file.html"&#93;

&#91;wpfgc url="http://example.com/counter/" cache="7200"&#93;

&#91;wpfgc url="file://dir/file.html"&#93;

&#91;wpfgc file="/dir/file.txt" pre="true" filter="my_custom_filter_name" cache="600"&#93;

&#91;wpfgc file="examples/example-1.php" code_lang="php"&#93;
</code></pre>


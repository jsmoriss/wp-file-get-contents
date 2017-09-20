<?php
/**
 * Plugin Name: JSM's file_get_contents() Shortcode
 * Text Domain: wp-file-get-contents
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/wp-file-get-contents/
 * Assets URI: https://jsmoriss.github.io/wp-file-get-contents/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl.txt
 * Description: A WordPress shortcode for PHP's file_get_contents()
 * Requires At Least: 3.7
 * Tested Up To: 4.8.2
 * Requires PHP: 5.3
 * Version: 1.4.2
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *	{major}		Major structural code changes / re-writes or incompatible API changes.
 *	{minor}		New functionality was added or improved in a backwards-compatible manner.
 *	{bugfix}	Backwards-compatible bug fixes or small improvements.
 *	{stage}.{level}	Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2012-2017 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WPFGC' ) ) {

	class WPFGC {

		private $clear_cache = false;
		private $shortcode_name = 'wp-file-get-contents';

		private static $instance;

		public function __construct() {
			// allow for a custom shortcode name
			if ( defined( 'WPFGC_SHORTCODE_NAME' ) && WPFGC_SHORTCODE_NAME ) {
				$this->shortcode_name = WPFGC_SHORTCODE_NAME;
			}
			if ( ! is_admin() ) {
				$this->wpautop();
				$this->add_shortcode();
			} else {
				add_action( 'save_post', array( &$this, 'clear_cache' ), 10 );
			}
		}

		public static function &get_instance() {
			if ( ! isset( self::$instance ) )
				self::$instance = new self;
			return self::$instance;
		}

		public function wpautop() {
			$default_priority = 10;
			foreach ( array( 'get_the_excerpt', 'the_excerpt', 'the_content' ) as $filter_name ) {
				$filter_priority = has_filter( $filter_name, 'wpautop' );
				if ( $filter_priority !== false && 
					$filter_priority > $default_priority ) {
					remove_filter( $filter_name, 'wpautop' );
					add_filter( $filter_name, 'wpautop' , $default_priority );
				}
			}
		}

		public function add_shortcode() {
        		add_shortcode( $this->shortcode_name, array( &$this, 'do_shortcode' ) );
		}

		public function remove_shortcode() {
			remove_shortcode( $this->shortcode_name );
		}

		public function do_shortcode( $atts, $content = null ) { 

			$cache_expire = isset( $atts['cache'] ) ? (int) $atts['cache'] : 3600;		// allow for 0 seconds (default 1 hour)
			$add_pre = isset( $atts['pre'] ) ? self::get_bool( $atts['pre'] ) : false;	// wrap content in pre tags (default is false)
			$add_class = empty( $atts['class'] ) ? '' : ' '.$atts['class'];			// optional css class names
			$do_filter = isset( $atts['filter'] ) ? $atts['filter'] : false;		// optional content filter
			$more_link = isset( $atts['more'] ) ? self::get_bool( $atts['more'] ) : true;	// add more link (default is true)
			$body_only = isset( $atts['body'] ) ? self::get_bool( $atts['body'] ) : true;	// keep only <body></body> content

			// determine the url / filename to retrieve
			if ( ! empty( $atts['url'] ) && 
				preg_match( '/^https?:\/\//', $atts['url'] ) )
					$url = $atts['url'];
			elseif ( ! empty( $atts['url'] ) && 
				preg_match( '/^file:\/\//', $atts['url'] ) )
					$url = trailingslashit( WP_CONTENT_DIR ).
						preg_replace( '/(^file:\/\/|\.\.)/', '', $atts['url'] );
			elseif ( ! empty( $atts['file'] ) )
				$url = trailingslashit( WP_CONTENT_DIR ).
					preg_replace( '/(^\/+|\.\.)/', '', $atts['file'] );
			else return '<p>'.__CLASS__.': <em><code>url</code> or <code>file</code> shortcode attribute missing</em>.</p>';

			$content = false;	// just in case
			$cache_salt = __METHOD__.'(url:'.$url.')';
			$cache_id = __CLASS__.'_'.md5( $cache_salt );

			if ( $this->clear_cache ) {
				delete_transient( $cache_id );
				return '<p>'.__CLASS__.': <em>cache cleared for '.$url.'</em>.</p>';
			} elseif ( $cache_expire > 0 ) {
				$content = get_transient( $cache_id );
			} else delete_transient( $cache_id );

			if ( $content === false )
				$content = file_get_contents( $url );
			else return $content;	// content from cache
		
			if ( $body_only && stripos( $content, '<body' ) !== false )
				$content = preg_replace( '/^.*<body[^>]*>(.*)<\/body>.*$/is', '$1', $content );

			if ( $more_link && ! is_singular() ) {
				global $post;
				$parts = get_extended( $content );
				if ( $parts['more_text'] ) {
					$content = $parts['main'].apply_filters( 'the_content_more_link', 
						' <a href="'.get_permalink().'#more-{'.$post->ID.'}" class="more-link">'.$parts['more_text'].'</a>', 
							$parts['more_text'] );
				} else {
					$content = $parts['main'];
				}
			}

			$content = '<div class="wp_file_get_contents'.$add_class.'">'."\n".
				( $add_pre ? "<pre>\n" : '' ).$content.( $add_pre ? "</pre>\n" : '' ).'</div>'."\n";

			if ( $do_filter ) {
				$this->remove_shortcode();	// prevent recursion
				$content = apply_filters( $do_filter, $content );
				$this->add_shortcode();
			}

			if ( $cache_expire > 0 )
				set_transient( $cache_id, $content, $cache_expire );	// save rendered content

			return $content;
		}

		public function clear_cache( $post_id, $rel_id = false ) {
			switch ( get_post_status( $post_id ) ) {
				case 'draft':
				case 'pending':
				case 'future':
				case 'private':
				case 'publish':
					$post_obj = get_post( $post_id, OBJECT, 'raw' );
					$is_admin = is_admin();
					if ( isset( $post_obj->post_content ) &&
						stripos( $post_obj->post_content, '['.$this->shortcode_name ) !== false ) {

						if ( $is_admin )
							$this->add_shortcode();
						$this->clear_cache = true;	// clear cache and return
						$content = do_shortcode( $post_obj->post_content );
						if ( $is_admin )
							$this->remove_shortcode();
					}
					break;
			}
			return $post_id;
		}

		// converts string to boolean
		public static function get_bool( $mixed ) {
			return is_string( $mixed ) ? 
				filter_var( $mixed, FILTER_VALIDATE_BOOLEAN ) : (bool) $mixed;
		}
	}

        WPFGC::get_instance();
}

?>

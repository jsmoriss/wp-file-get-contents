<?php
/**
 * Plugin Name: JSM's file_get_contents() Shortcode
 * Text Domain: wp-file-get-contents
 * Domain Path: /languages
 * Plugin URI: http://surniaulula.com/extend/plugins/wp-file-get-contents/
 * Assets URI: https://jsmoriss.github.io/wp-file-get-contents/assets/
 * Author: JS Morisset
 * Author URI: http://surniaulula.com/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl.txt
 * Description: A WordPress shortcode for PHP's file_get_contents()
 * Requires At Least: 3.5
 * Tested Up To: 4.6.1
 * Version: 1.3.0-1
 * 
 * Copyright 2012-2016 Jean-Sebastien Morisset (http://surniaulula.com/)
 */


if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'wpfgc' ) ) {

	class wpfgc {

		protected static $instance = null;
		protected static $clear_cache = false;
		protected static $wpfgc_name = 'wp-file-get-contents';

		public static function &get_instance() {
			if ( self::$instance === null )
				self::$instance = new self;
			return self::$instance;
		}

		public function __construct() {
			// allow for a custom shortcode name
			if ( defined( 'WPFGC_SHORTCODE_NAME' ) && WPFGC_SHORTCODE_NAME )
				self::$wpfgc_name = WPFGC_SHORTCODE_NAME;

			if ( ! is_admin() ) {
				$this->wpautop();
				$this->add_shortcode();
			} else add_action( 'save_post', array( &$this, 'clear_cache' ), 10 );
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
        		add_shortcode( self::$wpfgc_name, array( &$this, 'do_shortcode' ) );
		}

		public function remove_shortcode() {
			remove_shortcode( self::$wpfgc_name );
		}

		public function do_shortcode( $atts, $content = null ) { 

			$pre = empty( $atts['pre'] ) ? false : true;				// wrap content in pre tags
			$add_class = empty( $atts['class'] ) ? '' : ' '.$atts['class'];		// optional css class names
			$more_link = empty( $atts['more'] ) ? true : $atts['more'];		// add more link (default is true)
			$filter_name = empty( $atts['filter'] ) ? false : $atts['filter'];	// optional content filter
			$cache_expire = isset( $atts['cache'] ) ? $atts['cache'] : 3600;	// allow for 0 seconds (default 1 hour)

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

			if ( self::$clear_cache ) {
				delete_transient( $cache_id );
				return '<p>'.__CLASS__.': <em>cache cleared for '.$url.'</em>.</p>';
			} elseif ( $cache_expire > 0 ) {
				$content = get_transient( $cache_id );
			} else delete_transient( $cache_id );

			if ( $content === false )
				$content = file_get_contents( $url );
			else return $content;	// content from cache

			if ( $more_link && ! is_singular() ) {
				global $post;
				$parts = get_extended( $content );
				if ( $parts['more_text'] )
					$content = $parts['main'].apply_filters( 'the_content_more_link', 
						' <a href="'.get_permalink().'#more-{'.$post->ID.'}" class="more-link">'.$parts['more_text'].'</a>', 
							$parts['more_text'] );
				else $content = $parts['main'];
			}

			$content = '<div class="wp_file_get_contents'.$add_class.'">'."\n".
				( $pre ? "<pre>\n" : '' ).$content.( $pre ? "</pre>\n" : '' ).'</div>'."\n";

			if ( ! empty( $filter_name ) ) {
				$this->remove_shortcode();	// prevent recursion
				$content = apply_filters( $filter_name, $content );
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
						strpos( $post_obj->post_content, '['.self::$wpfgc_name ) ) {

						if ( $is_admin )
							$this->add_shortcode();
						self::$clear_cache = true;	// clear cache and return
						$content = do_shortcode( $post_obj->post_content );
						if ( $is_admin )
							$this->remove_shortcode();
					}
					break;
			}
			return $post_id;
		}
	}

        global $wpfgc;
        $wpfgc = wpfgc::get_instance();
}

?>

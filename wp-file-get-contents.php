<?php
/**
 * Plugin Name: JSM's file_get_contents() Shortcode
 * Plugin URI: http://surniaulula.com/extend/plugins/wp-file-get-contents/
 * Author: JS Morisset
 * Author URI: http://surniaulula.com/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl.txt
 * Description: A WordPress shortcode for PHP's file_get_contents()
 * Requires At Least: 3.0
 * Tested Up To: 4.5.3
 * Version: 1.2.0
 * 
 * Copyright 2012-2016 Jean-Sebastien Morisset (http://surniaulula.com/)
 */


if ( ! defined( 'ABSPATH' ) ) 
	die( 'These aren\'t the droids you\'re looking for...' );

if ( ! class_exists( 'wpfgc' ) ) {

	class wpfgc {

		protected static $instance = null;
		protected static $sc_name = 'wp-file-get-contents';

		public static function &get_instance() {
			if ( self::$instance === null )
				self::$instance = new self;
			return self::$instance;
		}

		public function __construct() {
			// allow for a custom shortcode name
			if ( defined( 'WPFGC_SHORTCODE_NAME' ) && WPFGC_SHORTCODE_NAME )
				self::$sc_name = WPFGC_SHORTCODE_NAME;

			if ( ! is_admin() ) {
				$this->wpautop();
				$this->add_shortcode();
			}
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
        		add_shortcode( self::$sc_name, array( &$this, 'do_shortcode' ) );
		}

		public function remove_shortcode() {
			remove_shortcode( self::$sc_name );
		}

		public function do_shortcode( $atts, $content = null ) { 
			$pre = array_key_exists( 'pre', $atts ) && ! empty( $atts['pre'] ) ? true : false;
			$add_class = array_key_exists( 'class', $atts ) ? ' '.$atts['class'] : '';
			$more_link = array_key_exists( 'more', $atts ) ? $atts['more'] : true;
			$cache_expire = array_key_exists( 'cache', $atts ) ? $atts['cache'] : 3600;
			$apply_filter = array_key_exists( 'filter', $atts ) ? $atts['filter'] : false;

			if ( ! empty( $atts['url'] ) && preg_match( '/^https?:\/\//', $atts['url'] ) )
				$url = $atts['url'];
			elseif ( ! empty( $atts['url'] ) && preg_match( '/^file:\/\//', $atts['url'] ) )
				$url = trailingslashit( WP_CONTENT_DIR ).preg_replace( '/(^file:\/\/|\.\.)/', '', $atts['url'] );
			elseif ( ! empty( $atts['file'] ) )
				$url = trailingslashit( WP_CONTENT_DIR ).preg_replace( '/(^\/+|\.\.)/', '', $atts['file'] );
			else $content = '<p>'.__CLASS__.': <em><code>url</code> or <code>file</code> shortcode attribute missing</em></p>';

			if ( ! empty( $url ) ) {
				$cache_salt = __METHOD__.'(url:'.$url.')';
				$cache_id = __CLASS__.'_'.md5( $cache_salt );
				if ( $cache_expire > 0 ) {
					$content = get_transient( $cache_id );
					if ( $content === false ) {
						$content = file_get_contents( $url );
						set_transient( $cache_id, $content, $cache_expire );
					}
				} else {
					delete_transient( $cache_id );
					$content = file_get_contents( $url );
				}
			}

			if ( ! is_singular() && $more_link ) {
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

			if ( ! empty( $apply_filter ) ) {
				$this->remove_shortcode();	// prevent recursion
				$content = apply_filters( $apply_filter, $content );
				$this->add_shortcode();
			}

			return $content;
		}
	}

        global $wpfgc;
        $wpfgc = wpfgc::get_instance();
}

?>

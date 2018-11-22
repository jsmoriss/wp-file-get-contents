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
 * Requires PHP: 5.4
 * Requires At Least: 3.8
 * Tested Up To: 5.0
 * Version: 1.5.0
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2012-2018 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for...' );
}

if ( ! class_exists( 'WPFGC' ) ) {

	class WPFGC {

		private $do_clear_cache = false;
		private $shortcode_name = 'wp-file-get-contents';

		private static $instance;

		public function __construct() {
			add_action( 'plugins_loaded', array( __CLASS__, 'load_textdomain' ) );

			// allow for a custom shortcode name
			if ( defined( 'WPFGC_SHORTCODE_NAME' ) && WPFGC_SHORTCODE_NAME ) {
				$this->shortcode_name = WPFGC_SHORTCODE_NAME;
			}

			if ( is_admin() ) {
				add_action( 'save_post', array( $this, 'clear_post_cache' ), 10 );
			} else {
				$this->check_wpautop();
				$this->add_shortcode();
			}
		}

		public static function &get_instance() {

			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public static function load_textdomain() {
			load_plugin_textdomain( 'wp-file-get-contents', false, 'wp-file-get-contents/languages/' );
		}

		public function check_wpautop() {

			$default_priority = 10;

			foreach ( array( 'get_the_excerpt', 'the_excerpt', 'the_content' ) as $filter_name ) {

				$filter_priority = has_filter( $filter_name, 'wpautop' );

				if ( false !== $filter_priority && $filter_priority > $default_priority ) {

					remove_filter( $filter_name, 'wpautop' );

					add_filter( $filter_name, 'wpautop' , $default_priority );
				}
			}
		}

		public function add_shortcode() {
        		add_shortcode( $this->shortcode_name, array( $this, 'do_shortcode' ) );
		}

		public function remove_shortcode() {
			remove_shortcode( $this->shortcode_name );
		}

		public function do_shortcode( $atts = array(), $content = null, $tag = '' ) { 

			if ( ! is_array( $atts ) ) {	// empty string if no shortcode attributes
				$atts = array();
			}

			$add_pre = isset( $atts['pre'] ) ? self::get_bool( $atts['pre'] ) : false;	// wrap content in pre tags (default is false)
			$add_class = empty( $atts[ 'class' ] ) ? '' : ' ' . $atts[ 'class' ];		// optional css class names
			$do_filter = isset( $atts['filter'] ) ? $atts['filter'] : false;		// optional content filter
			$more_link = isset( $atts['more'] ) ? self::get_bool( $atts['more'] ) : true;	// add more link (default is true)
			$body_only = isset( $atts['body'] ) ? self::get_bool( $atts['body'] ) : true;	// keep only <body></body> content
			$cache_secs = isset( $atts['cache'] ) ? (int) $atts['cache'] : 3600;		// allow for 0 seconds (default 1 hour)

			// determine the url / filename to retrieve
			if ( ! empty( $atts[ 'url' ] ) && preg_match( '/^https?:\/\//', $atts[ 'url' ] ) ) {
				$url = $atts[ 'url' ];
			} elseif ( ! empty( $atts[ 'url' ] ) && preg_match( '/^file:\/\//', $atts[ 'url' ] ) ) {
				$url = trailingslashit( WP_CONTENT_DIR ).preg_replace( '/(^file:\/\/|\.\.)/', '', $atts[ 'url' ] );
			} elseif ( ! empty( $atts['file'] ) ) {
				$url = trailingslashit( WP_CONTENT_DIR ).preg_replace( '/(^\/+|\.\.)/', '', $atts['file'] );
			} else {
				return '<p>' . __CLASS__ . ': <em><code>url</code> or <code>file</code> shortcode attribute missing</em>.</p>';
			}

			$content    = false;	// Just in case.
			$cache_salt = __METHOD__ . '(url:' . $url . ')';
			$cache_id   = __CLASS__ . '_' . md5( $cache_salt );

			if ( $this->do_clear_cache ) {
				delete_transient( $cache_id );
				return '<p>' . __CLASS__ . ': <em>cache cleared for ' . $url . '</em>.</p>';
			} elseif ( $cache_secs > 0 ) {
				$content = get_transient( $cache_id );
			} else {
				delete_transient( $cache_id );
			}

			if ( false === $content ) {
				$content = file_get_contents( $url );
			} else {
				return $content;	// content from cache
			}
		
			if ( $body_only && false !== stripos( $content, '<body' ) ) {
				$content = preg_replace( '/^.*<body[^>]*>(.*)<\/body>.*$/is', '$1', $content );
			}

			if ( $more_link && ! is_singular() ) {
				global $post;
				$parts = get_extended( $content );
				if ( $parts['more_text'] ) {
					$content = $parts['main'].apply_filters( 'the_content_more_link', 
						' <a href="' . get_permalink() . '#more-{' . $post->ID . '}" class="more-link">' . $parts['more_text'] . '</a>', 
							$parts['more_text'] );
				} else {
					$content = $parts['main'];
				}
			}

			$content = '<div class="wp_file_get_contents' . $add_class . '">' . "\n" . 
				( $add_pre ? "<pre>\n" : '' ) . $content . ( $add_pre ? "</pre>\n" : '' ) . 
				'</div><!-- .wp_file_get_contents -->' . "\n";

			if ( $do_filter ) {
				$this->remove_shortcode();	// Just in case - prevent recursion.
				$content = apply_filters( $do_filter, $content );
				$this->add_shortcode();
			}

			if ( $cache_secs > 0 ) {
				set_transient( $cache_id, $content, $cache_secs );	// save rendered content
			}

			return $content;
		}

		public function clear_post_cache( $post_id, $rel_id = false ) {

			switch ( get_post_status( $post_id ) ) {

				case 'draft':
				case 'pending':
				case 'future':
				case 'private':
				case 'publish':

					$is_admin = is_admin();
					$post_obj = get_post( $post_id, OBJECT, 'raw' );

					if ( isset( $post_obj->post_content ) && false !== stripos( $post_obj->post_content, '[' . $this->shortcode_name ) ) {

						if ( $is_admin ) {
							$this->add_shortcode();
						}

						$this->do_clear_cache = true;	// clear cache and return

						$content = do_shortcode( $post_obj->post_content );

						if ( $is_admin ) {
							$this->remove_shortcode();
						}
					}

					break;
			}

			return $post_id;
		}

		// converts string to boolean
		private static function get_bool( $mixed ) {
			return is_string( $mixed ) ? filter_var( $mixed, FILTER_VALIDATE_BOOLEAN ) : (bool) $mixed;
		}
	}

        WPFGC::get_instance();
}

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
 * Requires PHP: 5.6
 * Requires At Least: 4.2
 * Tested Up To: 5.4.1
 * Version: 2.1.0
 * 
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes / re-writes or incompatible API changes.
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2012-2020 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WPFGC' ) ) {

	class WPFGC {

		private $cache_disabled = false;

		private $shortcode_names = array(
			'wp-file-get-contents',
			'wpfgc',
		);

		private static $instance = null;

		public function __construct() {

			add_action( 'plugins_loaded', array( __CLASS__, 'init_textdomain' ) );

			/**
			 * Allow for an additional custom shortcode name.
			 */
			if ( defined( 'WPFGC_SHORTCODE_NAME' ) && WPFGC_SHORTCODE_NAME ) {

				if ( ! in_array( WPFGC_SHORTCODE_NAME ) ) {	// Just in case.

					$this->shortcode_names[] = WPFGC_SHORTCODE_NAME;
				}
			}

			if ( is_admin() ) {
				add_action( 'save_post', array( $this, 'clear_post_cache' ), 10 );
			}

			$this->check_wpautop();

			$this->add_shortcodes();
		}

		public static function &get_instance() {

			if ( null === self::$instance ) {

				self::$instance = new self;
			}

			return self::$instance;
		}

		public static function init_textdomain() {

			static $loaded = null;

			if ( null !== $loaded ) {
				return;
			}

			$loaded = true;

			load_plugin_textdomain( 'wp-file-get-contents', false, 'wp-file-get-contents/languages/' );
		}

		public function check_wpautop() {

			$default_priority = 10;

			foreach ( array( 'get_the_excerpt', 'the_excerpt', 'the_content' ) as $filter_name ) {

				$filter_priority = has_filter( $filter_name, 'wpautop' );	// Can return a priority of 0.

				if ( false !== $filter_priority && $filter_priority > $default_priority ) {

					remove_filter( $filter_name, 'wpautop' );

					add_filter( $filter_name, 'wpautop' , $default_priority );
				}
			}
		}

		public function add_shortcodes() {

			foreach ( $this->shortcode_names as $name ) {
        			add_shortcode( $name, array( $this, 'do_shortcode' ) );
			}
		}

		public function remove_shortcodes() {

			foreach ( $this->shortcode_names as $name ) {
				remove_shortcode( $name );
			}
		}

		public function do_shortcode( $atts = array(), $content = null, $tag = '' ) { 

			if ( ! is_array( $atts ) ) {	// Empty string if no shortcode attributes.
				$atts = array();
			}

			$add_pre    = isset( $atts[ 'pre' ] ) ? self::get_bool( $atts[ 'pre' ] ) : false;	// Wrap content in pre tags (default is false).
			$add_class  = empty( $atts[ 'class' ] ) ? '' : ' ' . $atts[ 'class' ];			// Optional css class names.
			$do_filter  = isset( $atts[ 'filter' ] ) ? $atts[ 'filter' ] : 'wpfgc_content';		// Optional content filter.
			$more_link  = isset( $atts[ 'more' ] ) ? self::get_bool( $atts[ 'more' ] ) : true;	// Add more link (default is true).
			$only_body  = isset( $atts[ 'body' ] ) ? self::get_bool( $atts[ 'body' ] ) : true;	// Keep only <body></body> content.
			$cache_secs = isset( $atts[ 'cache' ] ) ? (int) $atts[ 'cache' ] : 3600;		// Allow for 0 seconds (default 1 hour).

			/**
			 * Determine the url / file name to retrieve.
			 */
			if ( ! empty( $atts[ 'url' ] ) && preg_match( '/^https?:\/\//', $atts[ 'url' ] ) ) {

				$url = $atts[ 'url' ];

			} elseif ( ! empty( $atts[ 'url' ] ) && preg_match( '/^file:\/\//', $atts[ 'url' ] ) ) {

				$url = trailingslashit( WP_CONTENT_DIR ).preg_replace( '/(^file:\/\/|\.\.)/', '', $atts[ 'url' ] );

			} elseif ( ! empty( $atts[ 'file' ] ) ) {

				$url = trailingslashit( WP_CONTENT_DIR ).preg_replace( '/(^\/+|\.\.)/', '', $atts[ 'file' ] );

			} else {

				return '<p>' . __CLASS__ . ': <em><code>url</code> or <code>file</code> shortcode attribute missing</em>.</p>';
			}

			$cache_salt = __METHOD__ . '(url:' . $url . ')';
			$cache_id   = __CLASS__ . '_' . md5( $cache_salt );

			if ( ! $this->cache_disabled && $cache_secs > 0 ) {

				$content = get_transient( $cache_id );

				if ( false !== $content ) {

					return $content;
				}

			} else {
				delete_transient( $cache_id );
			}

			$content = file_get_contents( $url );
		
			if ( $only_body && false !== stripos( $content, '<body' ) ) {

				$content = preg_replace( '/^.*<body[^>]*>(.*)<\/body>.*$/is', '$1', $content );
			}

			if ( $more_link && ! is_singular() ) {

				global $post;

				$parts = get_extended( $content );

				if ( $parts[ 'more_text' ] ) {

					$content = $parts[ 'main' ] . apply_filters( 'the_content_more_link', 
						' <a href="' . get_permalink() . '#more-{' . $post->ID . '}" class="more-link">' . $parts[ 'more_text' ] . '</a>', 
							$parts[ 'more_text' ] );

				} else {

					$content = $parts[ 'main' ];
				}
			}

			$content = '<div class="wp_file_get_contents wpfgc' . $add_class . '">' . "\n" . 
				( $add_pre ? "<pre>\n" : '' ) . $content . ( $add_pre ? "</pre>\n" : '' ) . 
					'</div><!-- .wp_file_get_contents -->' . "\n";

			if ( $do_filter ) {

				$this->remove_shortcodes();	// Just in case - prevent recursion.

				$content = apply_filters( $do_filter, $content );

				$this->add_shortcodes();
			}

			if ( $cache_secs > 0 ) {

				set_transient( $cache_id, $content, $cache_secs );	// Save rendered content.
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

					if ( isset( $post_obj->post_content ) ) {	// Just in case.

						foreach ( $this->shortcode_names as $name ) {

							if ( false !== stripos( $post_obj->post_content, '[' . $name ) ) {

								$this->cache_disabled = true;	// Clear cache and return.

								$content = do_shortcode( $post_obj->post_content );

								break;	// Stop after first shortcode match.
							}
						}
					}

					break;
			}

			return $post_id;
		}

		/**
		 * Converts string to boolean.
		 */
		private static function get_bool( $mixed ) {

			return is_string( $mixed ) ? filter_var( $mixed, FILTER_VALIDATE_BOOLEAN ) : (bool) $mixed;
		}
	}

        WPFGC::get_instance();
}

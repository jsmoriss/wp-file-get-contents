<?php
/*
 * Plugin Name: JSM file_get_contents() Shortcode
 * Text Domain: wp-file-get-contents
 * Domain Path: /languages
 * Plugin URI: https://surniaulula.com/extend/plugins/wp-file-get-contents/
 * Assets URI: https://jsmoriss.github.io/wp-file-get-contents/assets/
 * Author: JS Morisset
 * Author URI: https://surniaulula.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Description: A WordPress shortcode for PHP's file_get_contents()
 * Requires PHP: 7.2.34
 * Requires At Least: 5.8
 * Tested Up To: 6.4.2
 * Version: 2.7.1
 *
 * Version Numbering: {major}.{minor}.{bugfix}[-{stage}.{level}]
 *
 *      {major}         Major structural code changes and/or incompatible API changes (ie. breaking changes).
 *      {minor}         New functionality was added or improved in a backwards-compatible manner.
 *      {bugfix}        Backwards-compatible bug fixes or small improvements.
 *      {stage}.{level} Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).
 *
 * Copyright 2012-2024 Jean-Sebastien Morisset (https://surniaulula.com/)
 */

if ( ! defined( 'ABSPATH' ) ) {

	die( 'These aren\'t the droids you\'re looking for.' );
}

if ( ! class_exists( 'WPFGC' ) ) {

	class WPFGC {

		private $cache_disabled = false;	// Signal to clear and re-create the cache object.

		private $shortcode_names = array(	// Default list of shortcode names.
			'wp-file-get-contents',
			'wpfgc',
		);

		private static $instance = null;	// WPFGC class object.

		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'init_textdomain' ) );

			/*
			 * Allow for an additional custom shortcode name.
			 */
			if ( defined( 'WPFGC_SHORTCODE_NAME' ) && WPFGC_SHORTCODE_NAME ) {

				if ( ! in_array( WPFGC_SHORTCODE_NAME, $this->shortcode_names ) ) {	// Just in case.

					$this->shortcode_names[] = WPFGC_SHORTCODE_NAME;
				}
			}

			if ( is_admin() ) {

				add_action( 'save_post', array( $this, 'clear_post_cache' ), -1000 );
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

		public function init_textdomain() {

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

			/*
			 * $atts is an empty string if there are no shortcode attributes.
			 */
			$atts     = is_array( $atts ) ? $atts : array();
			$get_url  = '';
			$get_file = '';

			/*
			 * Sanitize the URL or relative file path to retrieve.
			 */
			if ( ! empty( $atts[ 'url' ] ) && preg_match( '/^https?:\/\//', $atts[ 'url' ] ) ) {

				/*
				 * See https://developer.wordpress.org/reference/functions/wp_http_validate_url/
				 */
				$get_url = wp_http_validate_url( $atts[ 'url' ] );

			} elseif ( ! empty( $atts[ 'url' ] ) && preg_match( '/^file:\/\//', $atts[ 'url' ] ) ) {

				/*
				 * Create a relative file path.
				 *
				 * Remove the URL scheme, two or more dots.
				 *
				 * See https://developer.wordpress.org/reference/functions/sanitize_text_field/
				 */
				$get_file = sanitize_text_field( preg_replace( '/(^file:\/+|\.\.+)/', '', $atts[ 'url' ] ) );

			} elseif ( ! empty( $atts[ 'file' ] ) ) {

				/*
				 * Create a relative file path.
				 *
				 * Remove the URL scheme, leading slash, two or more dots.
				 *
				 * See https://developer.wordpress.org/reference/functions/sanitize_text_field/
				 */
				$get_file = sanitize_text_field( preg_replace( '/(^[a-z]*:\/+|^\/+|\.\.+)/', '', $atts[ 'file' ] ) );
			}

			if ( ! empty( $get_url ) ) {

				// Nothing to do.

			} elseif ( ! empty( $get_file ) ) {

				$get_file = trailingslashit( WP_CONTENT_DIR ) . $get_file;	// Complete the relative file path.

			} else {

				$error_msg = sprintf( __( '%1$s or %2$s shortcode attribute missing or invalid.', 'wp-file-get-contents' ),
					'<code>url</code>', '<code>file</code>' );

				return '<p><strong>' . __CLASS__ . ': ' . $error_msg . '</strong></p>';	// Stop here.
			}

			/*
			 * For 'code_lang' and 'pre_lang' values see https://highlightjs.readthedocs.io/en/latest/supported-languages.html.
			 */
			$cache_salt           = __METHOD__ . '_' . $this->get_atts_salt( $atts );
			$cache_id             = __CLASS__ . '_' . md5( $cache_salt );
			$do_body              = isset( $atts[ 'body' ] ) ? self::get_bool( $atts[ 'body' ] ) : true;
			$do_cache             = isset( $atts[ 'cache' ] ) ? (int) $atts[ 'cache' ] : 3600;
			$do_class             = empty( $atts[ 'class' ] ) ? '' : esc_attr( $atts[ 'class' ] );		// Optional div container class names.
			$do_code              = isset( $atts[ 'code' ] ) ? self::get_bool( $atts[ 'code' ] ) : false;
			$do_code_class        = empty( $atts[ 'code_class' ] ) ? '' : esc_attr( $atts[ 'code_class' ] );
			$do_code_lang         = empty( $atts[ 'code_lang' ] ) ? '' : esc_attr( $atts[ 'code_lang' ] );
			$do_esc_html          = isset( $atts[ 'esc_html' ] ) ? self::get_bool( $atts[ 'esc_html' ] ) : false;
			$do_esc_html_pre_code = isset( $atts[ 'esc_html_pre_code' ] ) ? self::get_bool( $atts[ 'esc_html_pre_code' ] ) : false;
			$do_esc_html_pre_code = isset( $atts[ 'pre_code_esc_html' ] ) ? self::get_bool( $atts[ 'pre_code_esc_html' ] ) : $do_esc_html_pre_code;
			$do_filter            = isset( $atts[ 'filter' ] ) ? sanitize_text_field( $atts[ 'filter' ] ) : 'wpfgc_content';
			$do_more              = isset( $atts[ 'more' ] ) ? self::get_bool( $atts[ 'more' ] ) : true;	// Add more link (default is true).
			$do_pre               = isset( $atts[ 'pre' ] ) ? self::get_bool( $atts[ 'pre' ] ) : false;
			$do_pre_class         = empty( $atts[ 'pre_class' ] ) ? '' : esc_attr( $atts[ 'pre_class' ] );
			$do_pre_code          = isset( $atts[ 'pre_code' ] ) ? self::get_bool( $atts[ 'pre_code' ] ) : false;
			$do_pre_lang          = empty( $atts[ 'pre_lang' ] ) ? '' : esc_attr( $atts[ 'pre_lang' ] );
			$do_pre_title         = empty( $atts[ 'pre_title' ] ) ? '' : esc_attr( $atts[ 'pre_title' ] );
			$do_utf8              = isset( $atts[ 'utf8' ] ) ? self::get_bool( $atts[ 'utf8' ] ) : true;

			if ( $do_code_lang )         { $do_esc_html_pre_code = true; $do_code_class = trim( $do_code_class . ' language-' . $do_code_lang ); }
			if ( $do_pre_lang )          { $do_esc_html_pre_code = true; $do_pre_class = trim( $do_pre_class . ' language-' . $do_pre_lang ); }
			if ( $do_esc_html_pre_code ) { $do_esc_html = $do_pre_code = true; }
			if ( $do_pre_code )          { $do_pre = $do_code = true; }

			if ( $this->cache_disabled ) {	// Signal to clear and re-create the cache object.

				delete_transient( $cache_id );

			} elseif ( $do_cache ) {

				$content = get_transient( $cache_id );

				if ( false !== $content ) {

					return $this->format_content( $content, $atts );
				}
			}

			/*
			 * Get the sanitized URL or file path content.
			 */
			$content = file_get_contents( $get_url ? $get_url : $get_file );

			/*
			 * Maybe keep only <body></body> content (default is true).
			 */
			if ( $do_body && false !== stripos( $content, '<body' ) ) {

				$content = preg_replace( '/^.*<body[^>]*>(.*)<\/body>.*$/is', '$1', $content );
			}

			/*
			 * Maybe escape HTML characters (default is false).
			 */
			if ( $do_esc_html ) {

				$content = esc_html( $content );
			}

			/*
			 * Maybe convert UTF-8 to HTML entities (default is true).
			 */
			if ( $do_utf8 && function_exists( 'mb_convert_encoding' ) ) {

				$content = mb_convert_encoding( $content, $to_encoding = 'HTML-ENTITIES', $from_encoding = 'UTF-8' );
			}

			/*
			 * Maybe wrap content in code tags before pre tags (default is false).
			 */
			if ( $do_code ) {

				$content = '<code' . ( $do_code_class ? ' class="' . $do_code_class . '"' : '' ) . '>' . $content . '</code>';
			}

			/*
			 * Maybe wrap content in pre tags (default is false).
			 */
			if ( $do_pre ) {

				$content = '<pre' . ( $do_pre_class ? ' class="' . $do_pre_class . '"' : '' ) .
					( $do_pre_title ? ' title="' . $do_pre_title . '"' : '' ) . '>' . $content . '</pre>';
			}

			/*
			 * Apply content filter name (default is 'wpfgc_content').
			 */
			if ( $do_filter ) {

				$this->remove_shortcodes();	// Just in case, to prevent recursion.

				$content = apply_filters( $do_filter, $content );

				$this->add_shortcodes();
			}

			/*
			 * Maybe cache the content (default is 1 hour).
			 */
			if ( $do_cache ) {

				set_transient( $cache_id, $content, $do_cache );	// Save rendered content.
			}

			return $this->format_content( $content, $atts );
		}

		/*
		 * Hooked to the 'save_post' action.
		 */
		public function clear_post_cache( $post_id, $rel_id = false ) {

			switch ( get_post_status( $post_id ) ) {

				case 'draft':
				case 'pending':
				case 'future':
				case 'private':
				case 'publish':
				case 'expired':

					$is_admin = is_admin();
					$post_obj = get_post( $post_id, OBJECT, 'raw' );

					if ( isset( $post_obj->post_content ) ) {	// Just in case.

						foreach ( $this->shortcode_names as $name ) {

							if ( false !== stripos( $post_obj->post_content, '[' . $name ) ) {

								$this->cache_disabled = true;	// Signal to clear and re-create the cache object.

								$content = do_shortcode( $post_obj->post_content );

								break;	// Stop after first shortcode match.
							}
						}
					}

					break;
			}

			return $post_id;
		}

		private function get_atts_salt( $atts ) {

			unset( $atts[ 'cache' ], $atts[ 'class' ], $atts[ 'more' ] );	// Not relevant for cache salt.

			return implode( '_', array_map( function( $k, $v ) { return $k . ':' . $v; }, array_keys( $atts ), array_values( $atts ) ) );
		}

		private function format_content( $content, $atts ) {

			$do_class = empty( $atts[ 'class' ] ) ? '' : esc_attr( $atts[ 'class' ] );		// Optional div container class names.
			$do_more  = isset( $atts[ 'more' ] ) ? self::get_bool( $atts[ 'more' ] ) : true;	// Add more link (default is true).

			/*
			 * Maybe add a more link (default is true).
			 */
			if ( $do_more && ! is_singular() ) {

				global $post;

				$parts = get_extended( $content );

				if ( $parts[ 'more_text' ] ) {

					$more_link = sprintf( ' <a href="%s#more-{%s}" class="more-link">%s</a>', get_permalink(), $post->ID, $parts[ 'more_text' ] );

					$more_link = apply_filters( 'the_content_more_link', $more_link, $parts[ 'more_text' ] );

					$content = $parts[ 'main' ] . $more_link;

				} else {

					$content = $parts[ 'main' ];
				}
			}

			$content = '<div class="wp_file_get_contents wpfgc' . ( $do_class ? ' ' . $do_class : '' ) . '">' . "\n" .
				$content . '</div><!-- .wp_file_get_contents -->' . "\n";

			return $content;
		}

		/*
		 * Converts string to boolean.
		 */
		private static function get_bool( $mixed ) {

			return is_string( $mixed ) ? filter_var( $mixed, FILTER_VALIDATE_BOOLEAN ) : (bool) $mixed;
		}
	}

        WPFGC::get_instance();
}

<?php
/**
 * Plugin Name: Lightning Slide and PageHeader Fixer
 * Plugin URI: https://lightning.nagoya/
 * Description: Plugin for fix Slide Show and PageHeader.
 * Version: 1.0.0
 * Author:  Vektor,Inc.
 * Author URI: https://lightning.nagoya/
 * Text Domain:     lightning-slide-and-page-header-fixer
 * Domain Path:     /languages
 * License: GPL 2.0 or Later
 *
 * @package Lightning Slide and Page Header Fixer
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue Scripts
 */
function lspf_enqueue_scripts() {
	$skin = get_option( 'lightning_design_skin' );
	if ( 'variety-bs4' === $skin || 'charm-bs4' === $skin || 'fort-bs4' === $skin || 'fort-bs4-footer-light' === $skin || 'pale-bs4' === $skin || 'origin2' === $skin ) {
		wp_enqueue_script( 'lspf-script', plugin_dir_url( __FILE__ ) . 'assets/js/common.min.js', array( 'lightning-js' ), get_file_data( __FILE__, array( 'Version' ) ), true );
		wp_enqueue_style( 'lspf-style', plugin_dir_url( __FILE__ ) . 'assets/css/common.min.css', array(), get_file_data( __FILE__, array( 'Version' ) ) );
	}
}
add_action( 'wp_enqueue_scripts', 'lspf_enqueue_scripts' );

/**
 * Disable Header Prefix.
 */
function lspf_disable_header_prefix() {
	$skin = get_option( 'lightning_design_skin' );
	if ( 'variety-bs4' === $skin ) {
		// Variety II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'ltg_variety_add_js_option', 10, 1 );
		// Origin のヘッダー固定を復活 ( 必須 ).
		remove_filter( 'lightning_headfix_enable', 'ltg_variety_headfix_disabel' );
	} elseif ( 'charm-bs4' === $skin ) {
		// Charm II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'lightning_charm_add_js_option', 10, 1 );
		// Origin のヘッダー固定を復活 ( 必須 ).
		remove_filter( 'lightning_headfix_enable', 'ltg_charm_headfix_disabel' );
	} elseif ( 'fort-bs4' === $skin || 'fort-bs4-footer-light' === $skin ) {
		// Fort II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'lightning_fort_add_js_option', 10, 1 );
		// Origin のヘッダー固定を復活 ( 必須 ).
		remove_filter( 'lightning_headfix_enable', 'ltg_fort_headfix_disabel' );
	} elseif ( 'pale-bs4' === $skin ) {
		// Pale II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'ltg_pale_add_js_option', 10, 1 );
		// Origin のヘッダー固定を復活 ( 必須 ).
		remove_filter( 'lightning_headfix_enable', 'ltg_pale_headfix_disabel' );
	} elseif ( 'origin2' === $skin ) {
		// Origin II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'lightning_origin2_add_js_option', 10, 1 );
		// Origin のヘッダー固定を復活 ( 必須 ).
		remove_filter( 'lightning_headfix_enable', 'lightning_origin2_headfix_disabel' );
	}
}
add_action( 'init', 'lspf_disable_header_prefix' );

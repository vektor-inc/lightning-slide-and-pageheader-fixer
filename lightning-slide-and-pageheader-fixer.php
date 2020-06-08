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
 * Check Theme
 */
function lspf_plugin_active() {
	// テーマがLightning系じゃなかったら処理を終了.
	if ( ! function_exists( 'lightning_get_theme_name' ) ) {
		return;
	}
}
add_action( 'after_setup_theme', 'lspf_plugin_active' );

/**
 * Run function
 */
function lspf_skin_loadfunction() {
	$skin = get_option( 'lightning_design_skin' );
	if ( 'variety-bs4' === $skin || 'charm-bs4' === $skin || 'fort-bs4' === $skin || 'fort-bs4-footer-light' === $skin || 'pale-bs4' === $skin || 'origin2' === $skin || 'jpnstyle-bs4' === $skin ) {
		require plugin_dir_path( __FILE__ ) . 'inc/slide-and-page-header-fixer.php';
	}
}
add_action( 'plugins_loaded', 'lspf_skin_loadfunction' );

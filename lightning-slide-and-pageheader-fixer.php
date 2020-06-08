<?php
/**
 * Plugin Name: Lightning Slide and PageHeader Fixer
 * Plugin URI: https://lightning.nagoya/
 * Description: Plugin for prefix Slide Show and PageHeader.
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
	wp_enqueue_script( 'lspf-script', plugin_dir_url( __FILE__ ) . 'assets/js/common.min.js', array(), get_file_data( __FILE__, array( 'Version' ) ), true );
}
add_action( 'wp_enqueue_scripts', 'lspf_enqueue_scripts' );

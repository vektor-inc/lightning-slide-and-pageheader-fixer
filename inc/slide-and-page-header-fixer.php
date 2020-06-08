<?php
/**
 * Slide and Page Header Fix
 *
 * @package Lightning Slide and Page Header Fixer
 */

/**
 * Default Option.
 */
function lspf_default_option() {
	$args = array(
		'color_content_bg' => '#fff',
	);
	return $args;
}


/**
 * Customizer.
 *
 * @param \WP_Customize_Manager $wp_customize Customizer.
 */
function lspf_resister_customize( $wp_customize ) {

	$wp_customize->add_setting(
		'color_content_subtitle',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new Custom_Html_Control(
			$wp_customize,
			'color_content_subtitle',
			array(
				'label'            => __( 'Lightning Slide and PageHeader Fixer', 'lightning-pro' ),
				'section'          => 'lightning_design',
				'type'             => 'text',
				'custom_title_sub' => '',
				'custom_html'      => '',
				'priority'         => 601,
			)
		)
	);

	// Diaplay Setting.
	$wp_customize->add_setting(
		'lightning_theme_options[color_content_bg]',
		array(
			'default'           => '#fff',
			'type'              => 'option',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'lightning_theme_options[color_content_bg]',
			array(
				'label'    => __( 'Content Section Color', 'lightning-pro' ),
				'section'  => 'lightning_design',
				'settings' => 'lightning_theme_options[color_content_bg]',
				'priority' => 602,
			)
		)
	);
}
add_action( 'customize_register', 'lspf_resister_customize' );

/**
 * Enqueue Scripts
 */
function lspf_enqueue_scripts() {
	$options = get_option( 'lightning_theme_options' );
	$default = lspf_default_option();
	$options = wp_parse_args( $options, $default );

	wp_enqueue_script( 'lspf-script', plugin_dir_url( __DIR__ ) . 'assets/js/common.min.js', array( 'lightning-js' ), get_file_data( __FILE__, array( 'Version' ) ), true );
	wp_enqueue_style( 'lspf-style', plugin_dir_url( __DIR__ ) . 'assets/css/common.min.css', array(), get_file_data( __FILE__, array( 'Version' ) ) );
	$dynamic_css = '';
	if ( ! empty( $options['color_content_bg'] ) ) {
		$dynamic_css  = '.breadSection,';
		$dynamic_css .= '.siteContent{';
		$dynamic_css .= 'background-color:' . $options['color_content_bg'] . ';';
		$dynamic_css .= '}';
	}
	wp_add_inline_style( 'lspf-style', $dynamic_css );
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
	} elseif ( 'charm-bs4' === $skin ) {
		// Charm II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'lightning_charm_add_js_option', 10, 1 );
	} elseif ( 'fort-bs4' === $skin || 'fort-bs4-footer-light' === $skin ) {
		// Fort II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'lightning_fort_add_js_option', 10, 1 );
	} elseif ( 'pale-bs4' === $skin ) {
		// Pale II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'ltg_pale_add_js_option', 10, 1 );
	} elseif ( 'origin2' === $skin ) {
		// Origin II のヘッダー固定を解除 ( 必須 ).
		remove_filter( 'lightning_localize_options', 'lightning_origin2_add_js_option', 10, 1 );
	}
}
add_action( 'init', 'lspf_disable_header_prefix' );

/**
 * Disable JPNSTYLE Header Prefix.
 *
 * @param array $options script options.
 */
function lspf_disable_jpnstyle_header_prefix( $options ) {
	$options['header_scrool'] = false;
	return $options;
}
add_filter( 'lightning_localize_options', 'lspf_disable_jpnstyle_header_prefix', 10, 1 );

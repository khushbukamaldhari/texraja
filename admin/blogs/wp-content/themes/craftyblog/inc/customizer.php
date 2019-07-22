<?php
/**
 * craftyblog Theme Customizer
 *
 * @package craftyblog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function craftyblog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'craftyblog_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'craftyblog_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'craftyblog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function craftyblog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function craftyblog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function craftyblog_customize_preview_js() {
	wp_enqueue_script( 'craftyblog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'craftyblog_customize_preview_js' );

/**
 * craftyblog featured section settings
 */

/*
 * Theme Base Color
 */

add_action( 'customize_register', 'craftyblog_customize_register_for_color' );
/**
 *
 * craftyblog Customize register color function.
 *
 * @param args $wp_customize costomize field parameter.
 */
function craftyblog_customize_register_for_color( $wp_customize ) {

	$wp_customize->add_setting(
		'base_color',
		array(
			'default'   => '#ffe9da',
			'transport' => 'refresh',
			'sanitize_callback'       => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'base_color',
			array(
				'section' => 'colors',
				'label'   => __( 'Base Color', 'craftyblog' ),
			)
		)
	);
	$wp_customize->add_panel(
			'craftyblog',
			array(
				'priority'       => 50,
				'title'          => __( 'Smart Blog Settings', 'craftyblog' ),
				'capability'     => 'edit_theme_options',
			)
		);
		$wp_customize->add_section(
			'social_links',
			array(
				'priority'       => 1,
				'panel'          => 'craftyblog',
				'title'          => __( 'Social Links', 'craftyblog' ),
				'description'    => __( 'Social Links. to disable social Icon keep that fields empty.', 'craftyblog' ),
				'capability'     => 'edit_theme_options',
			)
		);

		$wp_customize->add_setting(
			'facebook',
			array(
				'default'              => esc_url( 'https://facebook.com' ),
				'transport'            => 'refresh', // Options: refresh or postMessage.
				'capability'           => 'edit_theme_options',
				'sanitize_callback'     => 'esc_url_raw',
			)
		);
		// Control: Name.
		$wp_customize->add_control(
			'facebook',
			array(
				'label'       => __( 'Facebook Link', 'craftyblog' ),
				'section'     => 'social_links',
				'type'        => 'url',
			)
		);

		$wp_customize->add_setting(
			'twitter',
			array(
				'default'              => esc_url( 'https://twitter.com' ),
				'transport'            => 'refresh', // Options: refresh or postMessage.
				'capability'           => 'edit_theme_options',
				'sanitize_callback'     => 'esc_url_raw',
			)
		);
		// Control: Name.
		$wp_customize->add_control(
			'twitter',
			array(
				'label'       => __( 'twitter Link', 'craftyblog' ),
				'section'     => 'social_links',
				'type'        => 'url',
			)
		);
		$wp_customize->add_setting(
			'pinterest',
			array(
				'default'              => esc_url( 'https://pinterest.com' ),
				'transport'            => 'refresh', // Options: refresh or postMessage.
				'capability'           => 'edit_theme_options',
				'sanitize_callback'     => 'esc_url_raw',
			)
		);
		// Control: Name.
		$wp_customize->add_control(
			'pinterest',
			array(
				'label'       => __( 'pinterest Link', 'craftyblog' ),
				'section'     => 'social_links',
				'type'        => 'url',
			)
		);
		$wp_customize->add_setting(
			'googleplus',
			array(
				'default'              => esc_url( 'https://google.com' ),
				'transport'            => 'refresh', // Options: refresh or postMessage.
				'capability'           => 'edit_theme_options',
				'sanitize_callback'     => 'esc_url_raw',
			)
		);
		// Control: Name.
		$wp_customize->add_control(
			'googleplus',
			array(
				'label'       => __( 'Google plus Link', 'craftyblog' ),
				'section'     => 'social_links',
				'type'        => 'url',
			)
		);
		$wp_customize->add_setting(
			'youtube',
			array(
				'default'              => esc_url( 'https://youtube.com' ),
				'transport'            => 'refresh', // Options: refresh or postMessage.
				'capability'           => 'edit_theme_options',
				'sanitize_callback'     => 'esc_url_raw',
			)
		);
		// Control: Name.
		$wp_customize->add_control(
			'youtube',
			array(
				'label'       => __( 'youtube Link', 'craftyblog' ),
				'section'     => 'social_links',
				'type'        => 'url',
			)
		);


}


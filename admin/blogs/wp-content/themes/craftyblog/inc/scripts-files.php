<?php
/**
 * Enqueue scripts and styles.
 *
 * @package craftyblog
 */

/**
 *
 * Enqueue Fonts
 */
if ( ! function_exists( 'craftyblog_fonts_url' ) ) :
	/**
	 *
	 * Fonts Function URL
	 */
	function craftyblog_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin';
		if ( 'off' !== _x( 'on', 'Raleway Font: on or off', 'craftyblog' ) ) {
			$fonts[] = 'Raleway:300,400,500,700,800,900';
		}
		if ( 'off' !== _x( 'on', 'Leckerli+One: on or off', 'craftyblog' ) ) {
			$fonts[] = 'Leckerli+One';
		}
		if ( 'off' !== _x( 'on', 'Pacifico: on or off', 'craftyblog' ) ) {
			$fonts[] = 'Pacifico';
		}
		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				),
				'https://fonts.googleapis.com/css'
			);
		}
		return $fonts_url;
	}
endif;


/**
 * Enqueue scripts and styles.
 */
function craftyblog_scripts() {
	wp_enqueue_style( 'craftyblog-fonts', craftyblog_fonts_url() );

	wp_enqueue_style( 'craftyblog-style', get_stylesheet_uri(), array(), filemtime( get_theme_file_path( 'style.css' ) ), 'all' );

	wp_enqueue_style( 'font-awesome', get_theme_file_uri( 'asset/css/font-awesome.css' ) );
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( 'asset/css/bootstrap.css' ) );

	wp_enqueue_style( 'owl-carousel', get_theme_file_uri( 'asset/css/owl.carousel.css' ) );

	wp_enqueue_style( 'stellarnav', get_theme_file_uri( 'asset/css/stellarnav.css' ) );
	wp_enqueue_style( 'craftyblog-reset', get_theme_file_uri( 'asset/css/reset.css' ), array(), filemtime( get_theme_file_path( 'asset/css/reset.css' ) ), 'all' );

	wp_enqueue_style( 'craftyblog-main', get_theme_file_uri( 'asset/css/main.css' ), array(), filemtime( get_theme_file_path( 'asset/css/main.css' ) ), 'all' );

	wp_enqueue_style( 'craftyblog-theme', get_theme_file_uri( 'asset/css/craftyblog.css' ), array(), filemtime( get_theme_file_path( 'asset/css/craftyblog.css' ) ), 'all' );

	$data = '
		.nav-bar-area,.nav-bar-area .menu, section.widget h2.widget-title, footer.site-footer {
		    background-color: ' . esc_attr( get_theme_mod( 'base_color' ) ) . ';
		}
	';

	wp_add_inline_style( 'craftyblog-theme', $data );

	wp_enqueue_script( 'bootstrap', get_theme_file_uri( 'asset/js/bootstrap.js' ), array( 'jquery' ), '4.1.3', true );
	wp_enqueue_script( 'owl-carousel', get_theme_file_uri( 'asset/js/owl.carousel.js' ), array( 'jquery' ), '4.1.3', true );

	wp_enqueue_script( 'stellarnav', get_theme_file_uri( 'asset/js/stellarnav.js' ), array( 'jquery' ), '2.6.0', true );

	wp_enqueue_script( 'craftyblog-active', get_theme_file_uri( 'asset/js/main.js' ), array( 'jquery' ), filemtime( get_theme_file_path( 'asset/js/main.js' ) ), true );

	wp_enqueue_script( 'craftyblog-navigation', get_theme_file_uri( 'js/navigation.js' ), array(), filemtime( get_theme_file_path( 'js/navigation.js' ) ), true );

	wp_enqueue_script( 'craftyblog-skip-link-focus-fix', get_theme_file_uri( 'js/skip-link-focus-fix.js' ), array(), filemtime( get_theme_file_path( 'js/skip-link-focus-fix.js' ) ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'craftyblog_scripts' );

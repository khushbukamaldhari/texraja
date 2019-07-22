<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package craftyblog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="site-branding-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-3 text-left">
						<div class="social-icon">
							<?php 
							$facebook = get_theme_mod( 'facebook' );
							$twitter = get_theme_mod('twitter');
							$googleplus = get_theme_mod('googleplus');
							$pinterest = get_theme_mod('pinterest');
							$youtube = get_theme_mod('youtube');
							if(!empty($facebook)) : ?>
								<a href="<?php echo esc_url( $facebook ); ?>" class="fa fa-facebook"></a>
								<?php endif; if(!empty($twitter)):
									?>
								<a href="<?php echo esc_url( $twitter ); ?>" class="fa fa-twitter"></a>
								<?php endif; if(!empty($googleplus)) :?>
								<a href="<?php echo esc_url( $googleplus ); ?>" class="fa fa-google-plus"></a>
								<?php endif; if(!empty($pinterest)) : ?>
								<a href="<?php echo esc_url( $pinterest ); ?>" class="fa fa-pinterest"></a>
								<?php endif; if(!empty($youtube)) :?>
								<a href="<?php echo esc_url( $youtube ); ?>" class="fa fa-youtube"></a>
							<?php endif;?>
						</div>
					</div>
					<div class="col-lg-6 col-md-5 text-center">
						<div class="site-branding text-center">
							<?php
							if ( has_custom_logo() ) :
								the_custom_logo();
							else :
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								endif;
								$craftyblog_description = get_bloginfo( 'description', 'display' );
								if ( $craftyblog_description || is_customize_preview() ) :
									?>
									<p class="site-description"><?php echo esc_html($craftyblog_description); /* WPCS: xss ok. */ ?></p>
									<?php
								endif;
							endif;
							?>
						</div><!-- .site-branding -->
					</div>
					<div class="col-lg-3 col-md-4">
						<div class="search-form-header">
							<?php get_search_form(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="nav-bar-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="stellarnav" id="stellarnav">
							<!--navbar nav-->
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
									'container' => 'ul',
								)
							);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->
	<div id="content" class="site-content">
<?php

get_template_part( 'template-parts/content/page', 'banner' );
?>

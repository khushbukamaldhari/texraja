<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package craftyblog
 */

get_header();
?>
<div class="featured-area">
	<?php
		get_template_part( 'template-parts/content/featured', 'section' );
	?>
</div>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-lg-7 col-md-8">
						<?php
						if ( have_posts() ) :

							if ( is_home() && ! is_front_page() ) :
								?>
								<header>
									<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
								</header>
								<?php
							endif;

							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content/content', get_post_type() );
                                                                $category = get_the_terms(get_the_ID(), 'categories' );
                                                                 print_r($category);
                                                                 print_r('hii');
						endwhile;

							the_posts_navigation(
								array(
									'mid_size'           => 1,
									'prev_text'          => __( 'Prev', 'craftyblog' ),
									'next_text'          => __( 'Next', 'craftyblog' ),
									'screen_reader_text' => ' ',
								)
							);

						else :

							get_template_part( 'template-parts/content/content', 'none' );
//                                                        get_template_part( 'template-parts/content/content', get_post_type() );
                                                             
						endif;
						?>

					</div>
					<div class="col-md-4">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();

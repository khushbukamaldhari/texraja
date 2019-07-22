<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package craftyblog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-blog-item' ); ?>>
	<header class="entry-header">
		<?php
		$categories = get_the_terms( $post->ID, 'category' );
		if ( is_array( $categories ) ) :
			$i = 0;
			foreach ( $categories as $category ) :
				$i++;
				$hypen = '';
				if ( $i < count( $categories ) ) {
					$hypen = '<span>-</span>';
				}
				$catlink = get_category_link( $category->term_id );
				echo '<h4 class="categories"><a href="' . esc_url( $catlink ) . '">' . esc_html( $category->name ) . wp_kses_post( $hypen ) . '</a></h4>';
			endforeach;
		endif;
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				craftyblog_posted_on();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php craftyblog_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) :
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'craftyblog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'craftyblog' ),
					'after'  => '</div>',
				)
			);
	else :
		if ( has_excerpt() ) {
			echo '<div class="excerpt">' . esc_html( get_the_excerpt() ) . '<a href="' . esc_url( get_the_permalink() ) . '">' . esc_html__( 'Read More', 'craftyblog' ) . '</a></div>';
		} else {
			echo '<div class="excerpt">' . esc_html( craftyblog_get_excerpt( 350 ) ) . '<a href="' . esc_url( get_the_permalink() ) . '">' . esc_html__( 'Read More', 'craftyblog' ) . '</a></div>';
		}
	endif;
	?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php
/**
 * Template part for displaying results in search pages
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
			foreach ( $categories as $category ) :
				$catlink = get_category_link( $category->term_id );
				echo '<h4 class="categories"><a href="' . esc_url( $catlink ) . '">' . esc_html( $category->name ) . '-</a></h4>';
			endforeach;
		endif;
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>
	<div class="entry-meta">
		<?php
		craftyblog_posted_on();
		?>
	</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<?php craftyblog_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		if ( has_excerpt() ) {
			echo '<div class="excerpt">' . esc_html( get_the_excerpt() ) . '<a href="' . esc_url( get_the_permalink() ) . '">' . esc_html__( 'Read More', 'craftyblog' ) . '</a></div>';
		} else {
			echo '<div class="excerpt">' . esc_html( craftyblog_get_excerpt( 350 ) ) . '<a href="' . esc_url( get_the_permalink() ) . '">' . esc_html__( 'Read More', 'craftyblog' ) . '</a></div>';
		}
		?>
	</div><!-- .entry-summary -->

</article><!-- #post-<?php the_ID(); ?> -->

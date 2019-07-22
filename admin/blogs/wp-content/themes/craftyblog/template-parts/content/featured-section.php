<?php
/**
 * Template part for displaying featured section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package craftyblog
 */

?>
<section class="featred-section">
	<div class="container">
		<?php

		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'post',
			'ignore_sticky_posts' => 1,
		);
		$featrured_posts = new WP_Query( $args );
		?>
		<div class="lg-featured-slider">
				<?php
				while ( $featrured_posts->have_posts() ) :
					$featrured_posts->the_post();
					?>
				<div class="large-post">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail();
					} else {
						echo '<div class="no-posthtumb-lg"></div>';
					}
					?>
					<div class="post-absolute-content">
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
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						?>
						 <div class="entry-meta">
							<?php
								craftyblog_posted_on();
							?>
						</div><!-- .entry-meta -->
					</div>
				</div>
					<?php
			endwhile;
				wp_reset_postdata();
				?>
		</div>
	</div>
</section>

<section class="featured-slider-section">
	<div class="container">
		<div class="sm-featured-slider owl-carousel">
			<?php
			$args = array(
				'posts_per_page' => 10,
				'post_type' => 'post',
				'offset' => 1,
				'ignore_sticky_posts' => 1,
			);
			$featrured_sm_posts = new WP_Query( $args );
			while ( $featrured_sm_posts->have_posts() ) :
				$featrured_sm_posts->the_post();
				?>
				<div class="featured-sm-single">
					
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'craftyblog-sm-thumb' );
					} else {
						echo '<div class="no-posthtumb-sm"></div>';
					}
					?>
					<div class="post-absolute-content">
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
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
						?>
						 <div class="entry-meta">
							<?php
								craftyblog_posted_on();
							?>
						</div><!-- .entry-meta -->
					</div>
				</div>
				<?php
		endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>

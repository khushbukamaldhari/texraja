<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package craftyblog
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php
		if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) ) :
			?>
		<div class="footer-widget-area">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
					<div class="col-lg-4">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="copyright-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="site-info text-center">
							<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'craftyblog' ) ); ?>">
								<?php
								/* translators: %s: CMS name, i.e. WordPress. */
								printf( esc_html__( 'Proudly powered by %s', 'craftyblog' ), 'WordPress' );
								?>
							</a>
							<span class="sep"> | </span>
								<?php
								$creditlink = 'https://www.graphiclibrary.com/';
								/* translators: 1: Theme name, 2: Theme author. */
								printf( esc_html__( 'Theme : %1$s by %2$s.', 'craftyblog' ), 'craftyblog', '<a href="' . esc_url( $creditlink ) . '">Graphic Library</a>' );
								?>
						</div><!-- .site-info -->
					</div>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

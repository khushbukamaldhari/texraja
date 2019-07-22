<?php
/**
 *
 * Page header section
 *
 * @package craftyblog
 */

?>


<?php
global $post;
$pageheader = true;
if ( is_home() ) {
	$pageheader = false;
} else {
	if ( craftyblog_is_blog() ) {
		$pageheader = true;
	} elseif ( is_page() ) {
		$pageheader = true;
	} else {
		$pageheader = true;
	}
}
$header_image = ( has_header_image() ? get_header_image() : get_theme_file_uri( 'asset/img/blog-1.jpg' ) );


if ( true == $pageheader ) :
	?>
<section class="page-header-section" style="background-image: url(
	<?php
	if ( is_single() && is_category() ) {
		the_post_thumbnail_url( 'full' );
	} else {
		echo esc_url( $header_image );
	}
	?>
);">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="paget-title">
				  <h2>
				  <?php
					if ( is_front_page() ) {
						the_title();
					} else {
						wp_title( ' ' );
					}
					?>
					</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

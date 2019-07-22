<?php
/**
 *
 * Redesigning Default Search form
 *
 * @package craftyblog
 */

?>


<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<input type="text" name="s" placeholder="<?php esc_attr_e( 'Search...', 'craftyblog' ); ?>">
	<button class="fa fa-search" type="submit"></button>
</form>

<?php

require_once '../config/config.php';

require_once '../admin/config/admin_config.php';

if( !isset( $_SESSION['user_id'] ) ){

    header( 'Location:' . VW_LOGIN );

} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == "admin" ){

    header( 'Location:' . VW_ADMIN_HOME );

}

$extra_js[] = 'custom.js';

$common->include_header( '' );

include_once FL_BLOG_HEADER;
include_once FL_USER_HEADER;
?>  

<!--blog-section-->

<section id="blog-section" class="blog-section">

    <div class="container">

        <div class="blog-section-wrap">

            <h2 class="title">Blog</h2>

            <div class="blogs-wrap">

                <?php 
                $display_count = 9;
                $page = ( get_query_var('paged') ? get_query_var('paged') : 1 ) + 1;
                $offset = ( $page - 1 ) * $display_count;
                $wpb_all_query = new WP_Query( array(   'post_type'     => 'post',
                                                        'posts_per_page' => 9,
                                                        'post_status'   => 'publish' 

                                                    )

                                            );

                if( $wpb_all_query->have_posts() ) :

                      while( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
                        $post_create_date = get_the_date( 'l j, Y', $post_id );
                        ?>

                        <div class="blog-box">

                            <div class="blog-img-wrap">

                               <?php echo ( has_post_thumbnail() ) ? get_the_post_thumbnail( $post_id, 'full' ) : "<img src='http://herinshah.com/webcase/texraja/admin/blogs/wp-content/uploads/2019/07/default-post-thumbnail-portfolio.png' />"; ?>

                            </div>

                            <span><?php echo $post_create_date; ?></span>

                            <h2 class="blog-title"><?php the_title(); ?></h2>

                            <p><?php  
                            print_r(get_post_field( 'post_content', $post_id ));
                            print_r( htmlspecialchars( get_post_field( 'post_content', $post_id ))); ?></p>

                            <a href="#0" class="read-more">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>

                        </div>  

                        <?php 

                    endwhile;
                endif; 

                ?>
                
            </div>
            <input type="hidden" id="page_offset" name="number_page" class="number_page_add"  value="<?php echo $offset; ?>" data-totalcount = "<?php echo $count_posts->publish; ?>"/>
                <button class="load_more_post comm-btn" id="load_more_post">Load More</button>
           
        </div>

    </div>

</section>

<!--blog-section-->



<?php 

    include_once FL_USER_FOOTER_INCLUDE;

    $common->include_footer( '' );

?>


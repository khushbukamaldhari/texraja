<?php
$admin = new admin();
class admin{
    
     function get_blog_data(){
        require_once FL_BLOG_HEADER;
        $i = 0;
        $wpb_all_query = new WP_Query( array( 'post_type' => 'post',
                                              'post_status' => 'publish'));
        if ( $wpb_all_query->have_posts()) :
            while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
                $post_id = get_the_ID();
                $category = get_the_category( $post_id);
                $this->result['data'][$i]['post_id'] = get_the_ID();
                $this->result['data'][$i]['title'] = get_the_title( $post_id );
                $this->result['data'][$i]['contents'] = addslashes( get_post_field( 'post_content', $post_id ));
                $this->result['data'][$i]['categories'] = $category[0]->name;
                $i++;
            endwhile;
        endif;
        return ( json_encode( $this->result ) );
    }
    
}


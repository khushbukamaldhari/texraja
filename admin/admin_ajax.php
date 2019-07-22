<?php
require_once '../config/config.php';
require_once '../admin/config/admin_config.php';

$ajax = new admin_ajax();
if( isset( $_POST['action']) && trim( $_POST['action'] ) !== '' ) {
    switch ( $_POST['action'] ) {
        case 'add_update_blog' :
            $ajax->add_update_blog( $_POST, $_FILES );
            break;
        case 'get_data_by_post_id' :
            $ajax->get_data_by_post_id( $_POST );
            break;
         case 'delete_data_by_post_id' :
            $ajax->delete_data_by_post_id( $_POST );
            break;
         case 'get_all_product' :
            $ajax->get_all_product( $_POST );
            break;
         case 'update_product' :
            $ajax->update_product( $_POST );
            break;
         case 'list_users_paged' :
            $ajax->list_users_paged( $_POST );
            break;
         case 'list_attr_paged' :
            $ajax->list_attr_paged( $_POST );
            break;
         case 'change_user_status' :
            $ajax->change_user_status( $_POST );
            break;
        case 'add_attribute' :
            $ajax->add_attribute( $_POST );
            break;
        case 'edit_attribute' :
            $ajax->edit_attribute( $_POST );
            break;
        case 'get_attribute_by_id' :
            $ajax->get_attribute_by_id( $_POST );
            break;
        case 'delete_attribute' :
            $ajax->delete_attribute( $_POST );
            break;
        case 'add_product' :
            $ajax->add_product( $_POST );
            break;
        case 'edit_product' :
            $ajax->edit_product( $_POST );
            break;
        case 'get_product_by_id' :
            $ajax->get_product_by_id( $_POST );
            break;
        case 'delete_product' :
            $ajax->delete_product( $_POST );
            break;
    }
}

class admin_ajax {
    /**
     * WordPress Functions
     */
    
    function load_wp(){
        require_once FL_BLOG_HEADER;
        header( "HTTP/1.1 200 OK" );
    }
    
    /**
     * Core Functions
    */
    
    /* Add update blog */
    function add_update_blog( $data, $files ) {
        $this->load_wp();
        if( isset( $data['pid'] ) && $data['pid'] != 0 ){
            $my_post = array(   'post_title'      => wp_strip_all_tags( $data['txt_title'] ),
                                'post_content'    => $data['txt_description'],
                                'post_status'     => 'publish',
                                'post_author'     => 1,
                                'post_category'   => $data['txt_term'], 
                                'ID'              => $data['pid'] 
                            );
            $post_id = wp_update_post( $my_post );
        }else{
             $my_post = array( 'post_title'     => wp_strip_all_tags( $data['txt_title'] ),
                               'post_content'   => $data['txt_description'],
                               'post_status'    => 'publish',
                               'post_author'    => 1,
                               'post_category'  =>  $data['txt_term'] 
                            );
             $post_id = wp_insert_post( $my_post );
        }
        if( isset( $files['featured_image']['tmp_name'] ) && $files['featured_image']['tmp_name'] != '' ){
            $this->thumbnail_url_field_save( $files, $post_id );
        }
        if( $post_id != '' ) {
            $post_data   = get_post( $post_id );
            $this->result['success'] = TRUE;
            $this->result['message'] = '';
            $this->result['data'] = $post_data;
        }
        die( json_encode( $this->result ));
    }
    
    /**
     * 
     * @param type $data
     */
    function get_data_by_post_id( $data ){
        $this->load_wp();
        $categories     = array();
        $wpb_all_query  = new WP_Query( array(  'post_type'   => 'post',
                                                'p'           => $data['pid'],
                                                'post_status' => 'publish' ));
        if( $wpb_all_query->have_posts() ) :
            while( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
              
                $post_id  = $data['pid'];
                $arr_data = array();
                $category = get_the_category( $post_id );
                $img_url  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
                foreach( $category as $cat_k => $cat_v ){
                    $categories[] = $cat_v->term_id;
                }
                $arr_data['data']['post_id']        = get_the_ID();
                $arr_data['data']['title']          = get_the_title( $post_id );
                $arr_data['data']['contents']       = addslashes( get_post_field( 'post_content', $post_id ));
                $arr_data['data']['categories']     = $categories;
                $arr_data['data']['featured_image'] = addslashes( $img_url[0] );
            endwhile;
        endif;
        die( json_encode( $arr_data ) );
    }
    
    /**
     * 
     * @param type $data
     */
    function delete_data_by_post_id( $data ){
        $this->load_wp();
        if( $data['pid'] != '' ){
            // Delete all products.
            wp_delete_post( $data['pid']); // Set to False if you want to send them to Trash.
        } 
        if ( $post_id != '' ) {
            $this->result['success'] = TRUE;
            $this->result['message'] = '';
            $this->result['data'] = '';
        }
        die ( json_encode( $arr_data ) );
    }
    
    /* Set Featured image */
    function thumbnail_url_field_save( $files, $post_id ) {
        // Add Featured Image to Post
        $this->load_wp();
        $image_url = $files['featured_image']['tmp_name']; // Define the image URL here
        $image_name = $files['featured_image']['name'];
        $upload_dir = wp_upload_dir(); // Set upload folder
        $image_data = file_get_contents($image_url); // Get image data
        $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name); // Generate unique name
        $filename = basename($unique_file_name); // Create image file name
        // Check folder permission and define file location
        if ( wp_mkdir_p( $upload_dir['path'] ) ) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }

        // Create the image  file on the server
        file_put_contents($file, $image_data );

        // Check image file type
        $wp_filetype = wp_check_filetype( $filename, null );

        // Set attachment data
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        // Create the attachment
        $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

        // Include image.php
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);

        // Assign metadata to attachment
        wp_update_attachment_metadata($attach_id, $attach_data);

        // And finally assign featured image to post
        set_post_thumbnail($post_id, $attach_id);
    }
    
    
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    function update_product( $data ){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product_action = isset( $data['task'] ) && !empty( $data['task'] ) ? $data['task'] : '';
            if( !empty( $product_action ) ){
                if( $product_action == "create" ){
                    $response = $product->add_product( $data['data'][0] );
                } else if( $product_action == "edit" ){
                    $response = $product->update_product( $data );
                }else if( $product_action == "remove" ){
                    $response = $product->remove_product( $data );
                }
            
            }
            if ( $response > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
               $product_data = $product->get_product_by_id( $response );
//                $response[$res_k]['attributes'] = $product->get_attributes_by_product_id( $res_v['in_product_id'] );
//                $response[$res_k]['properties'] = $product->get_properties_by_product_id( $res_v['in_product_id'] );
                $pro_data[] = array(
                    "DT_RowId" =>  "product_" . $product_data['in_product_id'],
                    'in_product_id' => $product_data['in_product_id'],
                    'st_product_name' => $product_data['st_product_name'],
                    'st_product_desc' => $product_data['st_product_desc'],
                    'st_category_name' => $product_data['st_product_name'],
                    'st_machinary_name' => $product_data['st_product_name'],
                );
                

                $this->result['success_flag'] = true;
                $this->result['data'] = $pro_data;
                $this->result['message'] = "";
                $this->result['redirect'] = '';
            } else if ( $response == -2 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Phone no already exists";
            } else {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    /**
     * End User Registration
     * 
     * @global type $mydb
     * @param type $data
     */
    public function list_users_paged( $data ) {
        $json_data = array();
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();
            $common = new common();
            $user_param = $common->get_datatable_params( $data );
            $user_param['select'] = array(
                'in_user_id',
                'st_full_name',
                'st_email_id',
                'st_phone_no',
                'dt_created_at',
                'in_is_active',
            );
            $user_param['where'] = array(
                'st_user_type' => 'user',
                'in_is_deleted' => 0
            );
            
            $user_data = $user->get_users( $user_param );
            
            if( !empty( $user_data ) ){
                foreach ( $user_data as $udk => $udv ){
                    if( isset( $udv['in_is_active'] ) && $udv['in_is_active'] == "0" ){
                        $user_data[$udk]['action'] = '<button class="btn btn-success btn-approve">Approve</button>'
                            . '<button class="btn btn-danger btn-reject">Reject</button>';
                    } else if( isset( $udv['in_is_active'] ) && $udv['in_is_active'] == "1" ){
                        $user_data[$udk]['action'] = '<button class="btn btn-success">Approved</button>';
                    } else if( isset( $udv['in_is_active'] ) && $udv['in_is_active'] == "-1" ){
                        $user_data[$udk]['action'] = '<button class="btn btn-danger">Rejected</button>';
                    }
                }
                $json_data = array(
                    "draw" => ( isset( $data['draw'] ) && !empty( $data['draw'] ) ? $data['draw'] : 2 ),
                    "recordsTotal" => $user->get_user_count(  ),
                    "recordsFiltered" => $user->get_user_count(  ),
                    "data" => $user_data
                );
            }
            
        }
        
        die( json_encode( $json_data ) );
    }
    
    /**
     * 
     * @param type $data
     */
    function change_user_status( $data ){
        if ( !empty( $data ) && isset( $data['user'] ) && isset( $data['status'] ) ){
            include_once FL_USER;
            $user = new user();
            $update_id = $user->change_user_status( $data['user'], $data['status'] );
            
            if ( $update_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['message'] = "Thank you..!";
            } else {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
        }
        die( json_encode( $this->result ) );
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    function get_all_product( $data ){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();
            include_once FL_PRODUCT;
            $product = new product();
            $common = new common();
            $user_param = $common->get_datatable_params( $data );
            $user_param['select'] = array(
                'in_product_id',
                'st_product_name',
                'st_product_desc',
                'in_is_active',
            );
            $user_param['where'] = array(
                'in_is_active' => 1,
                'in_is_deleted' => 0
            );
            

            $response = $product->get_product_list( $user_param );
            if ( $response > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                foreach( $response as $res_k => $res_v ){
                    $response[$res_k]['action'] = "<span class='edit_product' data-edit_product='" . $res_v['in_product_id'] . "'><i class='fa fa-edit btn btn-primary'></i></span>" .
                                                            "<span class='delete_product' data-delete_product='" . $res_v['in_product_id'] . "'><i class='fa fa-times btn btn-danger'></i></span>";
                    $response[$res_k]['attributes'] = $product->get_attributes_by_product_id( $res_v['in_product_id'] );
                    $product_category = $product->get_category_by_product_id( $res_v['in_product_id'] );
                    $pc_name = '';
                    if( isset( $product_category ) && $product_category != "" ){
                        
                        $i = 0;
                        $pc_count = count( $product_category );
                        foreach( $product_category as $pck => $pcv ){
                            $i++;
                            if( $pc_count == $i ){
                                $pc_name .= $pcv['st_attr_name'] . ' ';
                            }else{
                                $pc_name .= $pcv['st_attr_name'] . ', ';
                            }
                        }
                    }
                    $response[$res_k]['properties'] = $product->get_properties_by_product_id( $res_v['in_product_id'] );
                    $product_machinary = $product->get_machinary_by_product_id( $res_v['in_product_id'] );
                    $pm_name = '';
                    if( isset( $product_machinary ) && $product_machinary != "" ){
                        
                        $i = 0;
                        $pc_count = count( $product_machinary );
                        foreach( $product_machinary as $pck => $pcv ){
                            $i++;
                            if( $pc_count == $i ){
                                $pm_name .= $pcv['st_attr_name'] . ' ';
                            }else{
                                $pm_name .= $pcv['st_attr_name'] . ', ';
                            }
                        }
                    }
                    $response[$res_k]['st_category_name'] = $pc_name;
                    $response[$res_k]['st_machinary_name'] = $pm_name;
                }
                $json_data = array(
                    "draw" => ( isset( $data['draw'] ) && !empty( $data['draw'] ) ? $data['draw'] : 2 ),
                    "recordsTotal" => $product->get_product_count(  ),
                    "recordsFiltered" => $product->get_product_count(  ),
                    "data" => $response
                );
            }
            die( json_encode( $json_data ) );
        }
    }
    
    /**
     * Attribute list
     * 
     * @global type $mydb
     * @param type $data
     */
    public function list_attr_paged( $data ) {
        $json_data = array();
        
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();
            include_once FL_PRODUCT;
            $product = new product();
            $common = new common();
            $user_param = $common->get_datatable_params( $data );
            $user_param['select'] = array(
                'in_attr_id',
                'st_attr_name',
                'st_attr_type',
                'in_is_active',
            );
            $user_param['where'] = array(
                'in_is_active' => 1,
                'in_is_deleted' => 0
            );
            
            $product_attribute = $product->get_attributes( $user_param );
            if( !empty( $product_attribute ) ){
                foreach ( $product_attribute as $udk => $udv ){
                     $product_attribute[$udk]['action'] = "<span class='edit_attr' data-edit_attr='" . $udv['in_attr_id'] . "'><i class='fa fa-edit btn btn-primary'></i></span>" .
                                                    "<span class='delete_attr' data-delete_attr='" . $udv['in_attr_id'] . "'><i class='fa fa-times btn btn-danger'></i></span>";
                }
                $json_data = array(
                    "draw" => ( isset( $data['draw'] ) && !empty( $data['draw'] ) ? $data['draw'] : 2 ),
                    "recordsTotal" => $product->get_attr_count(  ),
                    "recordsFiltered" => $product->get_attr_count(  ),
                    "data" => $product_attribute
                );
            }
            
        }
        
        die( json_encode( $json_data ) );
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function add_attribute( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
           
            $insert_id = $product->add_attribute( $data );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Attribute has been added successfully.";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Attribute not added";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function edit_attribute( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
           
            $update_id = $product->edit_attribute( $data );
            if ( $update_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $data['hdn_attr_id'];
                $this->result['message'] = "Attribute has been updated successfully.";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Attribute not Updated";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function get_attribute_by_id( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $attr_id = isset( $data['attr_id'] ) && $data['attr_id'] != '' ?  $data['attr_id'] : '';
            $attr_data = $product->get_attribute_by_id( $attr_id );
            echo ( json_encode( $attr_data ) );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function delete_attribute($data) {
        if ( isset( $data) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            
            if ( $data['attr_id'] > 0 ) {
                $update_id = $product->delete_attribute( $data );

                if ( $update_id > 0 ) {
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $update_id;
                    $this->result['message'] = "Attribute Delete Successfully";
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "Attribute not delete ";
                }
            }
            echo ( json_encode($this->result));
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function add_product( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
           
            $insert_id = $product->add_product( $data );
            if ( $insert_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "Product has been added successfully.";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Product not added";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function edit_product( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
           
            $update_id = $product->update_product( $data );
            if ( $update_id > 0 ) {
                $this->result['success_flag'] = true;
                $this->result['data'] = $data['hdn_product_id'];
                $this->result['message'] = "Product has been updated successfully.";
            }else{
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Product not Updated";
            }
            die( json_encode( $this->result ) );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function get_product_by_id( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product_id = isset( $data['product_id'] ) && $data['product_id'] != '' ?  $data['product_id'] : '';
            $product_data = $product->get_product_by_id( $product_id );
            if( isset( $product_data ) && $product_data > 0 ){
                $product_category = $product->get_category_by_product_id( $product_id );
                $pc_name = '';
                if( isset( $product_category ) && $product_category != "" ){

                    $i = 0;
                    $pc_count = count( $product_category );
                    foreach( $product_category as $pck => $pcv ){
                        $i++;
                        if( $pc_count == $i ){
                            $pc_name .= $pcv['st_attr_name'] . ' ';
                        }else{
                            $pc_name .= $pcv['st_attr_name'] . ', ';
                        }
                    }
                }
                $product_machinary = $product->get_machinary_by_product_id( $product_id );
                $pm_name = '';
                if( isset( $product_machinary ) && $product_machinary != "" ){

                    $i = 0;
                    $pc_count = count( $product_machinary );
                    foreach( $product_machinary as $pck => $pcv ){
                        $i++;
                        if( $pc_count == $i ){
                            $pm_name .= $pcv['st_attr_name'] . ' ';
                        }else{
                            $pm_name .= $pcv['st_attr_name'] . ', ';
                        }
                    }
                }
            }
            $product_data['st_category_name'] = $pc_name;
            $product_data['st_machinary_name'] = $pm_name;
        
            echo ( json_encode( $product_data ) );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function delete_product( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            
            if ( $data['product_id'] > 0 ) {
                $update_id = $product->delete_product( $data );

                if ( $update_id > 0 ) {
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $update_id;
                    $this->result['message'] = "Product Delete Successfully";
                } else {
                    $this->result['success_flag'] = false;
                    $this->result['message'] = "Product not delete ";
                }
            }
            echo ( json_encode( $this->result ) );
        }
    }
    
}


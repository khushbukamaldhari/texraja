<?php
$product = new product();

class product {

    public $flag_err = FALSE;
   
    function __construct() {
        $this->flag_err = FALSE;
        $this->active = ' in_is_active = 1 ';
    }
    
    /**
     * 
     * @global type $mydb
     * @return int
     */
    function get_product(){
        global $mydb;
        $arr_where = array(
                        'in_is_active' => 1,
                        'in_is_deleted' => 0
                    );
        $response = $mydb->get_all( TBL_PRODUCT, '*', $arr_where );
        if( isset( $response ) && $response != "" ){
            
            return $response;
        }else{
            return 0;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return int
     */
    function get_product_by_id( $product_id ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                            'in_product_id' => $product_id,
                            'in_is_active' => 1,
                            'in_is_deleted' => 0
                        );
            $response = $mydb->get_row( TBL_PRODUCT, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @return int
     */
    function get_user_product( $user_id = 0 ){
        global $mydb;
        $arr_where = array(
                        'in_user_id' => $user_id,
                        'in_is_active' => 1,
                        'in_is_deleted' => 0
                    );
        $response = $mydb->get_all( TBL_USER_PRODUCT, '*', $arr_where );
        if( isset( $response ) && $response != "" ){
            
            foreach( $response as $res_k => $res_v ){
                $response[$res_k]['attributes'] = $this->get_attributes_by_user_product_id( $res_v['in_user_product_id'] );
                $response[$res_k]['properties'] = $this->get_properties_by_user_product_id( $res_v['in_user_product_id'] );
            }
            return $response;
        } else{
            return 0;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return int
     */
    function get_attributes_by_product_id( $product_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_product_id' => $product_id
            );
            $response = $mydb->get_all( TBL_PRODUCT_ATTRIBUTE, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return int
     */
    function get_properties_by_product_id( $product_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_product_id' => $product_id
            );
            $response = $mydb->get_all( TBL_PRODUCT_PROPERTIES, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return int
     */
    function get_attributes_by_user_product_id( $product_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_user_product_id' => $product_id
            );
            $response = $mydb->get_all( TBL_USER_PRODUCT_ATTRIBUTE, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return int
     */
    function get_properties_by_user_product_id( $product_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_user_product_id' => $product_id
            );
            $response = $mydb->get_all( TBL_USER_PRODUCT_PROPERTIES, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return array|int
     */
    function get_category_by_product_id( $product_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                        'in_product_id' => $product_id
                    );
            $response_category = array();
            $response = $mydb->get_all( TBL_PRODUCT_ATTRIBUTE, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                if( isset( $response['in_product_id'] ) ){
                    $response  = array( $response );
                }
                foreach( $response as $rk => $rv ){
                    $arr_where_cat = array(
                            'in_attr_id' => $rv['in_attr_id'],
                            'st_attr_type' => "category"
                        );
                    $response_cat = $mydb->get_row( TBL_ATTRIBUTES, '*', $arr_where_cat );
                    if( isset( $response_cat ) && $response_cat != "" ){
                        array_push( $response_category, $response_cat );
                    }
                }
                return $response_category;
            }else{
                return 0;
            }
        }
    }
    
    
    function get_attribute_by_type( $product_type = "" ){
        global $mydb;
        if( isset( $product_type ) && $product_type != "" ){
            $arr_where = array(
                    'st_attr_type' => $product_type,
                    'in_is_active' => 1
                );
        }else{
            $arr_where = array(
                    'in_is_active' => 1
                );
        }
        $response = $mydb->get_all( TBL_ATTRIBUTES, '*', $arr_where );
        if( isset( $response ) && $response != "" ){
            if( isset( $response['in_attr_id'] ) ){
                $response = array( $response );
            } 
            return $response;
        }else{
            return 0;
        }
    }
    
    function get_attribute_by_id( $attr_id = 0 ){
        global $mydb;
        if( isset( $attr_id ) && $attr_id != "" ){
            $arr_where = array(
                    'in_attr_id' => $attr_id,
                    'in_is_active' => 1
                );
            $response = $mydb->get_row( TBL_ATTRIBUTES, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                return $response;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * Get attribute by criteria
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    function get_attributes( $data = array() ){
        global $mydb;
        
        $select = array(
            'in_attr_id',
            'st_attr_name',
            'st_attr_type',
            'in_is_active',
        );
        
        $where = array(
            'in_is_active' => 1,
            'in_is_deleted' => 0
        );
        
        $offset = 0;
        $limit = 10;
        $order_by = 'in_attr_id DESC';
        
        if( empty( $data ) ){
            $response = $mydb->get_all( TBL_ATTRIBUTES, $select );
            return $response;
        }
        
        if( isset( $data['select'] ) && !empty( $data['select'] ) ){
            $select = $data['select'];
        }
        
        if( isset( $data['where'] ) && !empty( $data['where'] ) ){
            $where = $data['where'];
        }
        
        if( isset( $data['order_by'] ) && !empty( $data['order_by'] ) ){
            $order_by = $data['order_by'];
        }
        
        if( isset( $data['offset'] ) && !empty( $data['offset'] ) ){
            $offset = $data['offset'];
        }
        
        if( isset( $data['limit'] ) && !empty( $data['limit'] ) ){
            $limit = $data['limit'];
        }
        $response = $mydb->get_all( TBL_ATTRIBUTES, $select, $where, $order_by, $offset, $limit );
        return $response;
    }
    
    /**
     * Get total number of users by criteria
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    function get_attr_count( $data = array() ){
        global $mydb;
        
        $select = "COUNT( in_attr_id )";
        
        $where = array(
            'in_is_active' => 1,
            'in_is_deleted' => 0
        );
        
        if( isset( $data['where'] ) && !empty( $data['where'] ) ){
            $where = $data['where'];
        }
        
        $response = $mydb->get_var( TBL_ATTRIBUTES, $select, $where );
        return $response;
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return array|int
     */
    function get_machinary_by_product_id( $product_id = 0 ){
        
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                        'in_product_id' => $product_id
                    );
            $response_machinary = array();
            $response = $mydb->get_all( TBL_PRODUCT_ATTRIBUTE, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                if( isset( $response['in_product_id'] ) ){
                    $response  = array( $response );
                }
                foreach( $response as $rk => $rv ){
                    $arr_where_cat = array(
                            'in_attr_id' => $rv['in_attr_id'],
                            'st_attr_type' => "machinary"
                        );
                    $response_mac = $mydb->get_row( TBL_ATTRIBUTES, '*', $arr_where_cat );
                    if( isset( $response_mac ) && $response_mac != "" ){
                        array_push( $response_machinary, $response_mac );
                    }
                }
                return $response_machinary;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return array|int
     */
    function get_category_by_user_product_id( $product_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_user_product_id' => $product_id,
                'in_is_deleted' => 1
            );
            $response_category = array();
            $response = $mydb->get_all( TBL_USER_PRODUCT_ATTRIBUTE, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                if( isset( $response['in_user_product_id'] ) ){
                    $response  = array( $response );
                }
                foreach( $response as $rk => $rv ){
                    $arr_where_cat = array(
                            'in_attr_id' => $rv['in_attr_id'],
                            'st_attr_type' => "category"
                        );
                    $response_cat = $mydb->get_row( TBL_ATTRIBUTES, '*', $arr_where_cat );
                    if( isset( $response_cat ) && $response_cat != "" ){
                        array_push( $response_category, $response_cat );
                    }
                }
                return $response_category;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $product_id
     * @return array|int
     */
    function get_machinary_by_user_product_id( $product_id = 0 ){
        
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_user_product_id' => $product_id,
                'in_is_deleted' => 1
            );
            $response_machinary = array();
            $response = $mydb->get_all( TBL_USER_PRODUCT_ATTRIBUTE, '*', $arr_where );
            if( isset( $response ) && $response != "" ){
                if( isset( $response['in_user_product_id'] ) ){
                    $response  = array( $response );
                }
                foreach( $response as $rk => $rv ){
                    $arr_where_cat = array(
                            'in_attr_id' => $rv['in_attr_id'],
                            'st_attr_type' => "machinary"
                        );
                    $response_mac = $mydb->get_row( TBL_ATTRIBUTES, '*', $arr_where_cat );
                    if( isset( $response_mac ) && $response_mac != "" ){
                        array_push( $response_machinary, $response_mac );
                    }
                }
                return $response_machinary;
            }else{
                return 0;
            }
        }
    }
    
    /**
     * update product
     * @param type $data
     */
    function update_product( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $product_id = isset( $data['hdn_product_id'] ) && !empty( $data['hdn_product_id'] ) ? $data['hdn_product_id'] : 0 ;
            $st_product_name = isset( $data['txt_product_name'] ) && !empty( $data['txt_product_name'] ) ? $data['txt_product_name'] : 0 ;
            $st_product_desc = isset( $data['txt_product_desc'] ) && !empty( $data['txt_product_desc'] ) ? $data['txt_product_desc'] : 0 ;
            $dp_category = isset( $data['dp_category'] ) && !empty( $data['dp_category'] ) ? $data['dp_category'] : 0 ;
            $dp_machinary = isset( $data['dp_machinary'] ) && !empty( $data['dp_machinary'] ) ? $data['dp_machinary'] : 0 ;
            
            $arr_data = array(
                'st_product_name' => $st_product_name,
                'st_product_desc' => $st_product_desc
            );
            $arr_where = array(
                'in_product_id' => $product_id
            );
            if ( $st_product_name != "" ) {
                $update_id = $mydb->update( TBL_PRODUCT, $arr_data, $arr_where );
                $this->add_product_attribute( $product_id, $dp_category );
                $this->add_product_attribute( $product_id, $dp_machinary );
                if ( $update_id > 0 ) {
                    return $update_id;
                }else{
                    return 0;
                }
            }
        }
    }
    
    /**
     * Add Product
     * @param type $data
     */
    function add_product_attribute( $product_id = 0, $attr_id = 0 ){
        if( isset( $product_id ) && $product_id > 0 ){
            global $mydb;
            
            $arr_data = array(
                'in_product_id' => $product_id,
                'in_attr_id' => $attr_id
            );
            if ( $product_id != "" ) {
                $insert_id = $mydb->insert( TBL_PRODUCT_ATTRIBUTE, $arr_data );
                if ( $insert_id > 0 ) {
                    return $insert_id;
                }else{
                    return 0;
                }
            }
        }
    }
    /**
     * Add Product
     * @param type $data
     */
    function add_product( $data ){
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $st_product_name = isset( $data['txt_product_name'] ) && !empty( $data['txt_product_name'] ) ? $data['txt_product_name'] : 0 ;
            $st_product_desc = isset( $data['txt_product_desc'] ) && !empty( $data['txt_product_desc'] ) ? $data['txt_product_desc'] : 0 ;
            $dp_category = isset( $data['dp_category'] ) && !empty( $data['dp_category'] ) ? $data['dp_category'] : 0 ;
            $dp_machinary = isset( $data['dp_machinary'] ) && !empty( $data['dp_machinary'] ) ? $data['dp_machinary'] : 0 ;
            
            $arr_data = array(
                'st_product_name' => $st_product_name,
                'st_product_desc' => $st_product_desc
            );
            if ( $st_product_name != "" ) {
                $insert_id = $mydb->insert( TBL_PRODUCT, $arr_data );
                
                if ( $insert_id > 0 ) {
                    $this->add_product_attribute( $insert_id, $dp_category );
                    $this->add_product_attribute( $insert_id, $dp_machinary );
                    return $insert_id;
                }else{
                    return 0;
                }
            }
        }
    }
    
    /**
     * Delete attribute
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function delete_product( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $product_id = isset( $data['product_id'] ) && $data['product_id'] > 0 ? $data['product_id'] : 0 ;
            $arr_where = array(
                'in_product_id' => $product_id
            );
            $arr_set = array(
                'in_is_active' => 0
            );
            if ( $data['product_id'] != "" ) {
                $update_id = $mydb->update( TBL_PRODUCT, $arr_set, $arr_where );
                if ( $update_id > 0 ) {
                    return $update_id;
                }else{
                    return 0;
                }
            }
        }
    }
    
    function edit_products_by_key( $product_id = 0, $product_key = '', $product_value = '', $product_type = '' ){
        if ( $product_id > 0 && trim( $product_key ) != '') {
            global $mydb;
            $update = FALSE;
            
            if( $product_type == "product" ){
                if( $product_key == "st_category" || $product_key == "st_machinary" ){
                    $arr_where = array(
                        'in_user_product_id' => $product_id
                    );
                    if(  $product_key == "st_category" ){
                        $attr_type = 'category';
                    }else{
                        $attr_type = 'machinary';
                    }
                    $str_query = "SELECT * FROM " . $mydb->prefix . TBL_USER_PRODUCT_ATTRIBUTE . " pa, " . $mydb->prefix . TBL_ATTRIBUTES . 
                            " a WHERE in_user_product_id = " . $product_id . " AND pa.in_attr_id = a.in_attr_id AND a.st_attr_type = '" . $attr_type . "'";
                    $response = $mydb->query( $str_query );
                    $attr_ids = array();
                    if( isset( $response ) && $response > 0 ){
                        foreach( $response as $rk => $rv ){
                            $arr_where = array(
                                'in_user_product_id' => $product_id,
                                'in_attr_id' => $rv['in_attr_id']
                            );
                            $arr_data = array(
                                'in_is_deleted' => 0
                            );
                            $update_id = $mydb->update( TBL_USER_PRODUCT_ATTRIBUTE, $arr_data, $arr_where );
                            array_push( $attr_ids, $rv['in_attr_id'] );
                        }
                    }
                    if( isset( $product_value ) && is_array( $product_value ) ){
                        foreach( $product_value as $pk => $pv ){
                            if( in_array( $pv, $attr_ids ) ){
                                    $arr_data = array(
                                        'in_is_deleted' => 1
                                    );
                                $arr_where = array(
                                    'in_user_product_id' => $product_id,
                                    'in_attr_id' => $pv
                                );
                                $update_id = $mydb->update( TBL_USER_PRODUCT_ATTRIBUTE, $arr_data, $arr_where );
                            } else{
                                $arr_data = array(
                                    'in_user_product_id' => $product_id,
                                    'in_attr_id' => $pv,
                                    'in_is_deleted' => 1
                                );
                                $update_id = $mydb->insert( TBL_USER_PRODUCT_ATTRIBUTE, $arr_data );
                            }
                        }
                    }
                }else{
                    $arr_data = array(
                        $product_key => $product_value
                    );
                    $where = array(
                        'in_user_product_id' => $product_id
                    );
                    $update_id = $mydb->update( TBL_USER_PRODUCT, $arr_data, $where );
                }
            } else{
                $arr_data = array(
                    'st_properties_value' => $product_value
                );
                $where = array(
                    'in_user_product_id' => $product_id,
                    'st_properties_key' => $product_key
                );
                $update_id = $mydb->update( TBL_USER_PRODUCT_PROPERTIES, $arr_data, $where );
            }
            if ( $update_id != 0 && $update_id > 0 ) {
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
    
    function get_products_by_keyword( $product_id ){
        if( isset( $product_id ) && !empty( $product_id ) ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : 0;
            $str_query = "SELECT * FROM " . $mydb->prefix . TBL_PRODUCT . 
                         " WHERE st_product_name LIKE '%" . $product_id . "%'" ;
            $response = $mydb->query( $str_query );
            if( isset( $response ) && $response > 0 ){
                if( isset( $response['in_product_id'] ) ){
                    $response  = array( $response );
                }
                foreach( $response as $res_k => $res_v ){
                    $product_category = $this->get_category_by_user_product_id( $res_v['in_product_id'] );
                    $pc_name = '';
                    if( isset( $product_category ) && $product_category != "" ){
                        if( isset( $product_category['in_attr_id'] ) ){
                            $product_category = array( $product_category );
                        }
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
                    $response[$res_k]['category'] = $pc_name;
                    
                    $product_machinary = $this->get_machinary_by_user_product_id( $res_v['in_product_id'] );
                    $pm_name = '';
                    if( isset( $product_machinary ) && $product_machinary != "" ){
                        if( isset( $product_machinary['in_attr_id'] ) ){
                            $product_machinary = array( $product_machinary );
                        }
                        $i = 0;
                        $pm_count = count( $product_machinary );
                        foreach( $product_machinary as $pck => $pcv ){
                            $i++;
                            if( $pm_count == $i ){
                                $pm_name .= $pcv['st_attr_name'] . ' ';
                            }else{
                                $pm_name .= $pcv['st_attr_name'] . ', ';
                            }

                        }
                    }
                    $response[$res_k]['machinary'] = $pm_name;
                    
                    $response[$res_k]['properties'] = $this->get_properties_by_product_id( $res_v['in_product_id'] );
                }
             }
            return $response;
        } else{
            return 0;
        }
    }
    
    function add_user_product( $product_id ){
        if( isset( $product_id ) && !empty( $product_id ) ){
            global $mydb;
            if ( !session_id() ) {
                session_start();
            }
            $user_id = isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 ? $_SESSION['user_id'] : 0;
            
            $product_data = $this->get_product_by_id( $product_id );
            if( isset( $product_data ) && $product_data > 0 ){
                $arr_product = array(
                    'in_product_id' => $product_id,
                    'in_user_id' => $user_id,
                    'st_product_name' => $product_data['st_product_name'],
                    'st_product_desc' => $product_data['st_product_desc'],
                );
                $response = $mydb->insert( TBL_USER_PRODUCT, $arr_product );
                if( isset( $response ) && $response > 0 ){
                    $product_attribute = $this->get_attributes_by_product_id( $product_id );
                    if( isset( $product_attribute ) && $product_attribute > 0 ){
                        foreach( $product_attribute as $pak => $pav ){
                            $arr_attribute = array(
                                'in_user_product_id' => $response,
                                'in_attr_id' => $pav['in_attr_id']
                            );
                            $response_attr = $mydb->insert( TBL_USER_PRODUCT_ATTRIBUTE, $arr_attribute );
                        }
                    }
                    $product_properties = $this->get_properties_by_product_id( $product_id );
                    if( isset( $product_properties ) && $product_properties > 0 ){
                        $arr_pro = array();
                        foreach( $product_properties as $pak => $pav ){
                            $arr_properties = array(
                                'in_user_product_id' => $response,
                                'st_properties_key' => $pav['st_properties_key'],
                                'st_properties_value' => $pav['st_properties_value']
                            );
                            $response_attr = $mydb->insert( TBL_USER_PRODUCT_PROPERTIES, $arr_properties );
                            $arr_pro[$pav['st_properties_key']] = array(    'key' => $pav['st_properties_key'],
                                                                            'value' => $pav['st_properties_value']
                                                                        );
                        }
                    }
                    
                 }
                 $arr_pro['id'] = $response;
                 return $arr_pro;
            } else{
                return 0;
            }
        }
    }
    
    /**
     * Add attribute
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function add_attribute( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $txt_attr_name = isset( $data['txt_attr_name'] ) && !empty( $data['txt_attr_name']) ? $data['txt_attr_name'] : 0 ;
            $txt_attr_desc = isset( $data['txt_attr_desc'] ) && !empty( $data['txt_attr_desc'] ) ? $data['txt_attr_desc'] : 0 ;
            $attr_type = isset( $data['attr_type'] ) && !empty( $data['attr_type'] ) ? $data['attr_type'] : 0 ;
            
            $arr_data = array(
                'st_attr_name' => $txt_attr_name,
                'st_attr_description' => $txt_attr_desc,
                'st_attr_type' => $attr_type,
            );
            if ( $txt_attr_name != "" ) {
                $insert_id = $mydb->insert( TBL_ATTRIBUTES, $arr_data );

                if ( $insert_id > 0 ) {
                    return $insert_id;
                }else{
                    return 0;
                }
            }
        }
    }
    /**
     * Add attribute
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function add_user_attribute( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $in_attr_id = isset( $data['cat_id'] ) && !empty( $data['cat_id']) ? $data['cat_id'] : 0 ;
            $in_product_id = isset( $data['product_id'] ) && !empty( $data['product_id']) ? $data['product_id'] : 0 ;
            
            $arr_data = array(
                'in_attr_id' => $in_attr_id,
                'in_user_product_id' => $in_product_id,
            );
            if ( $in_attr_id != "" ) {
                $insert_id = $mydb->insert( TBL_USER_PRODUCT_ATTRIBUTE, $arr_data );

                if ( $insert_id > 0 ) {
                    return $insert_id;
                }else{
                    return 0;
                }
            }
        }
    }
    
    /**
     * Edit attribute
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function edit_attribute( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $attr_id = isset( $data['hdn_attr_id'] ) && $data['hdn_attr_id'] > 0 ? $data['hdn_attr_id'] : 0 ;
            $txt_attr_name = isset( $data['txt_attr_name'] ) && !empty( $data['txt_attr_name'] ) > 0 ? $data['txt_attr_name'] : 0 ;
            $txt_attr_desc = isset( $data['txt_attr_desc'] ) && !empty( $data['txt_attr_desc'] ) > 0 ? $data['txt_attr_desc'] : 0 ;
            $attr_type = isset( $data['attr_type'] ) && !empty( $data['attr_type'] ) ? $data['attr_type'] : 0 ;
            $arr_set = array(
                'in_attr_id' => $attr_id
            );
            $arr_data = array(
                'st_attr_name' => $txt_attr_name,
                'st_attr_description' => $txt_attr_desc,
                'st_attr_type' => $attr_type,
            );
            if ( $attr_id > 0  ) {
                $update_id = $mydb->update( TBL_ATTRIBUTES, $arr_data, $arr_set );
                if ( $update_id > 0 ) {
                    return $update_id;
                }else{
                    return 0;
                }
            }
        }
    }
    
    /**
     * Delete attribute
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function delete_attribute( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $attr_id = isset( $data['attr_id'] ) && $data['attr_id'] > 0 ? $data['attr_id'] : 0 ;
            $arr_where = array(
                'in_attr_id' => $attr_id
            );
            $arr_set = array(
                'in_is_active' => 0
            );
            if ( $data['attr_id'] != "" ) {
                $update_id = $mydb->update( TBL_ATTRIBUTES, $arr_set, $arr_where );
                if ( $update_id > 0 ) {
                    return $update_id;
                }else{
                    return 0;
                }
            }
        }
    }
    
    /**
     * Get total number of product by criteria
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    function get_product_count( $data = array() ){
        global $mydb;
        
        $select = "COUNT( in_product_id )";
        
        $where = array(
            'in_is_active' => 1,
            'in_is_deleted' => 0
        );
        
        if( isset( $data['where'] ) && !empty( $data['where'] ) ){
            $where = $data['where'];
        }
        
        $response = $mydb->get_var( TBL_PRODUCT, $select, $where );
        return $response;
    }
    /**
     * Get attribute by criteria
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    function get_product_list( $data = array() ){
        global $mydb;
        
        $select = array(
            'in_product_id',
            'st_product_name',
            'st_product_desc',
            'in_is_active',
        );
        $where = array(
            'in_is_active' => 1,
            'in_is_deleted' => 0
        );
        
        $offset = 0;
        $limit = 10;
        $order_by = 'in_product_id DESC';
        
        if( empty( $data ) ){
            $response = $mydb->get_all( TBL_PRODUCT, $select );
            return $response;
        }
        
        if( isset( $data['select'] ) && !empty( $data['select'] ) ){
            $select = $data['select'];
        }
        
        if( isset( $data['where'] ) && !empty( $data['where'] ) ){
            $where = $data['where'];
        }
        
        if( isset( $data['order_by'] ) && !empty( $data['order_by'] ) ){
            $order_by = $data['order_by'];
        }
        
        if( isset( $data['offset'] ) && !empty( $data['offset'] ) ){
            $offset = $data['offset'];
        }
        
        if( isset( $data['limit'] ) && !empty( $data['limit'] ) ){
            $limit = $data['limit'];
        }
        $response = $mydb->get_all( TBL_PRODUCT, $select, $where, $order_by, $offset, $limit );
        return $response;
    }
    
    /**
     * Delete User attribute
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function delete_user_attribute( $data ) {
        if( isset( $data ) && is_array( $data ) ){
            global $mydb;
            $in_attr_id = isset( $data['cat_id'] ) && !empty( $data['cat_id']) ? $data['cat_id'] : 0 ;
            $in_product_id = isset( $data['product_id'] ) && !empty( $data['product_id']) ? $data['product_id'] : 0 ;
            
            $arr_data = array(
                'in_attr_id' => $in_attr_id,
                'in_user_product_id' => $in_product_id,
            );
            if ( $in_attr_id != "" ) {
                $query = "delete from " . $mydb->prefix.TBL_USER_PRODUCT_ATTRIBUTE . " where in_user_product_id = ".$in_product_id." and in_attr_id = ".$in_attr_id;
                $mydb->query($query);
            }
        }
    }
    
    
}
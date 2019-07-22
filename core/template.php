<?php

$template = new template();
class template {
    function __construct(){
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $tpl_type
     * @param type $tpl_user_type
     * @param type $tpl_key
     * @param type $single
     * @return type
     */
    function get_template( $tpl_type = '', $tpl_user_type = '', $tpl_key = '', $single = TRUE ){
        if( isset( $tpl_type ) && trim( $tpl_type ) !== '' ){
           
            global $mydb;
            $arr_where = array(
                'st_template_type' => trim( $tpl_type )
            );
            if( trim( $tpl_user_type ) !== '' ){
                $arr_where['st_user_type'] = trim( $tpl_user_type );
            }
            if( trim( $tpl_key ) !== '' ){
                $arr_where['st_template_key'] = trim( $tpl_key );
            }
         
            $response = $mydb->get_all( TBL_HTML_TEMPLATE, '*', $arr_where );
            if( $response != 0 && count( $response ) > 0 ) {
                
                if( !isset( $response['in_template_id'] ) ){
                    if( $single == TRUE ){
                        return $response[0];
                    } else {
                        return $response;                        
                    }
                } else {
                    if( $single == TRUE ){
                        return $response;
                    } else {
                        return array( $response );
                    }
                }
            }
        }
    }
    
    /**
     * 
     * @param type $tpl_type
     * @param type $tpl_user_type
     * @param type $tpl_key
     */
    function show_template( $tpl_type = '', $tpl_user_type = '', $tpl_key = '' ){
        if( isset( $tpl_type ) && trim( $tpl_type ) !== '' ){
            $tmp_template = $this->get_template( $tpl_type, $tpl_user_type, $tpl_key, TRUE );
            echo $tmp_template['st_template_value'];
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @return type
     */
    function get_all_template(){
        global $mydb;
        $where = array( 
            'in_is_active' => 1
        );
        $response = $mydb->get_all( TBL_HTML_TEMPLATE, '*' ,$where ,'in_template_id desc' );
        if( $response != 0 && count( $response ) > 0 ) {
            if( !isset( $response['in_template_id'] ) ){
                    return array( $response );
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $tpl_id
     * @return type
     */
    function get_template_by_id( $tpl_id = 0 ){
        if( isset( $tpl_id ) && $tpl_id > 0 ){
            global $mydb;
            $arr_where = array(
                'in_template_id' => $tpl_id 
            );
            $response = $mydb->get_all( TBL_HTML_TEMPLATE, '*', $arr_where );
            if( $response != 0 && count( $response ) > 0 ) {
                if( isset( $response['in_template_id'] ) ){
                    return  $response ;
                }
            }
        }
    }
}
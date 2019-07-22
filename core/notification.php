<?php

$notification = new notification();

class notification {
    function __construct(){
    }
    
    /**
     * 
     * @param type $user_id
     * @param type $template_data
     * @param type $body_data
     * @return type
     */
    function prepare_notify_message( $user_id = 0, $template_data = array(), $body_data = '' ){
        if( isset( $user_id ) && trim( $user_id ) !== '' && $user_id > 0 ){
            if( isset( $template_data ) ){
                if( isset( $template_data['st_template_value'] ) ){
                    $msg_tpl = $template_data['st_template_value'];
                } else {
                    $msg_tpl = $template_data;
                }
                $str_replaced = $this->prepare_body( $body_data, $msg_tpl );
                return $str_replaced;
            }
        }
    }
    
    /**
     * 
     * @param type $body_data
     * @param type $template
     * @return type
     */
    function prepare_body( $body_data, $template ){
        $arr_replace_from = array();
        $arr_replace_to = array();
        foreach ( $body_data as $bdk => $bdv ) {
            $arr_replace_from[] = '/\[' . $bdk . '\]/';
            $arr_replace_to[] = $bdv;
        }
        $str_replaced = preg_replace( $arr_replace_from, $arr_replace_to, $template );
        
        return $str_replaced;
    }
}
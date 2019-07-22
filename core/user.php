<?php
$user = new user();

class user {

    public $flag_err = FALSE;
   
    function __construct() {
        $this->flag_err = FALSE;
        $this->active = ' in_is_active = 1 ';
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function add_visitor( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            if ( !session_id() ) {
                session_start();
            }
            global $mydb;
            $session_id = session_id();
            include_once FL_SMS;
            $sms = new sms();
            $phone_no = ( isset( $data['phone_no'] ) && trim( $data['phone_no'] ) !== '' ) ? trim( $data['phone_no'] ) : '';
            $otp_rand = rand( 1000, 9999 );
            $arr_where = array(
                'st_phone_no' => $phone_no
            );
            $user_data = $mydb->get_row( TBL_USER, '*', $arr_where );
            $arr_visitor_where = array(
                'st_phone_no' => $phone_no,
                'in_session_id' => $session_id
            );
            $visitor_data = $mydb->get_row( TBL_VISITOR_USER, '*', $arr_visitor_where );
            if( isset( $user_data['in_user_id'] ) && $user_data['in_user_id'] != '' ){
                    return -2;
            }else if( isset( $visitor_data['in_visitor_id'] ) && $visitor_data['in_visitor_id'] != '' ){
                $arr_where = array(
                    'in_session_id' => $session_id,
                    'st_phone_no' => $phone_no
                );
                $arr_data = array(
                    'st_otp_no'  => $otp_rand,
                );
                $insert_id = $mydb->update( TBL_VISITOR_USER, $arr_data, $arr_where );

                if ( $insert_id !== '' && $insert_id > 0 ) {
                    if ( $this->flag_err == FALSE ) {
                        $boby = "Dear Customer, </br> OTP( One Time Password ) for your signup request is " . $otp_rand . " Please do not disclose this to anyone - " . SITE_NAME;
                        $sms->send_sms( $insert_id, $boby );
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
            }else{
                $arr_data = array(
                    'in_session_id' => $session_id,
                    'st_otp_no'  => $otp_rand,
                    'st_phone_no' => $phone_no
                );
                $insert_id = $mydb->insert( TBL_VISITOR_USER, $arr_data );

                if ( $insert_id !== '' && $insert_id > 0 ) {
                    if ( $this->flag_err == FALSE ) {
                        $boby = "Dear Customer, </br> OTP( One Time Password ) for your signup request is " . $otp_rand . " Please do not disclose this to anyone - " . SITE_NAME;
                        $sms->send_sms( $insert_id, $boby );
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
            }
        }
    }
    
    function signup_resend_otp( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            if ( !session_id() ) {
                session_start();
            }
            global $mydb;
            $session_id = session_id();
            include_once FL_SMS;
            $sms = new sms();
            $phone_no = ( isset( $data['phone_no'] ) && trim( $data['phone_no'] ) !== '' ) ? trim( $data['phone_no'] ) : '';
            $otp_rand = rand( 1000, 9999 );
            
            $arr_visitor_where = array(
                'st_phone_no' => $phone_no
            );
            $visitor_data = $mydb->get_all( TBL_VISITOR_USER, '*', $arr_visitor_where );
                    
            if( isset( $visitor_data['in_visitor_id'] ) && $visitor_data['in_visitor_id'] != '' ){
                $arr_data = array(
                    'st_otp_no'  => $otp_rand,
                );
                $arr_where = array(
                    'st_phone_no' => $phone_no
                );
                $insert_id = $mydb->update( TBL_VISITOR_USER, $arr_data, $arr_where );

                if ( $insert_id !== '' && $insert_id > 0 ) {
                    if ( $this->flag_err == FALSE ) {
                        $boby = "Dear Customer, </br> OTP( One Time Password ) for your signup request is " . $otp_rand . " Please do not disclose this to anyone - " . SITE_NAME;
                        $sms->send_sms( $insert_id, $boby );
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
            }else{
                
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * @return int
     */
    function add_user( $data ) {
        
        if ( isset( $data ) && is_array( $data ) ) {
            $txt_full_name = ( isset( $data['txt_full_name'] ) && trim( $data['txt_full_name'] ) !== '' ) ? trim( $data['txt_full_name'] ) : '';
            $txt_phone_no = ( isset( $data['txt_phone_no'] ) && trim( $data['txt_phone_no'] ) !== '' ) ? trim( $data['txt_phone_no'] ) : '';
            $dl_user_type = ( isset( $data['dl_user_type'] ) && trim( $data['dl_user_type'] ) !== '' ) ? trim( $data['dl_user_type'] ) : '';
            $txt_otp_no = ( isset( $data['txt_otp_no'] ) && trim( $data['txt_otp_no'] ) !== '' ) ? trim( $data['txt_otp_no'] ) : '';
            $txt_email = ( isset( $data['txt_email'] ) && trim( $data['txt_email'] ) !== '' ) ? trim( $data['txt_email'] ) : '';
            $txt_password = ( isset( $data['txt_password'] ) && trim( $data['txt_password'] ) !== '' ) ? trim( $data['txt_password'] ) : '';
            $txt_adhar_no = ( isset( $data['txt_adhar_no'] ) && trim( $data['txt_adhar_no'] ) !== '' ) ? trim( $data['txt_adhar_no'] ) : '';
            $txt_gst_no = ( isset( $data['txt_gst_no'] ) && trim( $data['txt_gst_no'] ) !== '' ) ? trim( $data['txt_gst_no'] ) : '';
            
            global $mydb;
            
            $user_email_data = $mydb->get_all( TBL_USER, '*', array( 'st_phone_no' => $txt_phone_no ) );
            
            if( isset( $user_email_data['in_user_id'] ) && $user_email_data['in_user_id'] != '' ){
                    return -2;
            }else{
                $arr_data = array(
                    'st_full_name' => $txt_full_name,
                    'st_phone_no'  => $txt_phone_no,
                    'st_user_type' => $dl_user_type,
                    'st_password' => md5( $txt_password ),
                    'st_email_id' => $txt_email,
                    'st_adhar_no' => $txt_adhar_no,
                    'st_gst_no' => $txt_gst_no,
                    'in_is_active' => 0,
                );
                $insert_id = $mydb->insert( TBL_USER, $arr_data );

                if ( $insert_id !== '' && $insert_id > 0 ) {
                    if ( $this->flag_err == FALSE ) {
                        return $insert_id;
                    } else {
                        return 0;
                    }
                } else {
                    $this->flag_err = TRUE;
                }
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $user_id
     * @param type $key
     * @param type $is_admin
     * @return type
     */
    function get_user_data_by_key( $user_id = 0, $key, $is_admin = TRUE ) {
        global $mydb;

        $select = '*';
        if ( $user_id != 0 || $user_id != '' ) {
            $where = ' in_user_id = ' . $user_id;
        }
        if ( !is_array( $key ) ) {
            if ( isset( $key ) && trim( $key ) !== '' ) {
                $select = $key;
            }
        } else {
            $select = implode( ',', $key );
        }
        if ( $is_admin == FALSE ) {
            $where = " st_user_type <> 'Admin' AND in_is_active = 1 ";
        }
        
        $str_query = 'SELECT ' . $select . ' FROM ' . $mydb->prefix . TBL_USER . $where . ' AND in_is_active = 1';
    
//        $response = $mydb->query( $str_query );
        $response = $mydb->get_row( TBL_USER, $select, $where );
        
        return $response;
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $key
     * @param type $value
     * @return type
     */
    public function get_user_data_by( $key = '', $value = '' ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_USER . ' WHERE ' . $key . ' = "' . $value . '"';

        $response = $mydb->query( $str_query );

        if ( $response != 0 && count( $response ) > 0 ) {
            return $response;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $key
     * @param type $value
     * @return type
     */
    public function get_visitor_by_key( $key = '', $value = '' ) {

        global $mydb;

        $str_query = 'SELECT * from ' . $mydb->prefix . TBL_VISITOR_USER . ' WHERE ' . $key . ' = "' . $value . '"';

        $response = $mydb->query( $str_query );

        if ( $response != 0 && count( $response ) > 0 ) {
            return $response;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    public function verify_otp_no( $data = '' ) {
        global $mydb;
        if ( !session_id() ) {
            session_start();
        }
        $session_id = session_id();
        $otp_no = ( isset( $data['otp_no'] ) && trim( $data['otp_no'] ) !== '' ) ? trim( $data['otp_no'] ) : '';
        if( isset( $otp_no ) && $otp_no != "" ){
            $str_query = 'SELECT * from ' . $mydb->prefix . TBL_VISITOR_USER . ' WHERE in_session_id = "' . $session_id . '" AND st_otp_no = "' . $otp_no . '" ';
            $response = $mydb->query( $str_query );
        }
        
        $request_date = date( 'h:i:s', strtotime( $response['dt_created_at'] ) );
        $endTime = strtotime( "+5 minutes", strtotime( $request_date ) );
        $expire_date = date( 'h:i:s', $endTime );
        if ( $response != 0 && count( $response ) > 0 ) {
            $current_date = date( 'h:i:s' );
            if( isset( $expire_date ) && $current_date > $expire_date ){
                return -1;
            }else{
                return $response;
            }
        } else{
            return 0;
        }
    }
    
    
    
    /**
     * 
     * @global type $mydb
     * @param type $user_id
     * @param type $key
     * @param type $value
     * @return int
     */
    function add_user_data( $user_id = 0, $key = '', $value = '' ) {
        if ( $user_id > 0 && trim( $key ) !== '' ) {
            global $mydb;
            $where = array(
                'in_user_id' => $user_id
            );
            
            $arr_data = array(
                'in_user_id' => $user_id,
                $key => $value
            );
            $insert_id = $mydb->insert( TBL_USERMETA, $arr_data );
            if ( $insert_id != 0 && $insert_id > 0 ) {
                return( $insert_id );
            } else {
                return 0;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $user_id
     * @param type $key
     * @param type $value
     * @return int
     */
    function update_userdata( $user_id = 0, $key = '', $value = '' ) {
        if ( $user_id > 0 && trim( $key ) !== '') {
            global $mydb;
            $update = FALSE;
            $where = array(
                'in_user_id' => $user_id
            );
            
            $arr_data = array(
                $key => $value
            );
            $update_id = $mydb->update( TBL_USER, $arr_data, $where );
            if ( $update_id != 0 && $update_id > 0 ) {
                return( $update_id );
            } else {
                return 0;
            }
        }
    }
   
    /**
     * 
     * @global type $mydb
     * @param type $user_id
     * @return string
     */
    public function get_user_by_id( $user_id = 0 ){
        if ( isset( $user_id ) && $user_id > 0 ){
            global $mydb;
            $where = array( 
                'in_user_id'=> $user_id 
            );
            $user_data = $mydb->get_all( TBL_USER, '*', $where );
            if( isset( $user_data ) && $user_data != '' ){
                return $user_data;
            }else{
                return '';
            }
        }
    }
    
    /**
     * Get users by criteria
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    function get_users( $data = array() ){
        global $mydb;
        
        $select = array(
            'in_user_id',
            'st_full_name',
            'st_email_id',
            'st_phone_no',
            'st_user_type',
            'dt_created_at',
        );
        
        $user_type = ( ( isset( $data['user_type'] ) && !empty( $data['user_type'] ) ) ? $data['user_type'] : 'user' );
        
        $where = array(
            'in_is_deleted' => 0,
            'st_user_type' => $user_type
        );
        
        $offset = 0;
        $limit = 10;
        $order_by = 'in_user_id DESC';
        
        if( empty( $data ) ){
            $response = $mydb->get_all( TBL_USER, $select );
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
//        $str_query  = 'SELECT in_user_id, st_full_name, st_email_id, st_phone_no, dt_created_at FROM texraja_user WHERE `st_user_type` = "user"  AND `in_is_deleted` = "0"   ORDER BY in_user_id desc LIMIT 10';
        $response = $mydb->get_all( TBL_USER, $select, 'in_is_deleted = 0 AND st_user_type <> "admin" ', $order_by, $offset, $limit );
        
        return $response;
    }
    
    /**
     * Get total number of users by criteria
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    function get_user_count( $data = array() ){
        global $mydb;
        
        $select = "COUNT( in_user_id )";
        
        $user_type = ( ( isset( $data['user_type'] ) && !empty( $data['user_type'] ) ) ? $data['user_type'] : 'user' );
        
        $where = array(
            'in_is_deleted' => 0,
            'st_user_type' => $user_type
        );
        
        if( isset( $data['where'] ) && !empty( $data['where'] ) ){
            $where = $data['where'];
        }
        
        $response = $mydb->get_var( TBL_USER, $select, 'in_is_deleted = 0 AND st_user_type != "admin" ' );
        return $response;
    }
    
    /**
     * Change the status of the user
     * 
     * @global type $mydb
     * @param type $user_id
     * @param type $status
     * @return int
     */
    function change_user_status( $user_id, $status ){
        if ( !empty( $user_id ) ){
            global $mydb;
            
            $set = array(
                'in_is_active'=> $status
            );
            
            $where = array( 
                'in_user_id'=> $user_id
            );
            
            $update_id = $mydb->update( TBL_USER, $set, $where );
            
            if( $update_id > 0 ){
                return 1;
            } else {
                return 0;
            }
        }
    }
    
}
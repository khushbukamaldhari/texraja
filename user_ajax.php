<?php
require_once 'config/config.php';
echo "Helllo sagar";
$ajax = new user_ajax();

if ( isset( $_POST['action'] ) && !empty( trim( $_POST['action'] ) ) ) {
    $call = trim( $_POST['action'] );
    if( method_exists( $ajax, $call ) ){
        if( isset( $_POST["enc_data"] ) && !empty( $_POST["enc_data"] ) ){
            $dec_data = $ajax->dec_post_data( $_POST["enc_data"] );
        } else {
            $dec_data = $_POST;
        }
        $ajax->$call( $dec_data );
    } else {
        $result = array(
            'success_flag' => 0,
            'message' => 'No AJAX call available...'
        );
        echo json_encode( $result );
    }
} else if ( isset( $_POST['enc_data'] ) && !empty( $_POST['enc_data'] ) ) {
    $dec_data = $ajax->dec_post_data( $_POST["enc_data"] );
    if ( isset( $dec_data['action'] ) && !empty( $dec_data['action'] ) ) {
        $call = trim( $dec_data['action'] );
        if( method_exists( $ajax, $call ) ){
            $ajax->$call( $dec_data );
        } else {
            $result = array(
                'success_flag' => 0,
                'message' => 'No AJAX call available...'
            );
            echo json_encode( $result );
        }
    }
}

class user_ajax {
    private $crypto;
    public function __construct() {
        include_once FL_CRYPTOJS;
        $this->crypto = new crypto();
        
        $this->result['success_flag'] = false;
        $this->result['message'] = '';
        $this->result['data'] = array();
    }
    
    /**
     * 
     * @param type $data
     * Get Common variable and constant
     */
    public function global_var( $data ) {
        if ( isset( $data ) ) {
            include_once FL_COMMON;
            $common = new common();
            $global_var = $common->global_var();
        }
        echo ( json_encode( $global_var ) );
    }
    
    /**
     * 
     * @param type $data
     * @return type
     * Encrpte data
     */
    public function enc_post_data( $data ) {
        return $this->crypto->enc_aes( $data );
    }
    
    /**
     * 
     * @param type $data
     * @return type
     * Decrypt data
     */
    public function dec_post_data( $data ) {
        return $this->crypto->dec_aes( $data );
    }

    /**
     * 
     * @global type $mydb
     * @param type $data
     * User login
     */
    public function user_login( $data ) {
        
        if ( isset( $data['txt_phone_no'] ) && trim( $data['txt_phone_no'] ) !== '' && isset( $data['txt_password'] ) && trim( $data['txt_password'] ) !== '' ) {
            global $mydb;
            $phone_no = $data['txt_phone_no'];
            $password = $data['txt_password'];
            $where = array(
                'st_phone_no' => $phone_no,
                'st_password' => md5( $password )
            );
            $response = $mydb->get_row( TBL_USER, 'in_user_id,in_is_active, st_user_type', $where );
            if ( $response != 0 && count( $response ) > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                include_once FL_USER;
                $user = new user();
                $user_id = $response['in_user_id'];
                if ( $response['st_user_type'] == 'admin' ) {
                    $_SESSION['user_id'] = $response['in_user_id'];
                    $_SESSION['user_type'] = $response['st_user_type'];
                    $this->result['success_flag'] = true;
                    $this->result['redirect'] = VW_ADMIN_HOME;
                } else if ( $response['in_is_active'] == 1 ) {
                    $_SESSION['user_id'] = $response['in_user_id'];
                    $_SESSION['user_type'] = $response['st_user_type'];
                    $this->result['success_flag'] = true;
                    $this->result['redirect'] = VW_PRODUCT;
                    $this->result['message'] = 'Login successfully';
                } else if ( $response['in_is_active'] == 0 ) {
                    $this->result['success_flag'] = false;
                    $this->result['redirect'] = VW_LOGIN;
                    $this->result['message'] = 'Thank You For Register in TexRaja, Please wait till User Approve By Admin';
                } else if ( $response['in_is_active'] == -1 ) {
                    $this->result['success_flag'] = false;
                    $this->result['redirect'] = VW_REGISTRATION;
                    $this->result['message'] = 'User Rejected By Admin';
                }
            } else {
                $this->result['success_flag'] = false;
                $this->result['message'] = 'Wrong Phone no or Password';
            }
            echo $this->enc_post_data( $this->result );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * add user
     */
    public function add_user( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();

            $insert_id = $user->add_user( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "";
                $this->result['redirect'] = VW_LOGIN;
            } else if ( $insert_id == -2 ) {
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
     * 
     * @global type $mydb
     * @param type $data
     * add user
     */
    public function get_products_by_keyword( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product_id = isset( $data['value'] ) && !empty( $data['value'] ) ? $data['value'] : 0;
            if( !empty( $product_id ) ){
                $insert_id = $product->get_products_by_keyword( $product_id );
                if ( $insert_id > 0 ) {
                    if ( !session_id() ) {
                        session_start();
                    }
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $insert_id;
                    $this->result['message'] = "";
                } else if ( $insert_id == 0 ) {
                    $this->result['success_flag'] = false;
                    $this->result['data'] = "1";
                    $this->result['message'] = "No data found";
                } else {
                }
            }
            echo $this->enc_post_data( $this->result );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     */
    public function edit_product_by_key( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product_type = isset( $data['field'] ) && !empty( $data['field'] ) ? $data['field'] : '';
            $product_key = isset( $data['key'] ) && !empty( $data['key'] ) ? $data['key'] : '';
            $product_value = isset( $data['value'] ) && !empty( $data['value'] ) ? $data['value'] : '';
            $product_id = isset( $data['id'] ) && !empty( $data['id'] ) ? $data['id'] : '';
            if( !empty( $product_value ) && !empty( $product_key ) && !empty( $product_id ) ){
                $insert_id = $product->edit_products_by_key( $product_id , $product_key, $product_value, $product_type );
                if ( $insert_id > 0 ) {
                    if ( !session_id() ) {
                        session_start();
                    }
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $insert_id;
                    $this->result['message'] = "";
                } else if ( $insert_id == 0 ) {
                    $this->result['success_flag'] = false;
                    $this->result['data'] = "1";
                    $this->result['message'] = "No data found";
                } else {
                }
            }
            echo $this->enc_post_data( $this->result );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * signup first step
     */
    public function signup_first_step( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();

            $insert_id = $user->add_visitor( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "";
            } else if ( $insert_id == -2 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Phone no already exist";
            } else {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            echo $this->enc_post_data( $this->result );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * signup second step( Resend OTP verification )
     */
    public function signup_resend_otp( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();

            $insert_id = $user->signup_resend_otp( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "OTP send succesffuly";
            } else if ( $insert_id == -1 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Phone no already exist";
            } else {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
            }
            echo $this->enc_post_data( $this->result );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * signup second step( OTP verification )     
     */
    public function signup_step_second( $data ) {
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_USER;
            $user = new user();

            $insert_id = $user->verify_otp_no( $data );
            if ( $insert_id > 0 ) {
                if ( !session_id() ) {
                    session_start();
                }
                $this->result['success_flag'] = true;
                $this->result['data'] = $insert_id;
                $this->result['message'] = "";
            } else if ( $insert_id == -1 ) {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "Please send OTP Again";
            } else {
                $this->result['success_flag'] = false;
                $this->result['data'] = "";
                $this->result['message'] = "OTP Number is wrong";
            }
            echo $this->enc_post_data( $this->result );
        }
    }
    
    function add_user_product( $data ){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product_id = isset( $data['value'] ) && !empty( $data['value'] ) ? $data['value'] : 0;
            if( !empty( $product_id ) ){
                $insert_id = $product->add_user_product( $product_id );
                
                if ( $insert_id > 0 ) {
                    if ( !session_id() ) {
                        session_start();
                    }
                    $this->result['success_flag'] = true;
                    $this->result['data'] = $insert_id;
                    $this->result['attribute_html'] = $this->get_attribute_html($data);
                    $this->result['message'] = "";
                } else {
                }
            }            
            echo $this->enc_post_data( $this->result );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * update user product category
     */
    public function get_attribute_html( $data ){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            $html = "<select class='category_tags' multiple>";
            include_once FL_PRODUCT;
            $product = new product();
            $product_category = $product->get_attribute_by_type('category');  
            $product_id = isset( $data['value'] ) && !empty( $data['value'] ) ? $data['value'] : 0;
            $product_attributes = $product->get_attributes_by_product_id($product_id);
            $product_attributes_ids = array();
            if ( isset($product_attributes) && $product_attributes != "" ) {
                foreach ( $product_attributes as $pck => $pcv ) {
                    array_push( $product_attributes_ids, $pcv['in_attr_id'] );
                }
            }
            if ( isset( $product_category ) && $product_category > 0 ) {
                foreach ( $product_category as $pck => $pcv ){
                    $selected = ( in_array($pcv['in_attr_id'], $product_attributes_ids) ? "selected" : "" ); 
                    $html .= "<option $selected value='" . $pcv['in_attr_id'] . "'>".$pcv['st_attr_name']."</option>";
                }
            }
            $html .= "</select>";
            
        }
        return $html;
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * update user product category
     */
    public function update_attribute($data){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product->add_user_attribute($data);
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $data
     * update user product category
     */
    public function delete_attribute($data){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            include_once FL_PRODUCT;
            $product = new product();
            $product->delete_user_attribute($data);
        }
    }

}

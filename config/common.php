<?php
class common {    
    
    public $arr_exclude = array( "logout.php" );
    
    function __construct(){
    
    }

    function redirect( $location ){
        header( "location:" . $location );
        exit;
    }
    
    function sanitize_input() {
        foreach ( $_POST as $key => $value ) {
            $_POST[$key] = mysqli_real_escape_string( trim( $value ) );
        }
    }

    function include_extra_js( $extra_js, $path = "user" ){
        if( $path == "user" ) {
            $js_path = JS_PATH;
        } else {
            $js_path = ADMIN_JS_PATH;
        }
        if( !empty( $extra_js ) && count( $extra_js ) > 0 ){
            $extra_js = array_unique( $extra_js );
            foreach ( $extra_js as $js ) {
                if( preg_match( '/^.*\.js$/', $js ) ){
                    echo '<script type="text/javascript" src="' . $js_path . $js . '"></script>';
                } else if( isset ( $external_js[$js] ) ){
                    echo '<script type="text/javascript" src="' . $external_js[$js] . '"></script>';
                }
            }
        }
    }
    
    function include_extra_css( $extra_css, $path = "user" ){
        if( $path == "user" ) {
            $css_path = CSS_PATH;
        } else {
            $css_path = ADMIN_CSS_PATH;
        }
        if( !empty( $extra_css ) && count( $extra_css ) > 0 ){
            $extra_css = array_unique( $extra_css );
            foreach ( $extra_css as $css ) {
                if( preg_match( '/^.*\.css$/', $css ) ){
                    echo '<link type="text/css" rel="stylesheet" href="' . $css_path . $css . '" />';
                } else if( isset ( $external_css[$css] ) ){
                    echo '<link type="text/css" rel="stylesheet" href="' . $external_css[$css] . '" />';
                }
            }
        }
    }

    function redirect_to( $url ){
        header( "location:" . $url );
        exit;
    }
    
    function include_header( $user_type = '' ){
        if ( empty( $user_type ) ) {
            global $extra_css;
            $extra_css[] = 'styles.css';
            $extra_css[] = 'responsive.css';
            include_once FL_USER_HEADER;
        } else if( $user_type == "yarn" ){
            global $extra_css;
            $extra_css[] = 'user_styles.css';
            $extra_css[] = 'user_responsive.css';
            include_once FL_YARN_HEADER;
        } else if( $user_type == "weaver" ){
            global $extra_css;
            include_once FL_WEAVER_HEADER;
        }
    }
    
    function include_footer( $user_type = '' ){
        if ( empty( $user_type ) ) {
            global $extra_js;
            $extra_js[] = 'custom.js';
            include_once FL_USER_FOOTER;
        } else if( $user_type == "yarn" ){
            global $extra_js;
            
            include_once FL_YARN_FOOTER;
        } else if( $user_type == "weaver" ){
            global $extra_js;
            include_once FL_WEAVER_FOOTER;
        }
    }
    
    function global_var(){
        include_once FL_SETTINGS;
        include_once FL_CRYPTOJS;
        $settings = new settings();
        $crypto = new crypto();
        
        $str_enc_key = $crypto->get_key();
        $global_var = array(
            'ENC_KEY' => $str_enc_key,
        );
        return $global_var;
    }
    
    /**
     * Create a parameter for query from Datatable data
     * 
     * @global type $mydb
     * @param type $data
     * @return type
     */
    public static function get_datatable_params( $data ){
        if ( isset( $data ) && is_array( $data ) ) {
            global $mydb;
            
            $arr_order = array();
            if( isset( $data['order'] ) && !empty( $data['order'] ) && !empty( $data['columns'] ) ){
                foreach ( $data['order'] as $odr_key => $odr_val ) {
                    $str_order = $data['columns'][$odr_val['column']]['name'];
                    $str_order .= ' ' . $odr_val['dir'];
                    $arr_order[] = $str_order;
                }
            }
            
            $user_param = array(
                'order_by' => implode( ', ', $arr_order ),
                'offset' => ( ( isset( $data['start'] ) && $data['start'] > 0 ) ? $data['start'] : 0  ),
                'limit' => ( ( isset( $data['length'] ) && $data['length'] > 0 ) ? $data['length'] : 10 ),
                'search' => ( ( isset( $data['search']['value'] ) && !empty( $data['search']['value'] ) ) ? $data['search']['value'] : '' ),
            );
            
            return $user_param;
        }
    }

}
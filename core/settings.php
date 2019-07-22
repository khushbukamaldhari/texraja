<?php

$settings = new settings();

class settings {

    public $flag_err = FALSE;

    function __construct() {
        $this->flag_err = FALSE;
    }

    /**
     * 
     * @global type $mydb
     * @param type $key
     * @param type $value
     * @param type $extra
     * @param type $single
     * @return int
     */
    function add_settings($key = '', $value = '', $extra = '', $single = FALSE) {
        if (isset($key) && trim($key) !== '') {
            global $mydb;
            $insert = TRUE;
            if (is_array($value)) {
                $value = json_encode($value);
            }
            if (is_array($extra)) {
                $extra = json_encode($extra);
            }
            if ($single == TRUE) {
                $sl_where = array(
                    'st_setting_key' => $key
                );
                $setting_data = $mydb->get_all(TBL_SETTINGS, 'st_setting_key, st_setting_value', $sl_where);
                if ($setting_data != 0 && count($setting_data) > 0) {
                    $insert = FALSE;
                }
            }
            if ($insert == TRUE) {
                $arr_data = array(
                    'st_setting_key' => $key,
                    'st_setting_value' => $value,
                    'st_setting_extra' => $extra
                );
                $insert_id = $mydb->insert(TBL_SETTINGS, $arr_data);
                if ($insert_id != 0 && $insert_id > 0) {
                    return( $insert_id );
                } else {
                    return 0;
                }
            }
            return 0;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $key
     * @param type $value
     * @param type $extra
     * @return int
     */
    function update_settings($key = '', $value = '', $extra = '') {
        if (isset($key) && trim($key) !== '') {
            global $mydb;
            $update = FALSE;
            $sl_where = array(
                'st_setting_key' => $key
            );
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $exist_setting = $mydb->get_all(TBL_SETTINGS, 'st_setting_key, st_setting_value', $sl_where);
            if ($exist_setting != 0 && count($exist_setting) > 0) {
                $update = TRUE;
            }
            if ($update == TRUE) {
                if ($extra != "" && isset($extra)) {
                    $arr_data = array(
                        'st_setting_value' => $value,
                        'st_setting_extra' => $extra
                    );
                } else {
                    $arr_data = array(
                        'st_setting_value' => $value
                    );
                }
                
                $where = array(
                    'st_setting_key' => $key
                );
                

                $update_id = $mydb->update(TBL_SETTINGS, $arr_data, $where);
                if ($update_id != 0 && $update_id > 0) {
                    return( $update_id );
                } else {
                    return 0;
                }
            } else {
                return $this->add_settings($key, $value, $extra);
            }
            return 0;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $setting_key
     * @param type $single
     * @return type
     */
    function get_settings( $setting_key = '', $single = FALSE ) {
        if (isset($setting_key) && trim($setting_key) !== '') {
            global $mydb;
            $where = array(
                'st_setting_key' => $setting_key
            );

            $response = $mydb->get_all( TBL_SETTINGS, '*', $where );
            
            if( $response != 0 && count( $response ) > 0 ) {
                if( isset( $response['in_setting_id'] ) ){
                    $response = array( $response );
                }
                if ($single == TRUE) {
                    return $response[0]['st_setting_value'];
                } else {
                    return $response[0];
                }
                return $response;
            }
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $setting_key
     * @return int
     */
    function delete_settings($setting_key = '') {
        if (isset($setting_key) && trim($setting_key) !== '') {
            global $mydb;
            $where = ' WHERE st_setting_key = "' . $setting_key . '"';
            $str_query = 'DELETE FROM ' . $mydb->prefix . TBL_SETTINGS . ' ' . $where;
            $response = $mydb->query($str_query);
            if ($response != 0 && count($response) > 0) {
                return $response;
            } else {
                return 0;
            }
        }
    }

   
}
?>
<?php
$GLOBALS['mydb'] = new connection();
$GLOBALS['mydb']->prefix = DBPREFIX;

define( 'COL_CHAR' , '`' );

class connection {
    /**
     * 
     * @return type
     */
    function connect() {
        $con = mysqli_connect( HOSTNAME, DBUSERNAME, DBPASSWORD, DBNAME );
        if ( mysqli_connect_errno() ) {
            echo "Failed to Connect with Database: " . mysqli_connect_error();
        } else {
            $this->con = $con;
            return $con;
        }
    }
    
    function __construct(){
        $this->connect();
    }
        
    /**
     * 
     * @param type $query
     * @return int
     */
    function query( $query ) {
        $result = mysqli_query( $this->con, $query ) or die( mysqli_error( $this->con ) );
        if( isset( $result->num_rows ) ){
            if ( $result->num_rows > 0 ) {
                $final = array();
                while( $row = $result->fetch_assoc() ){
                    $final[] = $row;
                }
                return $final;
            } else {
                return 0;
            }
        } else {
            return $result;
        }
    }
    
    
    /**
     * 
     * @global type $mydb
     * @param type $table
     * @param type $select
     * @param type $where
     * @param type $order_by
     * @param type $offset
     * @param type $limit
     * @param type $count
     * @return type
     */
    function get_all( $table, $select = '', $where = '' , $order_by = '' , $offset = 0 , $limit = 0 ){
        global $mydb;
        $select_table = $mydb->prefix . $table;
        $seperator = '';
        $str_offset = '';
        $str_order_by = '';
        $str_limit = '';
        $str_where = ' WHERE ';
        
        if( !is_array( $select ) ){
            if( trim( $select ) !== '' ){
                $select = trim( $select );
            }
        } else if( is_array( $select ) && !empty ( $select ) ){
            $select = implode( ', ', $select );
        }
        $str_select = $select;
        
        if( is_array( $where ) && !empty( $where ) ){
            foreach ( $where as $wk => $wv ){                
                if( trim( $wk ) !== '' && trim( $wv ) !== '' ){
                    $wv = trim( $wv );
                }
                $str_where .= $seperator . COL_CHAR . $wk . COL_CHAR . ' = "' . $wv . '" ';
                $seperator = ' AND ';
            }
        } else if( !empty( $where ) ){
            $str_where .= $where . ' ';
        } else {
            $str_where = '';
        }
        
        if( isset( $order_by ) && trim( $order_by ) != ''  ){
            $str_order_by = "  ORDER BY " . $order_by ;
        }
        
        if( !empty( $limit ) && $limit > 0 ){
            $str_limit = " LIMIT " . $limit;
            if( isset( $offset ) && trim( $offset ) != '' && $offset > 0 ){
                $str_offset = $offset;
                $str_limit = " LIMIT " . $str_offset . ", " . $limit;
            }
        }
        
        $str_query = 'SELECT ' . $str_select . ' FROM ' . $select_table . $str_where  . $str_order_by . $str_limit;
        
        $response = $mydb->query( $str_query );
        
        return $response;
    }
    
    /**
     * Get only first row of the result.
     * 
     * @param type $table
     * @param type $select
     * @param type $where
     * @param type $order_by
     * @param type $offset
     * @param type $limit
     * @return type
     */
    function get_row( $table, $select = '', $where = '' , $order_by = '' , $offset = 0 , $limit = 0 ){
        $data = $this->get_all( $table, $select, $where, $order_by, $offset, $limit );
        if( !empty( $data ) && isset( $data[0] ) ){
            return $data[0];
        }
    }
    
    /**
     * Get only first column value of the first row of the result.
     * 
     * @param type $table
     * @param type $select
     * @param type $where
     * @param type $order_by
     * @param type $offset
     * @param type $limit
     * @return type
     */
    function get_var( $table, $select = '', $where = '' , $order_by = '' , $offset = 0 , $limit = 0 ){
        $data = $this->get_row( $table, $select, $where, $order_by, $offset, $limit );
        if( !empty( $data ) ){
            return reset( $data );
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $table
     * @param type $data
     * @return int
     */
    function insert( $table, $data ){
        global $mydb;
        $insert_table = $mydb->prefix . $table;
        $arr_fields = array();
        $arr_data = array();
        foreach ( $data as $key => $value ){
            $arr_fields[] = COL_CHAR . $key . COL_CHAR;
            if( !is_array( $value ) ){
                if( trim( $value ) !== '' ){
                    $value = trim( $value );
                }
            } else if( is_array( $value ) ){
                $value = json_encode( $value );
            }
            $arr_data[] = mysqli_real_escape_string( $this->con, $value );
        }        
        $str_insert = 'INSERT INTO ' . $insert_table . ' (' . implode( ',', $arr_fields ) . ')
                        VALUES ("' . implode( '","', $arr_data ) . '")';
        if ( $this->con->query( $str_insert ) === TRUE ) {
            $last_id = $this->con->insert_id;
            return $last_id;
        } else {
            return 0;
        }
    }
    
    /**
     * 
     * @global type $mydb
     * @param type $table
     * @param type $data
     * @param type $where
     * @return type
     */
    function update( $table, $data, $where ){
        global $mydb;
        $update_table = $mydb->prefix . $table;
        $arr_data = array();
        $str_set = ' SET ';
        $seperator = '';
        $str_where = ' WHERE ';
        foreach ( $data as $key => $value ){
            if( !is_array( $value ) ){
                if( trim( $value ) !== '' ){
                    $value = trim( $value );
                }
            } else if( is_array( $value ) ){
               
                $value = json_encode( $value );
            }
            $str_set .= $seperator . COL_CHAR . $key . COL_CHAR . ' = "' . mysqli_real_escape_string($this->con, $value) . '" ';
            
            $seperator = ',';
        }
        $seperator = '';
        if( is_array( $where ) ){
            foreach ( $where as $wk => $wv ){                
                if( trim( $wk ) !== '' && trim( $wv ) !== '' ){
                    $wv = trim( $wv );
                }
                $str_where .= $seperator . COL_CHAR . $wk . COL_CHAR . ' = "' . $wv . '" ';
                $seperator = ' AND ';
            }
        } else if( trim( $where ) !== '' ){
            $str_where .= $where . ' ';
        } else {
            $str_where = '';
        }

        $str_update = 'UPDATE ' . $update_table . $str_set . $str_where;
        $last_id = $this->con->query( $str_update );
        return $last_id;
    }
}

?>
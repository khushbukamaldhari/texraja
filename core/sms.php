<?php
$sms = new sms();
use Twilio\Rest\Client;
class sms{
    private $sid = '';
    
    private $tokan = '';
      
    private $from_number = '';
    
    private $mode = '';
    
    private $to_number = '';
        
    function __construct() {
        
        $sms_sid = SMS_SID;
        $sms_tokan = SMS_TOKEN;
        $sms_from_number = SMS_FROM_NUMBER;
        $sms_mode = SMS_MODE;
        $sms_to_number = SMS_TO_NUMBER;
        
        $this->sid = $sms_sid;
        $this->tokan = $sms_tokan;
        $this->from_number = $sms_from_number;
        $this->mode = $sms_mode;
        $this->to_number = $sms_to_number;
        
    }
    
    /**
     * 
     * @param type $user_id
     * @param type $boby
     * @return type
     */
    public function send_sms( $user_id = 0 , $boby = "" ) {
        if ( isset( $user_id ) && trim( $user_id ) != "" ) {
            $res = '';
            if( isset( $body ) && $body != '' ){
                $body = $body;
            }
            try {
                require_once( PL_SMS_TWILIO . 'Twilio/autoload.php' );
                if( $this->mode == "test" ){
                    $reciever = '+' . $this->to_number;
                } else{
                    include_once FL_USER;
                    $user = new user();
                    $reciever = $user->senitize_contact_by_user( $user_id );
                }

                $from = '+' . $this->from_number;
                $client = new Client( $this->sid, $this->tokan );
                $res = $client->account->messages->create( $reciever , 
                    array(
                        "From" => $from,
                        "Body" => $boby,
                        'statusCallback' => "http://requestb.in/1234abcd"
                    )
                );
            } catch ( Exception $ex ) {
                
            }
            
            return $res;
        }
    }
    
    /**
     * 
     * @param type $sid
     * @param type $tokan
     * @param type $form_number
     * @param type $to_number
     * @param type $boby
     * @return type
     */
    public function send_direct_sms( $sid = '', $tokan = '', $form_number = '', $to_number = '' , $boby = "" ) {
        if ( isset( $to_number ) && trim( $to_number ) != "" ) {
            $res = '';
            if( isset( $body ) && $body != '' ){
                $body = $body;
            }
            try {
                require_once( PL_SMS_TWILIO . 'Twilio/autoload.php' );
                $sid = $sid;
                $token = $tokan;
                $reciever = '+' . $to_number;
                $from = '+' . $form_number;
                $client = new Client( $this->sid, $this->tokan );
                $res = $client->messages->create( $reciever , 
                    array(
                        "From" => $from,
                        "Body" => $boby,
                        'statusCallback' => "http://requestb.in/1234abcd"
                    )
                );
            } catch ( Exception $ex ) {
                
            }
            
            return $res;
        }
    }
    
    /**
     * 
     * @param type $user_id
     * @param type $tmp_template
     * @param type $body_data
     */
    function send_sms_by_template( $user_id = 0, $tmp_template = '', $body_data = '' ){
        include_once FL_NOTIFICATION;
        $notification = new notification();
        $email_body = $notification->prepare_notify_message( $user_id, $tmp_template, $body_data );
        $this->send_sms( $user_id, $email_body );
    }
 
}

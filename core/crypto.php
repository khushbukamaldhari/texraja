<?php

/**
 * Helper library for CryptoJS AES encryption/decryption
 * Allow you to use AES encryption on client side and server side vice versa
 *
 * @author BrainFooLong (bfldev.com)
 * @link https://github.com/brainfoolong/cryptojs-aes-php
 */


class crypto {
    
    private $enc_key = '';
    
    function __construct() {
        $this->enc_key = $this->define_key();
    }
    
    /**
     * 
     * @return type
     */
    private function define_key() {
        include_once FL_SETTINGS;
        $settings = new settings();
        $enc_key = $settings->get_settings( 'encryption_key', TRUE );
        $str_enc_key = md5( $enc_key );
        return $str_enc_key;
    }
    
    function get_key() {
        return $this->enc_key;
    }

    /**
     * Decrypt data from a CryptoJS json encoding string
     *
     * @param mixed $passphrase
     * @param mixed $jsonString
     * @return mixed
     */
    private function cryptoJsAesDecrypt($passphrase, $jsonString) {
        $jsondata = json_decode($jsonString, true);
        try {
            $salt = hex2bin($jsondata["s"]);
            $iv = hex2bin($jsondata["iv"]);
        } catch (Exception $e) {
            return null;
        }
        $ct = base64_decode($jsondata["ct"]);
        $concatedPassphrase = $passphrase . $salt;
        $md5 = array();
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }

    /**
     * Encrypt value to a cryptojs compatiable json encoding string
     *
     * @param mixed $passphrase
     * @param mixed $value
     * @return string
     */
    private function cryptoJsAesEncrypt($passphrase, $value) {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx . $passphrase . $salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv = substr($salted, 32, 16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
        return json_encode($data);
    }
    
    public function enc_aes( $value ) {
        return $this->cryptoJsAesEncrypt( $this->enc_key, $value );
    }
    
    public function dec_aes( $jsonString ) {
        return $this->cryptoJsAesDecrypt( $this->enc_key, $jsonString );
    }
}

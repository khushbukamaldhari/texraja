<?php
$SERVER_NAME = $_SERVER[ 'HTTP_HOST' ];
define( 'BASE_DIR', 'webcase/texraja' );
define( 'SITE_NAME', 'Tex Raja' );
define( 'DIR_SEPERATOR', '/' );
define( 'CONFIG_DIR', 'config' );
define( 'BASE_PATH', $_SERVER[ 'DOCUMENT_ROOT' ] . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR );
define( 'BASE_URL', isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] != 'off' ? 'https' . '://' . $_SERVER[ 'HTTP_HOST' ] . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR : 'http' . '://' . $_SERVER[ 'HTTP_HOST' ] . DIR_SEPERATOR . BASE_DIR . DIR_SEPERATOR  );
define( 'ADMIN_DIR', 'admin' );
define( 'INCLUDE_DIR', 'includes' );
define( 'VIEW_DIR', '' );
define( 'ASSET_DIR', 'assets' );
define( 'CORE_DIR', 'core' );
define( 'USER_DIR', 'user' );
define( 'IMAGES_DIR', 'images' );
define( 'BACKEND_DIR', 'admin' );
define( 'UPLOAD_DIR', 'uploads' );
define( 'TEMPLATE_PART_DIR', 'template_parts' );
define( 'JS_PATH', BASE_URL . ASSET_DIR . DIR_SEPERATOR . 'js' . DIR_SEPERATOR);
define( 'JS_PLUGINS_PATH', BASE_URL . ASSET_DIR . DIR_SEPERATOR . 'js' . DIR_SEPERATOR ."plugins" . DIR_SEPERATOR  );
define( 'ADMIN_JS_PATH', BASE_URL . BACKEND_DIR . DIR_SEPERATOR . ASSET_DIR . DIR_SEPERATOR . 'js' . DIR_SEPERATOR);
define( 'ADMIN_URL', BASE_URL . BACKEND_DIR . DIR_SEPERATOR );
define( 'CSS_PATH', BASE_URL . ASSET_DIR . DIR_SEPERATOR . 'css' . DIR_SEPERATOR );
define( 'UPLOAD_URL', BASE_URL . UPLOAD_DIR . DIR_SEPERATOR );
define( 'UPLOAD_PATH', BASE_PATH . UPLOAD_DIR . DIR_SEPERATOR );
define( 'IMAGES_URL', BASE_URL . ASSET_DIR . DIR_SEPERATOR . IMAGES_DIR . DIR_SEPERATOR );
define( 'IMAGES_PATH', BASE_PATH . ASSET_DIR . DIR_SEPERATOR . IMAGES_DIR . DIR_SEPERATOR );

//Database
define( 'HOSTNAME', 'localhost' );

define( 'DBUSERNAME', 'herinh4u_webdev' );

define( 'DBPASSWORD', 'webdev123*' );

define( 'DBNAME', 'herinh4u_texraja' );

define( 'DBPREFIX', 'texraja_' );

//Table Names
define( 'TBL_USER', 'user' );
define( 'TBL_VISITOR_USER', 'visitor_user' );
define( 'TBL_SETTINGS', 'settings' );
define( 'TBL_PRODUCT', 'products' );
define( 'TBL_PRODUCT_ATTRIBUTE', 'product_attributes' );
define( 'TBL_PRODUCT_PROPERTIES', 'product_properties' );
define( 'TBL_ATTRIBUTES', 'attributes' );
define( 'TBL_USER_PRODUCT', 'user_products' );
define( 'TBL_USER_PRODUCT_ATTRIBUTE', 'user_product_attributes' );
define( 'TBL_USER_PRODUCT_PROPERTIES', 'user_product_properties' );
define( 'TBL_USER_ATTRIBUTES', 'user_attributes' );

/* Includes */
define( 'FL_USER_HEADER', BASE_PATH . INCLUDE_DIR . DIR_SEPERATOR . 'header.php');
define( 'FL_YARN_HEADER', BASE_PATH . INCLUDE_DIR . DIR_SEPERATOR . 'header-yarn.php');
define( 'FL_YARN_LEFT_SIDE', BASE_PATH . INCLUDE_DIR . DIR_SEPERATOR . 'left-side.php');
define( 'FL_YARN_FOOTER', BASE_PATH . INCLUDE_DIR . DIR_SEPERATOR . 'footer-yarn.php');
define( 'FL_USER_HEADER_INCLUDE', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'header-includes.php');
define( 'FL_USER_FOOTER', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'footer.php' );
define( 'FL_USER_FOOTER_INCLUDE', BASE_PATH . DIR_SEPERATOR . INCLUDE_DIR . DIR_SEPERATOR . 'footer-includes.php');

/* Views File */
define( 'VW_REGISTRATION', BASE_URL . VIEW_DIR . 'register' );
define( 'VW_LOGIN', BASE_URL . VIEW_DIR . 'login' );
define( 'VW_LOGOUT', BASE_URL . VIEW_DIR . 'logout' );
define( 'VW_PRODUCT', BASE_URL . VIEW_DIR . 'products' );
define( 'VW_ADMIN_HOME', ADMIN_URL .  'index' );
define( 'VW_BLOG', BASE_URL . VIEW_DIR . 'blog' );
define( 'VW_HOME', BASE_URL );

/* plugin file */
define( 'PHP_PLUGIN_URL', BASE_PATH .DIR_SEPERATOR .'plugins' . DIR_SEPERATOR );
define( 'PL_MAILER', PHP_PLUGIN_URL . 'PHPMailer' .DIR_SEPERATOR );
define( 'PL_SMS_TWILIO', PHP_PLUGIN_URL . 'twilio-php-master' .DIR_SEPERATOR );

/* Core Files */
define( 'FL_ADMIN', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'admin.php');
define( 'FL_CONNECTION', BASE_PATH . DIR_SEPERATOR . CONFIG_DIR . DIR_SEPERATOR . 'connection.php' );
define( 'FL_COMMON', BASE_PATH . DIR_SEPERATOR . CONFIG_DIR . DIR_SEPERATOR . 'common.php' );
define( 'FL_USER', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'user.php');
define( 'FL_SMS', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'sms.php');
define( 'FL_CRYPTOJS', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'crypto.php');
define( 'FL_SETTINGS', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'settings.php');
define( 'FL_PRODUCT', BASE_PATH . DIR_SEPERATOR . CORE_DIR . DIR_SEPERATOR . 'product.php');

/* SMS */
define( 'SMS_SID', 'ACbd799eabe6a0d770a27d005f3b170d0b' );
define( 'SMS_TOKEN', 'e62628f027b2e5e98eeea9c65db6a53d' );
define( 'SMS_FROM_NUMBER', '12024106607' );
define( 'SMS_MODE', 'test' );
define( 'SMS_TO_NUMBER', '919898987959' );

$admin_extra_js = array();
$extra_js = array();
$admin_extra_css = array();
$extra_css= array();
//error_reporting(0);

require_once FL_CONNECTION;
$connection = new connection();
require_once FL_COMMON;
$common = new common();
if ( !session_id() ) {
    $session_id = session_start();
}
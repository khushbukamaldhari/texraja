<?php
require_once 'config/config.php';
header( 'Location:' . VW_LOGIN );
//require_once 'admin/config/admin_config.php';
include_once FL_SMS;
$sms = new sms();
//$sms->send_direct_sms(SMS_SID,SMS_TOKEN,SMS_FROM_NUMBER,SMS_TO_NUMBER,"test 12sadasrfesrec weerr3456788");
?>


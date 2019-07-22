<?php 
require_once '../config/config.php';
if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] != "admin" ){
    header( 'Location:' . VW_PRODUCT );
} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == "admin" ){
    header( 'Location:' . VW_ADMIN_HOME );
} else {
    
}
$extra_js[] = 'custom.js';
$extra_js[] = 'login_signup.js';
$common->include_header( '' );
?>
    <div id="login" class="login-form-wrap-li form-pages">
        <div class="form-box">
            <a href="<?php echo VW_HOME; ?>" class="logo-wrap">
                <img src="<?php echo IMAGES_URL; ?>/logo.png" alt="logo"/>
            </a> 
            <div class="form-wrapper">
                <form id="frm_login" name="frm_login" class="main-form" method="post">
                    <div class="form-field">
                        <input type="text" name="txt_phone_no" id="txt_phone_no" placeholder="Phone No"/>
                    </div>
                    <div class="form-field">
                        <input type="password" name="txt_password" id="txt_password" placeholder="Password"/>
                    </div>
                    <div class="form-field">
                        Don't have an account?<a href="<?php echo VW_REGISTRATION; ?>"> Sign Up</a>
                    </div>
                    <div class="form-field">
                        <label class="err_log"></label>
                    </div>
                    <div class="form-field submit-btn">
                        <input type="submit" name="next" class="next action-button" value="Next" />
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php 
    include_once FL_USER_FOOTER_INCLUDE;
    $common->include_footer( '' );
?>


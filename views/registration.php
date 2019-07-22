<?php 
require_once '../config/config.php';

if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] != "admin" ){
    header( 'Location:' . VW_PRODUCT );
    exit;
} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == "admin" ){
    header( 'Location:' . VW_ADMIN_HOME );
    exit;
} else {
    
}
$extra_js[] = 'custom.js';
$extra_js[] = 'login_signup.js';
$common->include_header( '' );
?>
<form id="frm_signup"  name="frm_signup"  method="post">
    <div class="form-field">
        <label class="err_log"></label>
    </div>
    <ul>
        <li id="first_sign_up_step" class="form-pages form-wrap-li">
            <!--Content-->
            <div  class="form-box">
                <a href="<?php echo VW_HOME; ?>" class="logo-wrap">
                    <img src="<?php echo IMAGES_URL; ?>/logo.png" alt="logo"/>
                </a>
                <div class="from-title-wrap">
                    <h2>Create Your TexRaja Account Here</h2>
                    <p>Fill the details to get started</p>
                </div>
                
                <div class="form-wrapper">
                    <div class="main-form">
                        <div class="form-field">
                            <input type="text" id="txt_full_name" name="txt_full_name" placeholder="Full Name"/>
                        </div>
                        <div class="form-field mobile-no">
                            <span>+91</span>
                            <input id="txt_phone_no" type="number" name="txt_phone_no"/>
                        </div>
                        <div class="form-field">
                            <select class="select-user" id="dl_user_type" name="dl_user_type">
                                <option selected="true" disabled="disabled">User Type</option>
                                <option value="yarn">Yarn</option>
                                <option value="weaver">Weaver</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <span class="check_terms">
                                <input class="styled-checkbox" id="checkbox-1" type="checkbox" value="value1">
                                <label for="checkbox-1">I agree to <a href="#">Terms and Conditions</a></label>
                            </span>
                        </div>
                        <div class="form-field submit-btn" id="submit_btn_step_first">
                            <input type="button"  name="next" id="btn_signup_step_first" class="next action-button" value="Next" />
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li id="second_sign_up_step"  class="form-pages form-wrap-li">
            <div class="form-box">
                <a href="#0" class="logo-wrap">
                    <img src="<?php echo IMAGES_URL; ?>/logo.png" alt="logo"/>
                </a>
                <div class="from-title-wrap">
                    <h2>Verification Code</h2>
                    <p>Please type the Verification Code Sent<br/>
                        to <span class="get-number">+91 8525 6392</span>
                    </p>
                </div>
                <div class="form-wrapper">
                    <div class="main-form">
                        <div class="form-field">
                            <input type="number" name="txt_otp_no" id="txt_otp_no" placeholder="- - - -"/>
                        </div>
                        <div class="form-field">
                            <div id="resend_otp">Resend OTP</div>
                        </div>
                        <div class="form-field submit-btn verify-btn" id="submit_btn_step_second">
                            <input type="button" name="next" id="btn_signup_step_second" class="next action-button" value="Verify" />
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li id="third_sign_up_step" class="form-pages form-wrap-li">
            <!--Content-->
            <div class="form-box">
                <a href="#0" class="logo-wrap">
                    <img src="<?php echo IMAGES_URL; ?>/logo.png" alt="logo"/>
                </a>
                <div class="from-title-wrap">
                    <h2>Complete you Signup by adding your Adhar & GST No Detail</h2>
                </div>
                <div class="form-wrapper">
                    <div class="main-form">
                        <div class="form-field">
                            <input type="email" name="txt_email" id="txt_email" placeholder="Email"/>
                        </div>
                        <div class="form-field">
                            <input type="password" name="txt_password" id="txt_password" placeholder="Password *"/>
                        </div>
                        <div class="form-field">
                            <input type="password" name="txt_cpassword" id="txt_cpassword" placeholder="Confirm Password *"/>
                        </div>
                        <div class="form-field adhar-number">
                            <input type="number" name="txt_adhar_no" id="txt_adhar_no" placeholder="Adhar Number *"/>
                        </div>
                        <div class="form-field">
                            <input type="text" name="txt_gst_no" id="txt_gst_no" placeholder="GST Number *"/>
                            <label  class="txt_gst_error" for="txt_gst_no"></label>
                        </div>
                        <div class="form-field submit-btn" id="submit_btn_step_third">
                            <input type="submit" name="next" id="btn_signup_step_third" class="next action-button" value="Submit"/>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</form>
<!--Content-->
<?php 
    include_once FL_USER_FOOTER_INCLUDE;
    $common->include_footer( '' );
?>
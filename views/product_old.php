<?php 
require_once '../config/config.php';
if( !isset( $_SESSION['user_id'] ) ){
    header( 'Location:' . VW_LOGIN );
    exit;
} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] == "admin" ){
    header( 'Location:' . VW_ADMIN_HOME );
    exit;
}else{
   
}
include_once FL_USER;
$user = new user();
include_once FL_USER_HEADER;
?>
    <div id="single-product-page" class="single-product-page form-pages">
        <!--Content-->
        <div class="form-box">
            <a href="#0" class="logo-wrap">
                <img src="<?php echo IMAGES_URL; ?>/logo.png" alt="logo"/>
            </a>
            <div class="from-title-wrap">
                <h2>Product Detail</h2>
                <p>Fill the detail to get started</p>
            </div>
            <div class="form-wrapper">
                <form id="main-form" class="main-form">
                    <div class="half-width form-field">
                        <select class="select-user">
                            <option selected="true" disabled="disabled">Product Category</option>
                            <option>Option 1</option>
                        </select>
                    </div>
                    <div class="half-width form-field">
                        <select class="select-user">
                            <option selected="true" disabled="disabled">Type of Machine</option>
                            <option>Option 1</option>
                        </select>
                    </div>
                    <div class="half-width form-field">
                        <select class="select-user">
                            <option selected="true" disabled="disabled">Product Name</option>
                            <option>Option 1</option>
                        </select>
                    </div>
                    <div class="half-width form-field quantity rupees">
                        <span><i class="fa fa-inr" aria-hidden="true"></i></span>
                        <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                    </div>
                    <div class="form-field submit-btn">
                        <input type="button" name="next" class="next action-button" value="Next" />
                    </div>
                    <div class="advance-wrap">
                        <div class="advance-top">
                            <a href="#0" class="toggle-link">Advance option <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                        </div>
                        <div class="advane-bottom">
                            <div class="advance-form-wrap">
                                <div class="half-width form-field quantity">
                                    <label>Width of Fabric</label>
                                    <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                                </div>
                                <div class="half-width form-field quantity">
                                    <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                                </div>
                                <div class="half-width form-field quantity">
                                    <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                                </div>
                                <div class="half-width form-field quantity">
                                    <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                                </div>
                                <div class="half-width form-field quantity">
                                    <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                                </div>
                                <div class="half-width form-field quantity">
                                    <input type="number" class="custom-number" name="phone-no" min="0" value="0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php 
    include_once FL_USER_FOOTER_INCLUDE;
    include_once FL_USER_FOOTER;
?>
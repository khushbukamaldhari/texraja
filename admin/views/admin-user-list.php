    <?php
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) ) {
    header( 'Location:' . VW_LOGIN );
    exit;
} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] != "admin" ) {
    header( 'Location:' . VW_PRODUCT );
    exit;
} else {
    
}
$admin_extra_js[] = 'datatable/jquery.dataTables.min.js';
$admin_extra_js[] = 'datatable/dataTables.buttons.min.js';
$admin_extra_js[] = 'datatable/dataTables.select.min.js';
//$admin_extra_js[] = 'datatable/dataTables.editor.min.js';
$admin_extra_js[] = 'datatable/dataTables.responsive.min.js';
$admin_extra_js[] = 'datatable/responsive.bootstrap.js';
$admin_extra_js[] = 'admin-user.js';

$admin_extra_css[] = 'datatable/jquery.dataTables.min.css';
$admin_extra_css[] = 'datatable/buttons.dataTables.min.css';
$admin_extra_css[] = 'datatable/select.dataTables.min.css';
//$admin_extra_css[] = 'datatable/editor.dataTables.min.css';
$admin_extra_css[] = 'datatable/dataTables.bootstrap.min.css';
$admin_extra_css[] = 'datatable/responsive.bootstrap.min.css';


include_once FL_ADMIN;
include_once FL_USER;
include_once FL_PRODUCT;
$admin = new admin();
$user = new user();
$product = new product();
include_once FL_ADMIN_HEADER;
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>User List</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <table id="tbl_user_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Registered on</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Registered on</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include_once FL_ADMIN_FOOTER_INCLUDE;
include_once FL_ADMIN_FOOTER;
?>

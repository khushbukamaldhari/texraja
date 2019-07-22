<?php
require_once '../../config/config.php';
require_once '../config/admin_config.php';
if( !isset( $_SESSION['user_id'] ) ){
    header( 'Location:' . VW_LOGIN );
    exit;
} else if( isset( $_SESSION['user_id'] ) && $_SESSION['user_id'] > 0 && $_SESSION['user_type'] != "admin" ){
    header( 'Location:' . VW_PRODUCT );
    exit;
}else{
   
}

include_once FL_ADMIN;
include_once FL_USER;
$admin = new admin();
$user = new user();
include_once FL_ADMIN_HEADER;
$admin_extra_js[] = 'datatable/jquery.dataTables.min.js';
$admin_extra_js[] = 'admin-blog.js';
$admin_extra_css[] = 'datatable/jquery.dataTables.min.css';
?>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Blogs</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <button class="add-new-blog btn-primary"><i class="fa fa-plus"></i> Add New</button>
                        <div class="display-add-blog" style="display:none;">
                        <?php 
                            require_once TP_ADD_BLOG; ?>
                        </div>
                        <table class="table blog_list">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>category</th>
                                    <th>Description</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $data = json_decode( $admin->get_blog_data(), TRUE );
                                    foreach ( $data['data'] as $key => $val ){
                                ?>
                                <tr class="blog_<?php echo $val['post_id'] ?>">
                                    <td><?php print_r( $val['title'] ); ?></td>
                                     <td><?php print_r( $val['categories'] ); ?></td>
                                     <td><?php print_r( $val['contents'] ); ?></td>
                                     <td><button data-pid="<?php echo $val['post_id'] ?>" class=" btn-success edit-click" ><i class="fa fa-pencil"></i></button></td>
                                     <td><button data-post_id="<?php echo $val['post_id'] ?>" class="btn-danger delete-click"><i class="fa fa-trash"></i></button></td>
                                </tr>
                                    <?php } ?>
                            </tbody>
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

<!-- Bootstrap -->
<link href="<?php echo ADMIN_CSS_PATH; ?>bootstrap/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="<?php echo ADMIN_CSS_PATH; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- NProgress -->
<link href="<?php echo ADMIN_CSS_PATH; ?>nprogress/nprogress.css" rel="stylesheet">
<!-- iCheck -->
<link href="<?php echo ADMIN_CSS_PATH; ?>iCheck/green.css" rel="stylesheet">
<!-- bootstrap-wysiwyg -->
<link href="<?php echo ADMIN_CSS_PATH; ?>google-code-prettify/prettify.min.css" rel="stylesheet">
<!-- Select2 -->
<link href="<?php echo ADMIN_CSS_PATH; ?>select2/select2.min.css" rel="stylesheet">
<!-- Switchery -->
<link href="<?php echo ADMIN_CSS_PATH; ?>switchery/switchery.min.css" rel="stylesheet">
<!-- starrr -->
<link href="<?php echo ADMIN_CSS_PATH; ?>starrr/starrr.css" rel="stylesheet">
<!-- bootstrap-daterangepicker -->
<link href="<?php echo ADMIN_CSS_PATH; ?>bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- Custom Theme Style -->
<link type="text/css" rel="stylesheet" href="<?php echo CSS_PATH; ?>sweetalert.css" />
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_CSS_PATH; ?>summernote.css" />
<link href="<?php echo ADMIN_CSS_PATH; ?>/custom.min.css" rel="stylesheet">
<link href="<?php echo ADMIN_CSS_PATH; ?>/admin-style.css" rel="stylesheet">
<?php 
    $common = new common();
    $common->include_extra_css( $admin_extra_css, "admin" ); 
?>         
    

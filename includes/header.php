<!DOCTYPE html>
<html dir="ltr" lang="en-US">
    <head>
        <title><?php echo isset( $page_title ) ? $page_title : 'TexRaja'; ?></title>
        <meta charset="UTF-8" />
        <meta name="HandheldFriendly" content="true">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link type="image/x-icon" rel="shortcut icon" href="<?php echo IMAGES_URL; ?>favicon.ico" />

        <!-- header head -->
        <?php
        include_once FL_USER_HEADER_INCLUDE;
        ?>
        <!-- close  header head -->

    </head>
    <header id="header" class="header">
    <div class="container">
        <div class="header-wrap">
            <a href="<?php echo VW_HOME; ?>" class="logo-wrap">
                <img src="<?php echo IMAGES_URL; ?>front-logo.png" alt="logo"/>
            </a>
            <div class="nav-menu">
                <div class="menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <ul>
                    <!--<li>-->
                    <!--    <a href="#0" class="menu-link">Contact</a>-->
                    <!--</li>-->
                    <li>
                        <a href="<?php echo VW_BLOG; ?>" class="menu-link">Blog</a>
                    </li>
                    <?php 
                    // print_r( basename( $_SERVER['PHP_SELF'] ) );
                    if( basename( $_SERVER['PHP_SELF'] ) != "login.php" && basename( $_SERVER['PHP_SELF'] ) != "blog.php" ) { $href = VW_LOGIN; $str = 'Login'; }else{ $href = VW_REGISTRATION ; $str = 'Sign Up'; } ?>
                    <li>
                        <a href="<?php echo $href; ?>" class="comm-btn"><?php echo $str; ?></a>
                    </li>
                   
                </ul>
            </div>
        </div>
    </div>
</header>
    <?php
        $pageclassname = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME); // returns 'filename.md'
        
        
    ?>
    <body class="<?php echo $pageclassname; ?>">
        <div id="wrapper">
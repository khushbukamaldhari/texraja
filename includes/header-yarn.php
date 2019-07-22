<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
<title>TexRaja | Dashboard</title>

    <!-- header head -->
    <?php
        include_once FL_USER_HEADER_INCLUDE;
        include_once FL_USER;
        $user = new user();
    ?>
    <!--close  header head -->

</head>

<body>
    <div id="wrapper">
        <?php
            include_once FL_USER;
            $user = new user();
        ?>
        <?php include_once FL_YARN_LEFT_SIDE; ?>
        <div class="site-page">
        <header class="tr-header" id="tr-header">
            <div class="toggle-menu mobile-view">
		<span></span>
		<span></span>
		<span></span>
            </div>
            <div class="search-icon mobile-view">
                    <a href="#" class="tr-m-icon"></a>
            </div>
            <div class="tr-saerch-left">
                <form>
                    <div class="tr-form-group">
                        <div class="tr-form-control tr-search-icon">
                            <input class="tr-input" type="text" name="" placeholder="Search your Choice here">
                        </div>
                    </div>
                </form>	
            </div>
            <div class="tr-profile-right">
                <div class="tr-common-line tr-alert">
                    <a href="#" class="tr-alert-icon tr-common-icon"> <span class="tr-alert-count">1</span></a>
                    <div class="tr-ul-common tr-ul-alert">  
                        <p>You have 5 notifications</p>
                    </div>
                </div>
                <div class="tr-common-line tr-language">
                    <a href="#" class="tr-language-icon tr-common-icon"></a>
                    <ul class="tr-ul-common tr-ul-language">
                        <li class="india">
                            <a href="#">India</a>
                        </li>
                        <li class="German">
                            <a href="#">German</a>
                        </li>
                    </ul>
                </div>
                <div class="tr-common-line tr-profile">
                    <?php $st_full_name = $user->get_user_data_by_key( $_SESSION['user_id'], 'st_full_name' ); ?>
                    <a href="#" class="tr-profile-name tr-common-icon">
                        <?php 
                            if( isset( $st_full_name['st_full_name'] ) ){
                                $words = explode( ' ', $st_full_name['st_full_name'] );
                                $acronym = "";
                                
                                foreach( $words as $w ) {
                                  $acronym .= $w[0];
                                }
                            }
                        ?>
                        <p class="tr-f-name"><?php echo $acronym; ?></p>
                    </a>
                    <ul class="tr-ul-common tr-profile-view">
                        <li class="tr-profile-user">
                            <a href="#">
                                <i class="fa fa-user-circle-o" aria-hidden="true"></i> 
                                <?php 
                                if( isset( $st_full_name['st_full_name'] ) ){
                                    print_r( $st_full_name['st_full_name'] ); 
                                }?>
                            </a>
                        </li>
                        <li class="tr-profile-logout">
                            <a href="<?php echo VW_LOGOUT; ?>">
                                <i class="fa fa-sign-out" aria-hidden="true"></i> 
                                Log out 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
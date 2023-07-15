<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package WP FanZone
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="preload" as="font" href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preload" as="font" href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if( is_page_template('page-templates/create-password.php') ): ?>
<?php else: ?>
<div id="page" class="hfeed site">
    <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'wp-fanzone' ); ?></a>
    <header id="masthead" class="site-header">
        <div id="top-bar" class="top-bar">
            <div class="container">            	
                <div class="row">
                    <div class="col-md-7">
                        <p style="display:inline-block; color:#fff; vertical-align: top; padding-top:10px; float:left; margin-right:10px;"><?php echo date_i18n(get_option('date_format')); ?></p>
                        <?php if ( has_nav_menu('top-menu') ) { ?>
                            <div id="top-nav" role="navigation" class="top-nav clearfix">
                                <button class="menu-toggle navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                    <span class="sr-only"><?php _e('Toggle navigation', 'wp-fanzone'); ?></span>            
                                    <span class="icon-bar"></span>            
                                    <span class="icon-bar"></span>            
                                    <span class="icon-bar"></span>
                                </button>                                                       	
                            </div>
                            <div class="collapse navbar-collapse" id="navbar-collapse">                    
                                <?php wp_nav_menu(array('theme_location' => 'top-menu', 'depth' => 1, 'container' => false)); ?>   
                            </div><!-- /.navbar-collapse --> 
                        <?php } ?>
                    </div>
                    <div class="col-md-5 user-info-box">
                        <?php if (is_user_logged_in() ): ?>
                            <?php 
                            global $current_user;
                            $member_id = $current_user->ID;
                            $first_name = $current_user->first_name;
                            $last_name  = $current_user->last_name;
                            $lats_latter = substr($last_name,0,1 );
                            
                            $redirect_to = add_query_arg( array( 'loggedout' => 'true'), home_url('/') );
                            ?>                           
                            <ul class="nav flex-row order-lg-2 ml-auto nav-icons">
                                <li class="nav-item dropdown user-dropdown align-items-center"> 
                                    <a class="nav-link text-white" href="#" id="dropdown-user"> 
                                        <span class="ml-2 h-lg-down dropdown-toggle"> 
                                            <i class="fa fa-user-circle fa-2x"></i>
                                            <?php echo $first_name. " ".$lats_latter."."; ?>
                                        </span> 
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a class="dropdown-item logout_button" title="Pool Reservations" href="<?php echo home_url('/pool-reservation/'); ?>">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <?php _e('Pool Reservations',get_theme_domain() ); ?>
                                            </a>	
                                        </li>
                                        <li>
                                            <a class="dropdown-item logout_button" title="My Reservations" href="<?php echo home_url('/my-reservations/'); ?>">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <?php _e('My Reservations',get_theme_domain() ); ?>
                                            </a>	
                                        </li>
                                        <li>
                                            <a class="dropdown-item logout_button" title="Request to IPPA" href="<?php echo home_url('/request-to-ippa/'); ?>">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <?php _e('Request to IPPA',get_theme_domain() ); ?>
                                            </a>	
                                        </li>
                                        <li>    
                                            <a class="dropdown-item logout_button" title="My Profile" href="<?php echo home_url('/my-profile/'); ?>">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <?php _e('My Profile',get_theme_domain() ); ?>
                                            </a>	
                                        </li>
                                        <li>
                                            <a class="dropdown-item logout_button" title="Change Password" href="<?php echo home_url('/change-password/'); ?>">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <?php _e('Change Password',get_theme_domain() ); ?>
                                            </a>	
                                        </li>
                                        <li>
                                            <a class="dropdown-item logout_button" title="Logout" href="<?php echo wp_logout_url( $redirect_to ); ?>">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                                <?php _e('Logout',get_theme_domain() ); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        <?php else: ?>
                            <button class="btn get-login poptrigger" title="<?php _e('Login', 'wp-fanzone'); ?>" data-rel="account_login"><?php _e('Login', 'wp-fanzone'); ?></button>
                        <?php endif; //endif  ?>
                    </div><!--end fan-sociel-media-->
                </div>
            </div>
        </div>
    <div class="site-branding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if ( get_theme_mod( 'wp_fanzone_logo' ) ) : ?>
                        <div id="site-logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                <img src="<?php echo esc_url( get_theme_mod( 'wp_fanzone_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
                            </a>
                        </div>
                    <?php else : ?>
                        <div id="site-logo">
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name', 'wp-fanzone' ); ?></a></h1>
                            <h2 class="site-description"><?php bloginfo( 'description', 'wp-fanzone' ); ?></h2>
                        </div>
                    <?php endif; ?>
                    <?php dynamic_sidebar('top-right-widget'); ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>	
    </div><!-- .site-branding -->
    <div class="nav_container">
        <div class="container">
            <nav id="site-navigation" class="main-navigation container-fluid">
                <button class="menu-toggle navbar-toggle" aria-controls="menu" aria-expanded="false">
                    <span class="sr-only"><?php _e('Toggle navigation', 'wp-fanzone'); ?></span>            
                    <span class="icon-bar"></span>            
                    <span class="icon-bar"></span>            
                    <span class="icon-bar"></span>
                </button>
                <?php wp_nav_menu(array('theme_location' => 'primary', 'fallback_cb' => 'wp_fanzone_menu', 'menu_id' => 'menu') ); ?>
            </nav>
        </div>
    </div><!--end nav_container-->
    </header><!-- #masthead -->
    <div id="content" class="site-content container">
<?php endif; //endif ?>
    <?php 
        
        if( !empty($_SESSION['change_pwd']) && isset($_SESSION['change_pwd'] ) ):
            echo '<div class="row">';
                echo '<div class="col-xs-12 col-md-6 login-section">';
                    echo '<p class="alert alert-success">'.$_SESSION['change_pwd'].'</p>';
                echo '</div>';
            echo '</div>';
            unset($_SESSION['change_pwd']);   
        endif; //endif 
        
        
        $attributes['login'] = isset( $_REQUEST['login'] ) && $_REQUEST['login'] == 'invalidkey';
        $attributes['expiredkey'] = isset( $_REQUEST['login'] ) && $_REQUEST['login'] == 'expiredkey';
        
        if( !empty($attributes['login']) ):
            echo '<div class="row">';
                echo '<div class="col-xs-12 col-md-6 login-section">';
                    echo '<p class="alert alert-warning">Reset Key is not valid</p>';
                echo '</div>';
            echo '</div>';
            unset($_GET['login']);   
        endif; //endif
        
        if( !empty($attributes['expiredkey']) ):
            echo '<div class="row">';
                echo '<div class="col-xs-12 col-md-6 login-section">';
                    echo '<p class="alert alert-warning">Reset Key is expired</p>';
                echo '</div>';
            echo '</div>';
            unset($_GET['login']);   
        endif; //endif
        ?>
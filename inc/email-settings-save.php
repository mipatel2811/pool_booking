<?php 

add_action( 'wp_ajax_save_email_settings', 'wp_funzone_save_email_settings_callback' );
add_action( 'wp_ajax_nopriv_save_email_settings', 'wp_funzone_save_email_settings_callback' );

function wp_funzone_save_email_settings_callback(){
    
    
    $success_flag = "success";
    if(isset($_POST['welcome_email_content'] ) && $_POST['welcome_email_content'] != ""){
        update_option( 'welcome_email_content', $_POST['welcome_email_content'] );
    }
    

    $message = "Settings saved!";
    session_start();

    $_SESSION['message'] = $message;
    $_SESSION['flag'] = $success_flag;

    $url = admin_url( 'admin.php?page=email-page');
    wp_redirect( $url );
    exit;

}

?>
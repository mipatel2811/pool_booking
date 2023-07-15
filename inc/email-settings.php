<?php 

function email_settings_menu() {
    add_menu_page(
        __( 'Email Options', 'my-textdomain' ),
        __( 'Email Options', 'my-textdomain' ),
        'manage_options',
        'email-page',
        'wp_funzone_email_contents',
        'dashicons-schedule',
        3
    );
}
add_action( 'admin_menu', 'email_settings_menu' );



//session_start();

function wp_funzone_email_contents() {

    $welcome_email_content = get_option('welcome_email_content');
    ?>
    <h1> <?php esc_html_e( 'Email Options.', 'my-plugin-textdomain' ); ?> </h1>

    <form method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>" class="pool_setting_form">
        <input type="hidden" name="action" value="save_email_settings">
        <div class="section">
            
            <h3>Welcome Email</h3>
            <div class="email_container" style="width:60%;">
            <?php  
               echo wp_editor( $welcome_email_content, 'uspartnersdesc', array('textarea_name' => 'welcome_email_content')  ); 
               //echo wp_editor( $welcome_email_content, 'welcome_email_content', array() ); 
            ?>
            </div>
        </div>
        <?php submit_button( __( 'Update', get_theme_domain()) ); ?>
        
    </form>
    <?php
}

?>
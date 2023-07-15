<?php 

add_action( 'wp_ajax_save_pool_settings', 'wp_funzone_save_pool_settings_callback' );
add_action( 'wp_ajax_nopriv_save_pool_settings', 'wp_funzone_save_pool_settings_callback' );

function wp_funzone_save_pool_settings_callback(){
    
    $success_flag = "success";
        
        $timing = array();
        $index = 0;
        foreach($_POST['start_pool_time'] as $time){
            $temp = array();
            $temp['start_hour'] = $time[0];
            $temp['start_min'] = "00";
            $temp['start_time'] = "AM";
            $temp['end_hour'] = "01";
            $temp['end_min'] = "00";
            $temp['end_time'] = "AM";
            
            if(isset($_POST['start_pool_time_minutes'][$index])){
                if(sizeof($_POST['start_pool_time_minutes'][$index]) > 0){
                    $temp['start_min'] = $_POST['start_pool_time_minutes'][$index][0];
                }
            }
            
            if(isset($_POST['start_pool_time_ampm'][$index])){
                if(sizeof($_POST['start_pool_time_ampm'][$index]) > 0){
                    $temp['start_time'] = $_POST['start_pool_time_ampm'][$index][0];
                }
            }
            
            if(isset($_POST['end_pool_time'][$index])){
                if(sizeof($_POST['end_pool_time'][$index]) > 0){
                    $temp['end_hour'] = $_POST['end_pool_time'][$index][0];
                }
            }
            
            
            if(isset($_POST['end_pool_time_minutes'][$index])){
                if(sizeof($_POST['end_pool_time_minutes'][$index]) > 0){
                    $temp['end_min'] = $_POST['end_pool_time_minutes'][$index][0];
                }
            }
            
            
            if(isset($_POST['end_pool_time_ampm'][$index])){
                if(sizeof($_POST['end_pool_time_ampm'][$index]) > 0){
                    $temp['end_time'] = $_POST['end_pool_time_ampm'][$index][0];
                }
            }
            
            $timing[] = $temp;
            
            $index++;
            
        }
        
              
        $zone = array();
        $loop = 0;
        foreach($_POST['zone_name'] as $time){
            $temp = array();
            $temp['zone_name'] = $time[0];
            $temp['setting_capacity'] = "2";
            $temp['zone_status'] = "active";
            
            if(isset($_POST['setting_capacity'][$loop])){
                if(sizeof($_POST['setting_capacity'][$loop]) > 0){
                    $temp['setting_capacity'] = $_POST['setting_capacity'][$loop][0];
                }
            }
            
            if(isset($_POST['zone_status'][$loop])){
                if(sizeof($_POST['zone_status'][$loop]) > 0){
                    $temp['zone_status'] = $_POST['zone_status'][$loop][0];
                }
            }
           
            $zone[] = $temp;    
            $loop++;
            
        }
        
        $option = array(
            'max_number_of_person' => !empty($_POST['max_number_of_person'])  ? $_POST['max_number_of_person'] : '',
            'pool_image' => !empty($_POST['pool_image'])  ? $_POST['pool_image'] : '',
            '2_seat' => !empty($_POST['2_row'])  ? $_POST['2_row'] : '',
            '3_seat' => !empty($_POST['3_row'])  ? $_POST['3_row'] : '',
            '4_seat' => !empty($_POST['4_row'])  ? $_POST['4_row'] : '',
            '5_seat' => !empty($_POST['5_row'])  ? $_POST['5_row'] : '',
            '6_seat' => !empty($_POST['6_row'])  ? $_POST['6_row'] : '',
            'holidays' => !empty($_POST['holidays'])  ? $_POST['holidays'] : '',
            'slot'   => $timing, 
            'zone'   => $zone,
            'pool_pdf'   => !empty($_POST['pool_pdf'])  ? $_POST['pool_pdf'] : '',
            'pool_maintanance'  => !empty($_POST['pool_maintanance'])  ? $_POST['pool_maintanance'] : 'no',
            
        );
        
        
        foreach ($option as $key => $value):
            update_option( $key, $value );
        endforeach; //end foreach

    $message = "Settings saved!";
    session_start();

    $_SESSION['message'] = $message;
    $_SESSION['flag'] = $success_flag;

    $url = admin_url( 'admin.php?page=pool-page');
    wp_redirect( $url );
    exit;

}

?>
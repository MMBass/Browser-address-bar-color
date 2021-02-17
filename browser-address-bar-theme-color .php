<?php

/**
 * @package Browser Address Bar Theme Color 
*/
/*
Plugin Name:Browser Address Bar Theme Color 
Plugin URI: https://github.com/MMBass/theme_color_plugin_for_wordpress
Description: Custom URL bar color for every page of your site, Works only on mobile browser
Author: Mendi Bass
Author URI: https://github.com/MMBass
Version: 0.0.1
License: GPL v2 or later
Text Domain: browser-address-bar-theme-color 
Domain Path: /languages
*/

if ( !defined( 'ABSPATH' ) ){
    die;
} 

function onActivateTc(){
    if(!get_option('tc_pages_list')){
        // add a new option - '$new_tc_pages_list' by default on plugin's start;
        add_option('tc_pages_list', $new_tc_pages_list);
    }
}
register_activation_hook( __FILE__, 'onActivateTc' );

add_action("admin_menu", "addMenu");

$pluginLocation = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$pluginLocation", 'linkToSettingsPage' );

function addMenu(){
    add_menu_page("Theme Color", "Theme Color", 'manage_options', "tc_options", "themeColorSettingsPage",'dashicons-color-picker');
}


function linkToSettingsPage($links) { 
    $settings_link = '<a href="options-general.php?page=tc_options">Settings</a>'; 
    array_unshift($links, $settings_link);
    return $links; 
}

function themeColorSettingsPage(){
    $new_tc_pages_list = array();
    $curr_pages_arr = get_option('tc_pages_list');

    wp_enqueue_script( 'tc-script', plugins_url('tc-script.js', __FILE__ ));
    wp_enqueue_style( 'Roboto', 'https://fonts.googleapis.com/css?family=Roboto&display=swap');

    if(isset($_POST['color-posted'])){

        $colors_pattern = "(#([\da-f]{3}){1,2}|(rgb|hsl)a\((\d{1,3}%?,\s?){3}(1|0?\.\d+)\)|(rgb|hsl)\(\d{1,3}%?(,\s?\d{1,3}%?){2}\))";
   
        if (isset($_POST['input-color-all']) && isset($_POST['check-color-all'])) {
          $all_color = sanitize_text_field($_POST['input-color-all']);
          if( preg_match($colors_pattern, $all_color) === 1){
            $new_tc_pages_list = array("all" => $all_color);
            update_option('tc_pages_list',$new_tc_pages_list );
          }// regex check valid color pattern
         }// set the same color for all pages
         elseif (!isset($_POST['check-color-all'])){
            unset($new_tc_pages_list["all"]);
           // here loop over the post array;
           foreach($_POST as $key => $value){
             if (strpos($key, 'input-color-') !== false){
                $color_from_input = sanitize_text_field($value);
                if( preg_match($colors_pattern, $color_from_input) === 1){
                    $page_id = str_replace( "input-color-" , "" , sanitize_text_field($key));
                    if(isset($_POST['check-color-'.$page_id])){
                        $new_tc_pages_list[$page_id] = $color_from_input;
                    }
                }// regex check valid color pattern
             }
           }
           update_option('tc_pages_list',$new_tc_pages_list);
         };// check and set for specific pages 
    }

    require_once("tc-settings-page.php");

}

function head_add(){
    if(get_option('tc_pages_list')){

        $tc_pages_list = get_option('tc_pages_list');
        if (array_key_exists("all",$tc_pages_list )){
            if(!empty($tc_pages_list["all"])){
                ?>
                <!-- Chrome, Firefox OS and Opera -->
                <meta name="theme-color" content="<?php echo $tc_pages_list["all"]; ?>">
                <!-- Windows Phone -->
                <meta name="msapplication-navbutton-color" content="<?php echo $tc_pages_list["all"]; ?>">
                <!-- iOS Safari -->
                <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $tc_pages_list["all"]; ?>">
                <meta name="theme-color" content="<?php echo $tc_pages_list["all"]; ?>">
                <?php
            }
            
        }else{
            foreach ($tc_pages_list as $page => $color) {
                if (is_page($page)){
                    ?>
                    <!-- Chrome, Firefox OS and Opera -->
                    <meta name="theme-color" content="<?php echo $color; ?>">
                    <!-- Windows Phone -->
                    <meta name="msapplication-navbutton-color" content="<?php echo $color; ?>">
                    <!-- iOS Safari -->
                    <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $color; ?>">
                    <meta name="theme-color" content="<?php echo $color; ?>">
                    <?php
                };
            } //loop over $tc_pages_list, check every page, and call by color;
        }

        
    }
    
};

if(get_option('tc_pages_list')){
   add_action('wp_head','head_add' );
}


?>
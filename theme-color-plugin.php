<?php

// todo : finish the top
// todo add uninstall to delete the option from DB
// todo option to chose spesific page!!! important
// toto design the settings page; 
//todo alert change saved;

/**
 * @package Theme Color 
*/
/*
Plugin Name: Theme Color 
Plugin URI: 
Description: 
Author:
Version: 0.1
License: GPLv2 or later
*/

if ( !defined( 'ABSPATH' ) )
    exit;

add_action("admin_menu", "addMenu");

function addMenu(){
    add_menu_page("Theme Color", "Theme Color", 5, "tc_options", "themeColorPage",'dashicons-color-picker');
}

function linkToSettingsPage($links) { 
    $settings_link = '<a href="options-general.php?page=tc_options">Settings</a>'; 
    array_unshift($links, $settings_link);
    return $links; 
  }
$pluginLocation = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$pluginLocation", 'linkToSettingsPage' );

function head_add(){
    ?>
        <!-- Chrome, Firefox OS and Opera -->
        <meta name="theme-color" content="<?php echo get_option('theme_meta_color'); ?>">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="<?php echo get_option('theme_meta_color'); ?>">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="<?php echo get_option('theme_meta_color'); ?>"> -->
        <meta name="theme-color" content="<?php echo get_option('theme_meta_color'); ?>">
    <?php
};

function themeColorPage(){
    if(!get_option('theme_meta_color')){
         // add a new option
        add_option('theme_meta_color', '#ffffff');
    }
    
    if (isset($_POST['input-color']) ) {
        update_option( 'theme_meta_color',  sanitize_text_field( $_POST['input-color'] ));// todo : regex to chek valid
        add_action('wp_head','head_add' );
    }

    ?>
      
       <div style="margin-right:10%; margin-top: 20px; width: 80%; background-color:#E2E2E2; text-align:center; align-items:center; font-family:Gill Sans,sans-serif; padding-top:10px; height: 80%; font-weight: 800;">
        <div style="color: #6E7274;">
            <h2 style="color: #6E7274; font-size: 35px;"> Theme Color - For Browsers</h2>
        </div>
        <div style="background-color:#075B9A; width: 100%; height: 60px; padding-top:1px; padding-bottom: 20px;">
           <h3  style="font-family:Gill Sans,sans-serif; font-size:30px; font-weight: 600; color:#60CAF6;">:Chose Your Color</h3>
        </div>
        <form style="" target="_self" method="POST">        
            <br>
            <input type="color" name="input-color" style="width:20%; padding: 2px 8px; height:40px; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="<?php echo get_option('theme_meta_color'); ?>">
            <br>
            <button id="save_color_btn" type="submit" style="margin-top:20px; background:#bbe1e7; font-family:Gill Sans,sans-serif; font-size:15px; color: #0C5460; border: none; padding: 15px 32px; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);">Save Changes</button>
        </form>
        <div style="background-color:#41535C; height:40px;  margin-top:20px;"></div>
        </div>
    <?php 
}

if(get_option('theme_meta_color') && get_option('theme_meta_color') != "#ffffff"){
   add_action('wp_head','head_add' );
}



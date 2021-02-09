<?php

// todo : finish the top (description)
// toto finish design the settings page; 

/**
 * @package Theme Color 
*/
/*
Plugin Name: Theme Color 
Plugin URI: 
Description: 
Author: Mendi Bass
Version: 1.0.0
License: GPLv2 or later
Text Domain: browser-theme-color
*/

if ( !defined( 'ABSPATH' ) ){
    die;
}

define('WP_DEBUG', true);

function onActivateTc(){
    delete_option('tc_pages_list');
}
register_activation_hook(__FILE__,'onActivateTc');

//TODO deactivae function-
function onDeactivateTc(){

}
register_deactivation_hook(__FILE__,'onDeactivateTc');

add_action("admin_menu", "addMenu");

function addMenu(){
    add_menu_page("Theme Color", "Theme Color", 5, "tc_options", "themeColorSettingsPage",'dashicons-color-picker');
}

function linkToSettingsPage($links) { 
    $settings_link = '<a href="options-general.php?page=tc_options">Settings</a>'; 
    array_unshift($links, $settings_link);
    return $links; 
}

$pluginLocation = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$pluginLocation", 'linkToSettingsPage' );

function themeColorSettingsPage(){
    // add_action('wp_head','head_add');
    $new_tc_pages_list = array();
    $curr_pages_arr = get_option('tc_pages_list');
    // todo take first all the pages and check what already checkd, and keep the data , so when clicking "ALL",
    // all the checks and the colors fits to all, when canceling - back to original color...!!!

    if(!get_option('tc_pages_list')){
        // add a new option - '$new_tc_pages_list' by default on plugin start;
        add_option('tc_pages_list', $new_tc_pages_list);
    }

    if(isset($_POST['color-posted'])){
        if (isset($_POST['input-color-all']) && isset($_POST['check-color-all'])) {
            // todo : regex to chek valid color?
            $new_tc_pages_list = array("all" => sanitize_text_field( $_POST['input-color-all']));
             update_option('tc_pages_list',$new_tc_pages_list );
         }// set the same color for all pages
         elseif (!isset($_POST['check-color-all'])){
            unset($new_tc_pages_list["all"]);
           // here loop over the post array;
           foreach($_POST as $key => $value){
             if (strpos($key, 'input-color-') !== false){
                $page_id = str_replace( "input-color-" , "" , sanitize_text_field($key) );
            
                if(isset($_POST['check-color-'.$page_id])){
                    $new_tc_pages_list[$page_id] = $value;
                }
             }
           }
           update_option('tc_pages_list',$new_tc_pages_list);
         };// check and set for specific pages 
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
           <input type="hidden" name="color-posted">    
            <br>
            <br>
            <p>:Select The Page You Wnat To Effect</p>
            <div id="pages_div">
              <div style="background-color: #fff; padding: 4px; direction: ltr; margin-top: 5px; height:40px;">
                <div style="float: left;">
                    <input type="checkbox" id="cbox_all" name="check-color-all" style=" margin-top: 5px;" <?php echo isset(get_option('tc_pages_list')["all"]) ? "checked" : null; ?>>
                    <p style="color: blue; bckground-color: gray; display: inline; margin: 22px;">All:</p>
                </div> 
               <input type="color" id="input_all" name="input-color-all" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="<?php echo get_option('tc_pages_list')["all"];?>"> 
               <input type="text" id="txt-cover-inp-all" style="width:50%; padding: 2px 8px; height:35px; float: right; display:none;" value="Not Selected" disabled>
              </div>
              <?php 
                $allPages = get_pages(); 
                $curr_pages_arr = get_option('tc_pages_list');
                
                foreach ($allPages as $page ) {
                    if(array_key_exists($page->ID , $curr_pages_arr)){
                        $curr_checked = "checked";
                        $curr_color = $curr_pages_arr[$page->ID] ;
                    }else{
                       $curr_checked = "";
                       $curr_color = "#E3E3E3" ; //default color;
                    }
 
                    $option = '<div style="background-color: #fff; padding: 4px; direction: ltr; margin-top: 5px; height:40px;">';
                    
                        $option .= '<div style="float: left;">';
                            $option .= ' <input type="checkbox" id="" class="check-inputs" name="check-color-';
                            $option .= $page->ID;
                            $option .= '" style="display:inline-block; margin-top: 5px;" ';
                            $option .= $curr_checked;
                            $option .= '>';
                            $option .= '<input type="checkbox" class="check-cover-input" style="display: none; margin-top: 5px;" checked disabled>';
                            $option .= '<p style="color: blue; display: inline; margin: 22px;">';
                            $option .= $page->post_title;
                            $option .= ':</p>';
                        $option .= '</div>';
                    
                        $option .= '<input type="color" class="color-inputs" name="input-color-';
                        $option .= $page->ID;
                        $option .= '" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="';
                        $option .= $curr_color;
                        $option .= '">';
                        $option .= '<input type="text" class="txt-cover-input" style="display: none; width:50%; padding: 2px 8px; height:35px; float: right;" value="Not Selected" disabled> ';
                    

                    $option .= '</div>';
                    echo $option;
                }
                ?>
            </div>
            
            <br>
            <button id="save_color_btn" type="submit" style="margin-top:20px; background:#bbe1e7; font-family:Gill Sans,sans-serif; font-size:15px; color: #0C5460; border: none; padding: 15px 32px; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);">Save Changes</button>

        </form>

        <div style="background-color:#41535C; height:40px;  margin-top:20px;">
        </div>
        <script>
          //todo create elements already checked if exist in the array option, maybe by echo 'true' if exist in array;

          let color_inputs_list = document.getElementsByClassName("color-inputs");
          let check_inputs_list = document.getElementsByClassName("check-inputs");
          let txt_cover_input = document.getElementsByClassName("txt-cover-input");
          let check_cover_input = document.getElementsByClassName("check-cover-input");
          let inp_all = document.getElementById("input_all");
          let cbox_all = document.getElementById("cbox_all");
          let txt_inp_all = document.getElementById("txt-cover-inp-all");
          
          if(cbox_all.checked){
            all_inputs_cover();
            inp_all.style.display = "block";
            txt_inp_all.style.display = "none";
          }; // block all inputs if all selected or not, on page start
          if(!cbox_all.checked){
            all_inputs_cover();
            inp_all.style.display = "none";
            txt_inp_all.style.display = "block";
          }; // block all inputs if all selected or not, on page start

         function disable_unselected(){
            for(let i = 0; i < color_inputs_list.length; i++){
                if(!check_inputs_list[i].checked){
                    color_inputs_list[i].style.display = "none";
                    // check_inputs_list[i].style.display = "none";
                    // check_cover_input[i].style.display = "inline-block";
                    txt_cover_input[i].style.display = "block";
                }else if(check_inputs_list[i].checked){
                    color_inputs_list[i].style.display = "block";
                    check_inputs_list[i].style.display = "inline-block";
                    check_cover_input[i].style.display = "none";
                    txt_cover_input[i].style.display = "none";
                }
            }  
          }; // loop and disable on page start
          disable_unselected();

          cbox_all.addEventListener("click",()=>{
            inp_all.disabled = !cbox_all.checked;
              if(!cbox_all.checked){
                all_inputs_cover();
                inp_all.style.display = "none";
                txt_inp_all.style.display = "block";
              }else if(cbox_all.checked){
                all_inputs_cover();
                inp_all.style.display = "block";
                txt_inp_all.style.display = "none";
              }
          });

          function all_inputs_cover(){
            for(let i = 0; i < color_inputs_list.length; i++){
                if(cbox_all.checked){
                    color_inputs_list[i].style.display = "none";
                    check_inputs_list[i].style.display = "none";
                    check_cover_input[i].style.display = "inline-block";
                    txt_cover_input[i].style.display = "block";
                }
                if(!cbox_all.checked){
                    check_cover_input[i].style.display = "none";
                    check_inputs_list[i].style.display = "inline-block";

                    if(check_inputs_list[i].checked){
                      color_inputs_list[i].style.display = "block";
                      txt_cover_input[i].style.display = "none";
                    } // recover the color only if already selected
                }
            };
          }

          
          // Clicking one page:
          for(let i = 0; i < check_inputs_list.length; i++){
            check_inputs_list[i].addEventListener("click",()=>{
                if(!cbox_all.checked){
                    setTimeout(() => {
                      if(check_inputs_list[i].checked){
                        color_inputs_list[i].style.display = "block";
                        txt_cover_input[i].style.display = "none";
                      }
                      if(!check_inputs_list[i].checked){
                        color_inputs_list[i].style.display = "none";
                        txt_cover_input[i].style.display = "block";
                      }  
                    }, 1); // making this change async
                }
            });
          };

        </script>
    </div>
    <?php 
}

function head_add(){
    // todo important- delete from the unchecked pages!! 
    // probably every refresh - happen auto, make sure.
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
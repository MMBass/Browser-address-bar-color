<div id="babc_main_div" style="visibility:hidden; margin-right:10%;  margin-left: 10px; margin-top: 20px;">
        <div style="color: #6E7274; text-align:left;">
            <h2 style="margin-left: 10px; color: #6E7274; font-size: 35px; font-weight: 600; text-align:<?php echo (get_user_locale() == "he_IL") ? "right" : "left" ?>;"> <?php echo esc_html_e( 'Browser Address Bar Color', 'browser-address-bar-color' ) ?>
            </h2>
        </div>
        
        <form style="" target="_self"  method="POST">    
           <input type="hidden" name="color-posted">    
            <br>
           
            <div id="babc_pages_div">
              <div style="background-color: #fff; padding: 4px; direction: ltr; margin-top: 5px; height:40px;">
                <div style="float: left;">
                    <input type="checkbox" id="cbox_all" name="check-color-all" style=" " <?php echo isset(get_option('babc_pages_list')["all"]) ? "checked" : null; ?>>
                    <p style="color: #3e4347; display: inline; font-weight: 600;"> <?php echo esc_html_e( 'All pages and posts: ', 'browser-address-bar-color' ) ?> </p>
                </div> 
               <input type="color" id="input_all" name="input-color-all" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" <?php echo 'value="'.get_option('babc_pages_list')["all"].'"';?>> 
               <input type="text" id="txt-cover-inp-all" style="width:50%; padding: 2px 8px; height:35px; float: right; display:none;" value="Not Selected" disabled>
              </div>
    
              <?php 

                if(get_pages()[0]->ID){
                    echo'<hr style="width: 80%; font-weight: 600; color: #000; border-width: 2px;">
                    <h3>Pages:</h3>';
                }

                $babcAllPages = get_pages(); 
                $babc_curr_pages_arr = get_option('babc_pages_list');
             
                foreach ($babcAllPages as $page ) {
                    if(array_key_exists($page->ID , $babc_curr_pages_arr)){
                        $curr_checked = "checked";
                        $curr_color = $babc_curr_pages_arr[$page->ID];
                    }else{
                       $curr_checked = "";
                       $curr_color = "#E3E3E3" ; //default color;
                    }
 
                    $babc_option = '<div style="background-color: #fff; padding: 4px; padding-bottom: 0px; direction: ltr; margin-top: 5px; height:40px;">';
                    
                        $babc_option .= '<div style="float: left;">';
                            $babc_option .= ' <input type="checkbox" id="" class="check-inputs" name="check-color-';
                            $babc_option .= $page->ID;
                            $babc_option .= '" style="display:inline-block;" ';
                            $babc_option .= $curr_checked;
                            $babc_option .= '>';
                            $babc_option .= '<input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>';
                            $babc_option .= '<p style="color: #0970be; display: inline; font-weight: 600;">';
                            $babc_option .= $page->post_title;
                            $babc_option .= ':</p>';
                        $babc_option .= '</div>';
                
                        $babc_option .= '<input type="color" class="color-inputs" name="input-color-';
                        $babc_option .= $page->ID;
                        $babc_option .= '" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="';
                        $babc_option .= $curr_color;
                        $babc_option .= '">';
                        $babc_option .= '<input type="text" class="txt-cover-input" style="display: none; width:50%; padding: 2px 8px; height:35px; float: right;" value="Not Selected" disabled> ';
                    

                    $babc_option .= '</div>';
                    echo $babc_option;
                }
                ?>
               
                <?php
                 if(get_posts()[0]->ID){
                    echo'<hr style="width: 80%; font-weight: 600; color: #000; border-width: 2px;"> 
                    <h3>Posts:</h3>';
                 }
                $babcAllPosts = get_posts(); 
                $babc_curr_pages_arr = get_option('babc_pages_list');
                
                foreach ($babcAllPosts as $post) {
                    if(array_key_exists($post->ID , $babc_curr_pages_arr)){
                        $curr_checked = "checked";
                        $curr_color = $babc_curr_pages_arr[$post->ID];
                    }else{
                       $curr_checked = "";
                       $curr_color = "#E3E3E3" ; //default color;
                    }
 
                    $babc_option = '<div style="background-color: #fff; padding: 4px; padding-bottom: 0px; direction: ltr; margin-top: 5px; height:40px;">';
                    
                        $babc_option .= '<div style="float: left;">';
                            $babc_option .= ' <input type="checkbox" id="" class="check-inputs" name="check-color-';
                            $babc_option .= $post->ID;
                            $babc_option .= '" style="display:inline-block;" ';
                            $babc_option .= $curr_checked;
                            $babc_option .= '>';
                            $babc_option .= '<input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>';
                            $babc_option .= '<p style="color: #0970be; display: inline; font-weight: 600;">';
                            $babc_option .= $post->post_title;
                            $babc_option .= ':</p>';
                        $babc_option .= '</div>';
                
                        $babc_option .= '<input type="color" class="color-inputs" name="input-color-';
                        $babc_option .= $post->ID;
                        $babc_option .= '" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="';
                        $babc_option .= $curr_color;
                        $babc_option .= '">';
                        $babc_option .= '<input type="text" class="txt-cover-input" style="display: none; width:50%; padding: 2px 8px; height:35px; float: right;" value="Not Selected" disabled> ';
                    

                    $babc_option .= '</div>';
                    echo $babc_option;
                }
                ?>
            </div>
            
            <br>
            <?php  echo submit_button() ?> 

        </form>

    </div>
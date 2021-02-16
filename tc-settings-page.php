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
                    <input type="checkbox" id="cbox_all" name="check-color-all" style=" " <?php echo isset(get_option('tc_pages_list')["all"]) ? "checked" : null; ?>>
                    <p style="color: #3e4347; display: inline; margin: 22px; font-size: 22px">All Pages:</p>
                </div> 
               <input type="color" id="input_all" name="input-color-all" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="<?php echo get_option('tc_pages_list')["all"];?>"> 
               <input type="text" id="txt-cover-inp-all" style="width:50%; padding: 2px 8px; height:35px; float: right; display:none;" value="Not Selected" disabled>
              </div>
              <hr style="width: 80%;">

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
                            $option .= '" style="display:inline-block;" ';
                            $option .= $curr_checked;
                            $option .= '>';
                            $option .= '<input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>';
                            $option .= '<p style="color: #0970be; display: inline; margin: 22px; font-size: 20px">';
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

        <div style="background-color:#41535C; height:40px; margin-top:20px;">
        </div>
        <script src="../wp-content/plugins/theme-color-plugin/tc-script.js"></script>
    </div>
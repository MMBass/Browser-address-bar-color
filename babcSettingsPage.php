<div style="margin-right:10%; margin-top: 20px; width: 80%; background-color:#E2E2E2; text-align:center; align-items:center; font-family:Gill Sans,sans-serif; padding-top:10px; height: 80%; font-weight: 600; font-family: roboto">

        <div style="color: #6E7274; text-align:left;">
            <h2 style="margin-left: 10px; color: #6E7274; font-size: 35px; font-family:roboto; font-weight: 400;">Browser Address Bar Color </h2>
        </div>

        <div style="background-color:#075B9A; width: 100%; padding-top:1px; padding-bottom: 20px; font-size: 20px;">
           <h3 style="font-family:roboto; font-weight: 400; color:#60CAF6;">Choose your colors</h3>
           <p style="color:#ffffff; font-size: 20px; line-height: 0;">Select the pages that you'd like to add a color to:</p>
        </div>
        
        <form style="" target="_self"  method="POST">    
           <input type="hidden" name="color-posted">    
            <br>
           
            <div id="babc_pages_div">
              <div style="background-color: #fff; padding: 4px; direction: ltr; margin-top: 5px; height:40px;">
                <div style="float: left;">
                    <input type="checkbox" id="cbox_all" name="check-color-all" style=" " <?php echo isset(get_option('babc_pages_list')["all"]) ? "checked" : null; ?>>
                    <p style="color: #3e4347; display: inline; margin: 22px; font-size: 20px">All Pages:</p>
                </div> 
               <input type="color" id="input_all" name="input-color-all" style="width:50%; padding: 2px 8px; height:35px; float: right; box-shadow: 0px 0px 13px rgba(0, 0, 0, 0.1);" value="<?php echo get_option('babc_pages_list')["all"];?>"> 
               <input type="text" id="txt-cover-inp-all" style="width:50%; padding: 2px 8px; height:35px; float: right; display:none;" value="Not Selected" disabled>
              </div>
              <hr style="width: 80%; color: #075B9A">

              <?php 
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
 
                    $babc_option = '<div style="background-color: #fff; padding: 4px; direction: ltr; margin-top: 5px; height:40px;">';
                    
                        $babc_option .= '<div style="float: left;">';
                            $babc_option .= ' <input type="checkbox" id="" class="check-inputs" name="check-color-';
                            $babc_option .= $page->ID;
                            $babc_option .= '" style="display:inline-block;" ';
                            $babc_option .= $curr_checked;
                            $babc_option .= '>';
                            $babc_option .= '<input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>';
                            $babc_option .= '<p style="color: #0970be; display: inline; margin: 22px; font-size: 18px">';
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
            </div>
            
            <br>
            <?php  echo submit_button() ?> 

        </form>

        <div style="background-color:#41535C; height:40px; margin-top:20px;">
        </div>
    </div>
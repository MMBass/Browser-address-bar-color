<div id="babc_main_div" class="wrap">
    <h1 class="babc-settings-h1"><?php echo esc_html_e('Browser Address Bar Color', 'browser-address-bar-color') ?></h1>
    
    <form method="POST">   
        <?php wp_nonce_field('babc_settings_nonce', 'babc_settings_nonce'); ?>

        <input type="hidden" name="color-posted">
        
        <?php submit_button(); ?> 
        
        <div id="babc_pages_div" class="babc-container">
            <!-- All pages and posts selector -->
            <div class="babc-option-row babc-all-pages">
                <label class="babc-checkbox-label">
                    <input type="checkbox" id="cbox_all" name="check-color-all" <?php echo isset(get_option('babc_pages_list')["all"]) ? "checked" : null; ?>>
                    <span class="babc-label-text"><?php echo esc_html_e('All pages and posts', 'browser-address-bar-color') ?></span>
                </label>
                <?php
                $babc_curr_pages_arr = get_option('babc_pages_list');
                if(is_array($babc_curr_pages_arr)){
                    if(array_key_exists("all", $babc_curr_pages_arr)){
                        $curr_checked = "checked";
                        $curr_color = $babc_curr_pages_arr["all"];
                    } else {
                        $curr_checked = " ";
                        $curr_color = "#E3E3E3"; //default color;
                    }
                } else {
                    $curr_checked = " ";
                    $curr_color = " ";
                }
                ?>
                <input type="color" id="input_all" name="input-color-all" class="babc-color-picker" value="<?php echo esc_attr($curr_color); ?>">
                <input type="text" id="txt-cover-inp-all" class="babc-color-text-disabled" value="Not Selected" disabled>
            </div>
            
            <?php if(get_pages()[0]->ID): ?>
                <div class="babc-section">
                    <div class="babc-section-header">
                        <h2><?php echo esc_html_e('Pages', 'browser-address-bar-color') ?></h2>
                        <input type="text" id="search_page_inp" class="babc-search" placeholder="<?php echo esc_attr_e('Search page...', 'browser-address-bar-color') ?>">
                    </div>
                    
                    <div class="babc-items-container">
                        <?php 
                        $babcAllPages = get_pages(); 
                        $babc_curr_pages_arr = get_option('babc_pages_list');

                        // Find and attach slug to pages that have the same name
                        $babac_names_array = array();
                        foreach ($babcAllPages as $page) {
                            array_push($babac_names_array, $page->post_title);
                        }
                        $babc_times = array_count_values($babac_names_array);
                        foreach ($babcAllPages as $page) {
                            if($babc_times[$page->post_title] > 1){
                                $page->need_post_name = $page->post_name;
                            }
                        }
                        
                        foreach ($babcAllPages as $page): 
                            if(is_array($babc_curr_pages_arr)){
                                if(array_key_exists($page->ID, $babc_curr_pages_arr)){
                                    $curr_checked = "checked";
                                    $curr_color = esc_attr($babc_curr_pages_arr[$page->ID]);
                                } else {
                                    $curr_checked = "";
                                    $curr_color = "#E3E3E3"; //default color;
                                }
                            } else {
                                $curr_checked = "";
                                $curr_color = "";
                            }
                        ?>
                            <div class="babc-item item_ge" data-sename="<?php echo esc_attr($page->post_title); ?>">
                                <label class="babc-checkbox-label">
                                    <input type="checkbox" class="check-inputs" name="check-color-<?php echo esc_attr($page->ID); ?>" <?php echo esc_attr($curr_checked); ?>>
                                    <input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>
                                    <span class="babc-label-text"><?php echo esc_html($page->post_title); ?>
                                        <?php if(isset($page->need_post_name)): ?>
                                            <span class="babc-slug">(<?php echo esc_html($page->need_post_name); ?>)</span>
                                        <?php endif; ?>
                                    </span>
                                </label>
                                <input type="color" class="color-inputs babc-color-picker" 
                                    name="input-color-<?php echo esc_attr($page->ID); ?>" 
                                    value="<?php echo esc_attr($curr_color); ?>">
                                <input type="text" class="txt-cover-input babc-color-text-disabled" value="Not Selected" disabled>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(get_posts() && get_posts()[0]->ID): ?>
                <div class="babc-section">
                    <div class="babc-section-header">
                        <h2><?php echo esc_html_e('Posts', 'browser-address-bar-color') ?></h2>
                        <input type="text" id="search_post_inp" class="babc-search" placeholder="<?php echo esc_attr_e('Search post...', 'browser-address-bar-color') ?>">
                    </div>
                    
                    <div class="babc-items-container">
                        <?php 
                        $babcAllPosts = get_posts();
                        $babc_curr_pages_arr = get_option('babc_pages_list');

                        // Find and attach slug to posts that have the same name
                        $babac_names_array = array();
                        foreach ($babcAllPosts as $post) {
                            array_push($babac_names_array, $post->post_title);
                        }
                        $babc_times = array_count_values($babac_names_array);
                        foreach ($babcAllPosts as $post) {
                            if($babc_times[$post->post_title] > 1){
                                $post->need_post_name = $post->post_name;
                            }
                        }
                        
                        foreach ($babcAllPosts as $post): 
                            if(is_array($babc_curr_pages_arr)){
                                if(array_key_exists($post->ID, $babc_curr_pages_arr)){
                                    $curr_checked = "checked";
                                    $curr_color = esc_attr($babc_curr_pages_arr[$post->ID]);
                                } else {
                                    $curr_checked = "";
                                    $curr_color = "#E3E3E3"; //default color;
                                }
                            } else {
                                $curr_checked = "";
                                $curr_color = "";
                            }
                        ?>
                            <div class="babc-item item_st" data-sename="<?php echo esc_attr($post->post_title); ?>">
                                <label class="babc-checkbox-label">
                                    <input type="checkbox" class="check-inputs" name="check-color-<?php echo esc_attr($post->ID); ?>" <?php echo esc_attr($curr_checked); ?>>
                                    <input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>
                                    <span class="babc-label-text"><?php echo esc_html($post->post_title); ?>
                                        <?php if(isset($post->need_post_name)): ?>
                                            <span class="babc-slug">(<?php echo esc_html($post->need_post_name); ?>)</span>
                                        <?php endif; ?>
                                    </span>
                                </label>
                                <input type="color" class="color-inputs babc-color-picker" 
                                    name="input-color-<?php echo esc_attr($post->ID); ?>" 
                                    value="<?php echo esc_attr($curr_color); ?>">
                                <input type="text" class="txt-cover-input babc-color-text-disabled" value="Not Selected" disabled>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php submit_button(); ?> 
    </form>

    <style>

        .babc-settings-h1 {
          max-width: 1150px;
          padding: 25px !important;
          background: #2271b138;
        }

        .babc-container {
            max-width: 1200px;
            margin-top: 20px;
        }
        
        .babc-option-row {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 15px;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
            border: 1px solid #ccd0d4;
            margin-bottom: 15px;
        }
        
        .babc-all-pages {
            background-color: #f9f9f9;
            border-left: 4px solid #2271b1;
        }
        
        .babc-checkbox-label {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .babc-label-text {
            margin-left: 8px;
            font-size: 14px;
            color: #3c434a;
            font-weight: 600;
        }
        
        .babc-slug {
            font-style: italic;
            color: #646970;
            font-weight: normal;
            font-size: 13px;
            margin-left: 5px;
        }
        
        .babc-color-picker {
            width: 400px;
            height: 30px;
            padding: 2px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            box-shadow: none;
        }
        
        .babc-color-text-disabled {
            display: none;
            width: 100px;
            height: 30px;
            margin-left: 10px;
        }
        
        .babc-section {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        
        .babc-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #dcdcde;
        }
        
        .babc-section-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #1d2327;
        }
        
        .babc-search {
            padding: 5px 10px;
            font-size: 13px;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            width: 200px;
        }
        
        .babc-items-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #dcdcde;
            background: #fff;
            border-radius: 3px;
        }
        
        .babc-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f1;
            transition: background 0.1s ease-in-out;
        }
        
        .babc-item:last-child {
            border-bottom: none;
        }
        
        .babc-item:hover {
            background-color: #f6f7f7;
        }
        
        /* WP admin styles matching */
        input[type="checkbox"] {
            border: 1px solid #8c8f94;
            border-radius: 4px;
            box-shadow: none;
            width: 16px;
            height: 16px;
        }
        
        .submit {
            padding: 0;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        // Search functionality for pages
        $("#search_page_inp").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".item_ge").filter(function() {
                $(this).toggle($(this).data("sename").toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Search functionality for posts
        $("#search_post_inp").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".item_st").filter(function() {
                $(this).toggle($(this).data("sename").toLowerCase().indexOf(value) > -1);
            });
        });
        
        // Toggle color picker visibility based on checkbox
        $(".check-inputs").on("change", function() {
            if($(this).is(":checked")) {
                $(this).closest(".babc-item, .babc-option-row").find(".babc-color-picker").show();
                $(this).closest(".babc-item, .babc-option-row").find(".babc-color-text-disabled").hide();
            } else {
                $(this).closest(".babc-item, .babc-option-row").find(".babc-color-picker").hide();
                $(this).closest(".babc-item, .babc-option-row").find(".babc-color-text-disabled").show();
            }
        });
        
        // Initialize color picker visibility
        $(".check-inputs").each(function() {
            if(!$(this).is(":checked")) {
                $(this).closest(".babc-item, .babc-option-row").find(".babc-color-picker").hide();
                $(this).closest(".babc-item, .babc-option-row").find(".babc-color-text-disabled").show();
            }
        });
    });
    </script>
</div>
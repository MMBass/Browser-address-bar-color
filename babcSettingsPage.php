<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div id="babc_main_div" class="wrap">
    <h1 class="babc-settings-h1"><?php esc_html_e('Browser Address Bar Color', 'browser-address-bar-color'); ?></h1>
    
    <form method="POST">   
        <?php wp_nonce_field('babc_settings_nonce', 'babc_settings_nonce'); ?>

        <input type="hidden" name="color-posted">
        
        <?php submit_button(); ?> 
        
        <div id="babc_pages_div" class="babc-container">
            <!-- All pages and posts selector -->
            <div class="babc-option-row babc-all-pages">
                <?php $babc_curr_pages_arr = get_option('babc_pages_list'); ?>
                <label class="babc-checkbox-label">
                    <input type="checkbox" id="cbox_all" name="check-color-all" <?php echo (is_array($babc_curr_pages_arr) && isset($babc_curr_pages_arr["all"])) ? "checked" : ""; ?>>
                    <span class="babc-label-text"><?php esc_html_e('All pages and posts', 'browser-address-bar-color'); ?></span>
                </label>
                <?php

                if(is_array($babc_curr_pages_arr)){
                    if(array_key_exists("all", $babc_curr_pages_arr)){
                        $babc_curr_checked = "checked";
                        $babc_curr_color = $babc_curr_pages_arr["all"];
                    } else {
                        $babc_curr_checked = " ";
                        $babc_curr_color = "#E3E3E3"; //default color;
                    }
                } else {
                    $babc_curr_checked = " ";
                    $babc_curr_color = " ";
                }
                ?>
                <input type="color" id="input_all" name="input-color-all" class="babc-color-picker" value="<?php echo esc_attr($babc_curr_color); ?>">
                <input type="text" id="txt-cover-inp-all" name="color-placeholder-all" class="babc-color-text-disabled" value="<?php echo esc_attr__('Not Selected', 'browser-address-bar-color'); ?>" disabled>
            </div>
            
            <div class="babc-columns-wrapper">
            <?php 
            global $wpdb;
            // Get all public post types (Pages, Posts, Products, etc.)
            $babc_post_types = get_post_types(array('public' => true), 'objects');
            
            foreach ($babc_post_types as $babc_post_type_obj):
                $babc_pt_name = $babc_post_type_obj->name;
                $babc_pt_label = $babc_post_type_obj->label;
                
                // Skip attachments (media files)
                if($babc_pt_name === 'attachment') continue;

                // Caching: Check if we have this list in cache
                $babc_cache_key = 'babc_items_' . $babc_pt_name;
                $babc_items = wp_cache_get($babc_cache_key, 'browser_address_bar_color');

                if ( false === $babc_items ) {
                    // OPTIMIZATION: Use $wpdb to get ONLY ID and Title (Lightweight) instead of full get_posts()
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
                    $babc_items = $wpdb->get_results( $wpdb->prepare( 
                        "SELECT ID, post_title, post_name, post_type FROM {$wpdb->posts} 
                        WHERE post_type = %s 
                        AND post_status = 'publish' 
                        ORDER BY post_title ASC", $babc_pt_name ) );
                    
                    wp_cache_set($babc_cache_key, $babc_items, 'browser_address_bar_color', HOUR_IN_SECONDS);
                }

                // If no items found for this type, skip rendering the section
                if(empty($babc_items)) continue;
            ?>
                <div class="babc-section">
                    <div class="babc-section-header">
                        <h2><?php echo esc_html($babc_pt_label); ?></h2>
                        <!-- todo: A form field element should have an id or name attribute -->
                        <input type="text" class="babc-search-input babc-search" placeholder="<?php echo esc_attr__('Filter...', 'browser-address-bar-color'); ?>">
                    </div>
                    
                    <div class="babc-items-container">
                        <?php 

                        // Find and attach slug to items that have the same name (for display clarity)
                        $babc_names_array = array();
                        foreach ($babc_items as $babc_item) {
                            array_push($babc_names_array, $babc_item->post_title);
                        }
                        $babc_times = array_count_values($babc_names_array);
                        foreach ($babc_items as $babc_item) {
                            if(isset($babc_times[$babc_item->post_title]) && $babc_times[$babc_item->post_title] > 1){
                                $babc_item->need_post_name = $babc_item->post_name;
                            }
                        }
                        
                        foreach ($babc_items as $babc_item): 
                            if(is_array($babc_curr_pages_arr)){
                                if(array_key_exists($babc_item->ID, $babc_curr_pages_arr)){
                                    $babc_curr_checked = "checked";
                                    $babc_curr_color = esc_attr($babc_curr_pages_arr[$babc_item->ID]);
                                } else {
                                    $babc_curr_checked = "";
                                    $babc_curr_color = "#E3E3E3"; //default color;
                                }
                            } else {
                                $babc_curr_checked = "";
                                $babc_curr_color = "";
                            }
                        ?>
                            <div class="babc-item" data-sename="<?php echo esc_attr($babc_item->post_title); ?>">
                                <label class="babc-checkbox-label">
                                    <input type="checkbox" class="check-inputs" name="check-color-<?php echo esc_attr($babc_item->ID); ?>" <?php echo esc_attr($babc_curr_checked); ?>>
                                    <input type="checkbox" class="check-cover-input" style="display: none;" checked disabled>
                                    <span class="babc-label-text"><?php echo esc_html($babc_item->post_title); ?>
                                        <?php if(isset($babc_item->need_post_name)): ?>
                                            <span class="babc-slug">(<?php echo esc_html($babc_item->need_post_name); ?>)</span>
                                        <?php endif; ?>
                                    </span>
                                </label>
                                <input type="color" class="color-inputs babc-color-picker" 
                                    name="input-color-<?php echo esc_attr($babc_item->ID); ?>" 
                                    value="<?php echo esc_attr($babc_curr_color); ?>">
                                <input type="text" class="txt-cover-input babc-color-text-disabled" name="color-placeholder-<?php echo esc_attr($babc_item->ID); ?>" value="<?php echo esc_attr__('Not Selected', 'browser-address-bar-color'); ?>" disabled>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
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
        
        .babc-columns-wrapper {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .babc-checkbox-label {
            display: flex;
            align-items: center;
            flex: 1;
        }
        
        .babc-label-text {
            margin-inline-start: 8px;
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
            width: 200px;
            height: 30px;
            padding: 2px;
            border: 1px solid #8c8f94;
            border-radius: 4px;
            box-shadow: none;
            display: none;
        }
        
        .babc-color-text-disabled {
            display: none;
            width: 100px;
            height: 30px;
            margin-left: 10px;
            font-size: 10px;
        }
        
        .babc-section {
            flex: 1;
            min-width: 300px;
            margin-bottom: 20px;
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
            padding: 5px 10px 5px 30px;
            font-size: 13px;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            width: 200px;
            background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22%238c8f94%22%3E%3Cpath%20d%3D%22M15.5%2014h-.79l-.28-.27C15.41%2012.59%2016%2011.11%2016%209.5%2016%205.91%2013.09%203%209.5%203S3%205.91%203%209.5%205.91%2016%209.5%2016c1.61%200%203.09-.59%204.23-1.57l.27.28v.79l5%204.99L20.49%2019l-4.99-5zm-6%200C7.01%2014%205%2011.99%205%209.5S7.01%205%209.5%205%2014%207.01%2014%209.5%2011.99%2014%209.5%2014z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 6px center;
            background-size: 16px;
        }
        
        body.rtl .babc-search {
            background-position: left 6px center;
            padding: 5px 10px 5px 30px;
        }
        
        .babc-items-container {
            border: 1px solid #ccd0d4;
            border-radius: 3px;
            max-height: 500px;
            overflow-y: auto;
        }
        
        .babc-item {
            background: #fff;
            margin-bottom: 3px;
            margin-right: auto;
            border-left: 4px solid #2271b1;
            border-radius: 3px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f1;
            transition: background-color 0.1s ease-in-out;
            content-visibility: auto; /* Lazy render off-screen items */
            contain-intrinsic-size: 1px 60px; /* Estimated height to prevent scroll jumping */
        }
        
        .babc-item:last-child {
            border-bottom: none;
        }
        
        .babc-item:hover {
            background-color: #f6f7f7;
        }
        
        .babc-load-more {
            text-align: center;
            padding: 10px;
            background: #f6f7f7;
            cursor: pointer;
            font-weight: 600;
            color: #2271b1;
            border-top: 1px solid #f0f0f1;
        }
        .babc-load-more:hover {
            background: #f0f0f1;
            color: #135e96;
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

        const ITEMS_PER_PAGE = 10;
        const LOAD_MORE_COUNT = 50;

        // Initialize Pagination for each section
        $(".babc-section").each(function() {
            var section = $(this);
            var container = section.find(".babc-items-container");
            var items = container.find(".babc-item");
            
            // Mark all items as matching initially (for the default view)
            items.addClass("babc-match");

            if(items.length > ITEMS_PER_PAGE) {
                // Hide items beyond the limit
                items.slice(ITEMS_PER_PAGE).hide();
                
                // Add Load More button
                var remaining = items.length - ITEMS_PER_PAGE;
                var nextCount = (remaining < LOAD_MORE_COUNT) ? remaining : LOAD_MORE_COUNT;
                var loadMoreBtn = $('<div class="babc-load-more">Load More (' + nextCount + ') &#9660;</div>');
                container.append(loadMoreBtn);
                
                loadMoreBtn.on("click", function() {
                    // Operate only on currently matching items (whether filtered or all)
                    var matchingItems = items.filter(".babc-match");
                    var visibleCount = matchingItems.filter(":visible").length;
                    var nextItems = matchingItems.slice(visibleCount, visibleCount + LOAD_MORE_COUNT);
                    
                    nextItems.css("display", "flex");
                    
                    // Check if we reached the end
                    var newVisibleCount = matchingItems.filter(":visible").length;
                    var newRemaining = matchingItems.length - newVisibleCount;
                    
                    if (newRemaining <= 0) {
                        $(this).hide();
                    } else {
                        var nextLoad = (newRemaining < LOAD_MORE_COUNT) ? newRemaining : LOAD_MORE_COUNT;
                        $(this).html('Load More (' + nextLoad + ') &#9660;');
                    }
                });
            }
        });

        // Generic search functionality (Integrated with Pagination)
        $(".babc-search-input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            var container = $(this).closest(".babc-section").find(".babc-items-container");
            var items = container.find(".babc-item");
            var loadMoreBtn = container.find(".babc-load-more");
            
            // 1. Reset: Hide all items first
            items.hide();

            if (value.length > 0) {
                // 2. Search Mode: Mark matches
                items.removeClass("babc-match");
                items.each(function() {
                    if ($(this).data("sename").toLowerCase().indexOf(value) > -1) {
                        $(this).addClass("babc-match");
                    }
                });
            } else {
                // 3. Reset Mode: All items match
                items.addClass("babc-match");
            }

            // 4. Display Logic: Show first page of matches & toggle button
            var matchingItems = items.filter(".babc-match");
            matchingItems.slice(0, ITEMS_PER_PAGE).css("display", "flex");

            if (matchingItems.length > ITEMS_PER_PAGE) {
                var remaining = matchingItems.length - ITEMS_PER_PAGE;
                var nextCount = (remaining < LOAD_MORE_COUNT) ? remaining : LOAD_MORE_COUNT;
                loadMoreBtn.html('Load More (' + nextCount + ') &#9660;');
                loadMoreBtn.show();
            } else {
                loadMoreBtn.hide();
            }
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
        
        // Initialize color picker visibility - if not checked - hide color picker, and show the disabled input
        $(".check-inputs").each(function() {
            var container = $(this).closest(".babc-item, .babc-option-row");
            if($(this).is(":checked")) {
                container.find(".babc-color-picker").show();
            } else {
                container.find(".babc-color-text-disabled").show();
            }
        });

        // Handle "All pages" checkbox interaction - Disable individual inputs to prevent label clicks
        function babc_toggle_all_state() {
            var isAllChecked = $("#cbox_all").is(":checked");
            $(".check-inputs").prop("disabled", isAllChecked);
        }
        $("#cbox_all").on("change", babc_toggle_all_state);
        babc_toggle_all_state(); // Run on load
    });
    </script>
</div>
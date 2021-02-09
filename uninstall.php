<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
    die;
}else{
    if(get_option('theme_meta_color')){
        // deleteing the stored color from DB
       delete_option('theme_meta_color');
    }
}

<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
    die;
}else{
    if(get_option('tc_pages_list')){
        // deleteing the stored color from DB
       delete_option('tc_pages_list');
    }
}

<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
    die;
}
  
if(get_option('tc_pages_list')){
    // delete the stored color from DB
    delete_option('tc_pages_list');
}

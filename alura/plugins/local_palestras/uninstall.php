<?php
 if(!defined('WP_UNISTALL_PLUGIN')){
     die;
 }

 global $wpdb;
    $wpdb->query('DELETE FROM wp_options WHERE option_name = "local_palestra_endereco"');
    $wpdb->query('DELETE FROM wp_options WHERE option_name = "local_palestra_cidade"');
    $wpdb->query('DELETE FROM wp_options WHERE option_name = "local_palestra_data"');

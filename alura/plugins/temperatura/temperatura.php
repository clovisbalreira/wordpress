<?php   
    /*
    Plugin Name: Temperatura    
    Description: Plugin que exibe a temperatura de uma cidade
    Version: 1.0
    Author: Clóvis Balreira Rodrigues
    */
    if(!defined('ABSPATH')){
        exit;
    }

    require_once plugin_dir_path(__FILE__) . '/includes/scripts.php';
    require_once plugin_dir_path(__FILE__) . '/includes/temperatura.php';
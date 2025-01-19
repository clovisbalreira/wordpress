<?php
/*
    Plugin Name: Local Palestras
    Description: Plugin para cadastrar local e data da próxima palestra realizada
    Version: 1.0
    Author: Clóvis Balreira Rodrigues
*/

if(!defined('ABSPATH')){
    die;
}
load_plugin_textdomain('local_palestra', false, dirname(plugin_basename(__FILE__)) . '/languages');
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/scripts.php';
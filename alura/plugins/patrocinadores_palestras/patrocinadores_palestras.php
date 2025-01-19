<?php
/**
 * Plugin Name: Patrocinadores Palestras
 * Description: Selecionar patrocinadores das palestras
 * Version: 1.0
 * Author: Clóvis Balreira Rodrigues
 */

 //error_log('Plugin Patrocinadores Palestras carregado');

 if(!defined('ABSPATH')){
     die;
 }

 require_once plugin_dir_path(__FILE__) . '/includes/patrocinadores_palestras_widget.php';
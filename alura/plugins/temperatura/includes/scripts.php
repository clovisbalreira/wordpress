<?php
    add_action('wp_enqueue_scripts', 'temperatura_scripts');
    function temperatura_scripts(){
        wp_enqueue_style(
            'temperatura_style', 
            plugins_url() . '/temperatura/css/styles.css'
        );
    }
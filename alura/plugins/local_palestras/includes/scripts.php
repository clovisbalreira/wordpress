<?php
    add_action('wp_enqueue_scripts', 'local_palestra_adiciona_scripts');
    function local_palestra_adiciona_scripts(){
        //js
        wp_enqueue_script(
            'jquery_countdown_lib', 
            plugins_url() . '/local_palestras/js/jquery.countdown.min.js', 
            array('jquery'), 
            null, 
            true
        );

        wp_enqueue_script(
            'contagem-regressiva', 
            plugins_url() . '/local_palestras/js/contagem_regressiva.js', 
            null, 
            null, 
            true
        );

        //css
        wp_enqueue_style(
            'local_palestra_css',
            plugins_url() . '/local_palestras/css/styles.css'
        );

        //Data cadastrada no menu de configurações
        $data = get_option('local_palestra_data');
        wp_localize_script(
            'contagem-regressiva',
            'data',
            $data
        );
    }
?>


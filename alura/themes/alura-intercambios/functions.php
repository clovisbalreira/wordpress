<?php

function registrando_taxonomia() {
    register_taxonomy(
        'Paises', 
        'destinos', 
        array('labels' => array('name' => 'Paises'),
        'hierarchical' => true
    ));
}

add_action('init', 'registrando_taxonomia');

function registrando_post_Customizado() {
    register_post_type('destinos', array(
        'labels' => array('name' => 'Destinos'),
        'public' => true,
        'menu_position' => 0,
        'menu_icon' => 'dashicons-admin-site',
        'supports' => array('title', 'editor', 'thumbnail')
    ));
}
add_action('init', 'registrando_post_Customizado');

function adicionando_recursos_ao_tema(){
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'adicionando_recursos_ao_tema');


function registrando_menu() {
    register_nav_menu(
        'menu-navegacao', 
        'Menu de navegação'
    );
}
add_action('init', 'registrando_menu');

function registrando_banner() {
    register_post_type(
        'banners', 
        array(
            'labels' => array('name' => 'Banners'),
            'public' => true,
            'menu_position' => 1,
            'menu_icon' => 'dashicons-format-image',
            'supports' => array('title', 'thumbnail')
        )
    );
}
add_action('init', 'registrando_banner');

function resgistrando_metabox() {
    add_meta_box(
        'id_registrando_metabox', 
        'Texto para a home', 
        'funcao_callback', 
        'Banners'
    );
}
add_action('add_meta_boxes', 'resgistrando_metabox');

function funcao_callback($post) {
    $texto_home_1 = get_post_meta($post->ID, '_texto_home_1', true);
    $texto_home_2 = get_post_meta($post->ID, '_texto_home_2', true);
    ?>
    <label for="texto_home_1">Cidade</label>
    <input type="text" name="texto_home_1" style="width: 100%" value="<?php echo $texto_home_1; ?>">
    <br>
    <br>
    <label for="texto_home_2">Promoção</label>
    <input type="text" name="texto_home_2" style="width: 100%" value="<?php echo $texto_home_2; ?>">
    <?php
}

function salvar_metabox($post_id) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'texto_home_1' && $key !== 'texto_home_2') {
            continue;
        }
        update_post_meta(
            $post_id, 
            '_'. $key, 
            $_POST[$key]
        );
    }
}
add_action('save_post', 'salvar_metabox');

function pegandoTextosParaBanner() {
    $args = array(
        'post_type' => 'banners',
        'post_status' => 'publish',
        'posts_per_page' => 1
    );
    $query = new WP_Query($args);
    if($query -> have_posts()) :
        while($query -> have_posts()) :
            $query -> the_post();
            $texto1 = get_post_meta(get_the_ID(), '_texto_home_1', true);
            $texto2 = get_post_meta(get_the_ID(), '_texto_home_2', true);
            return array('texto1' => $texto1, 'texto2' => $texto2);
        endwhile;
    endif;
}

function adicionando_scripts() {
    $textosBanner = pegandoTextosParaBanner();
    if(is_front_page()) {
        wp_enqueue_script(
            'typed-js', 
            get_template_directory_uri() . '/js/typed.min.js', 
            array(), 
            false, 
            true
        );
        wp_enqueue_script(
            'texto-banner-js', 
            get_template_directory_uri() . '/js/texto-banner.js', 
            array('typed-js'), 
            false, 
            true
        );
        wp_localize_script(
            'texto-banner-js', 
            'data', 
            $textosBanner
        );
    }
}
add_action('wp_enqueue_scripts', 'adicionando_scripts');
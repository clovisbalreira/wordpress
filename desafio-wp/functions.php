<?php
    add_action('after_setup_theme', 'my_theme_setup');
    function my_theme_setup(){
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');
        register_nav_menus(
            array(
                'primary' => 'Primary'
            )
            );
    }

    add_action('wp_enqueue_scripts', 'my_theme_scripts');
    function my_theme_scripts(){
        wp_enqueue_style('my_css', get_template_directory_uri() .'/assets/css/style.css');
        wp_enqueue_script('function-js', get_template_directory_uri() . '/assets/js/js.js');

    }
    
    add_action('init', 'registrar_videos');
    function registrar_videos(){
        $descricao =   'Usado para os videos do play';
        $singular = 'Vídeo';
        $plural = 'Vídeos';
        
        $labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'view_item' => 'ver ' . $singular,
            'edit_item' => 'Editar ' . $singular,
            'new_item' => 'Novo ' . $singular,
            'add_new_item' => 'Adicionar Novo ' . $singular
        );

        $supports = array(
            'title',
            'thumbnail'
        );

        $args = array(
            'labels' => $labels,
            'description' => $descricao,
            'public' => true,
            'menu_icon' => 'dashicons-format-video',
            'supports' => $supports,
            'register_meta_box_cb' => 'adicionar_meta_info_video'
        );
        register_post_type('video',$args);
    }

    add_action('init', 'criando_taxomania_segmento');
    function criando_taxomania_segmento(){
        $singular = 'Segmento';
        $plural = 'Segmento';
        
        $labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'view_item' => 'Ver ' . $singular,
            'edit_item' => 'Editar ' . $singular,
            'new_item' => 'Novo ' . $singular,
            'add_new_item' => 'Adicionar Novo ' . $singular
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'hierarchical' => true
        );
        register_taxonomy('segmento', 'video', $args);
    }

    function is_selected_taxonomy($taxonomy, $search){
        if($taxonomy->slug === $search){
            echo 'selected';
        }
    }

    add_action('add_meta_boxes', 'adicionar_meta_info_video');
    function adicionar_meta_info_video(){
        add_meta_box('informacoes_video',
            'Informações',
            'informacoes_video_view',
            'video',
            'normal',
            'high'
        );
    }
    
    function informacoes_video_view($post){
        $video_meta_data = get_post_meta( $post->ID );?>
        <style>
            .video-metabox-item{
                padding: 10px;
                flex-basis: 30%;
            }
            .video-metabox-item label{
                font-weight: 700;
                display: block;
                margin: .5rem 0;
            }
            .video-metabox-input{
                border: 1px solid #ccc;
                margin: 0;
            }
        </style>
        <div class="video-metabox">
            <div class="video-metabox-item">
                <label for="video-descricao-input">Descrição:</label>
                <textarea id="video-descricao-input" class="video-metabox-input" type="file" name="descricao_id" cols="30" rows="5" value="<?= $video_meta_data['descricao_id'][0];?>" placeholder="Digite a descrição do vídeo"><?= $video_meta_data['descricao_id'][0];?></textarea>
            </div>
            <div class="video-metabox-item">
                <label for="video-tempo-input">Tempo de Duração: </label>
                <input id="video-tempo-input" class="video-metabox-input" type="number" name="tempo_id" value="<?= $video_meta_data['tempo_id'][0];?>" placeholder="Digite o tempo do vídeo" min="0">
            </div>
            <div class="video-metabox-item">
                <label for="video-sinopse-input">Sinopse: </label>
                <input id="video-sinopse-input" class="video-metabox-input" type="text" name="sinopse_id" value="<?= $video_meta_data['sinopse_id'][0];?>" placeholder="Digite a sinopse do video">
            </div>
            <div class="video-metabox-item">
                <label for="video-video-input">Vídeo: </label>
                <input id="video-video-input" class="video-metabox-input" type="text" name="video_id" value="<?= $video_meta_data['video_id'][0];?>" placeholder="Digite o link do youtube">
            </div>
        </div>
        <?php
        }

        function salvar_meta_info_videos( $post_id ){
            if( isset($_POST['descricao_id'])){
                update_post_meta( $post_id, 'descricao_id', sanitize_text_field($_POST['descricao_id']));
            }
            if( isset($_POST['tempo_id'])){
                update_post_meta( $post_id, 'tempo_id', sanitize_text_field($_POST['tempo_id']));
            }
            if( isset($_POST['sinopse_id'])){
                update_post_meta( $post_id, 'sinopse_id',sanitize_text_field($_POST['sinopse_id']));
            }
            if( isset($_POST['video_id'])){
                $video = str_replace("embed/","watch?v=","https://www.youtube.com/watch?v=qkMCJbBrN3g");
                update_post_meta( $post_id, $video, sanitize_text_field($video));
            }
        }
        add_action('save_post','salvar_meta_info_videos');

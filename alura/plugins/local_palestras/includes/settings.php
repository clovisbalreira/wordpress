<?php
    add_action('admin_menu', 'local_palestra_add_menu');
    function local_palestra_add_menu(){
        add_menu_page(
            'Local Palestra', 
            __('Local Palestra', 'local_palestra'), 
            'manage_options', 
            'local-palestra', 
            'local_palestra_menu_page', 
            'dashicons-location-alt', -1);
    }

    function local_palestra_menu_page(){
        ?>
        <div>
            <h1><?php echo __('Local Palestra', 'local_palestra');?></h1>
            <form method="post" action="options.php">
                <?php
                    settings_errors();
                    settings_fields('local_palestra_options');
                    do_settings_sections('local-palestra');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    add_action('admin_menu', 'local_palestra_secao');

    function local_palestra_secao(){
        //secao
        add_settings_section(
            'local_palestra_secao', 
            __('Configurações do Local da Palestra', 'local_palestra'), 
            'local_palestra_secao_campos_detalhes', 
            'local-palestra');

        //endereço
        add_settings_field(
            'local_palestra_endereco', 
            __('Endereço', 'local_palestra'), 
            'local_palestra_endereco', 
            'local-palestra', 
            'local_palestra_secao');

        register_setting('local_palestra_options', 'local_palestra_endereco', 'verifica_endereco');

        //cidade
        add_settings_field(
            'local_palestra_cidade', 
            __('Cidade', 'local_palestra'), 
            'local_palestra_cidade', 
            'local-palestra', 
            'local_palestra_secao');

        register_setting('local_palestra_options', 'local_palestra_cidade', 'verifica_cidade');

        //data
        add_settings_field(
            'local_palestra_data', 
            __('Data', 'local_palestra'), 
            'local_palestra_data', 
            'local-palestra', 
            'local_palestra_secao'
        );

        register_setting(
            'local_palestra_options', 
            'local_palestra_data', 
            'verifica_data'
        );
    }

    function local_palestra_secao_campos_detalhes(){
        ?>
            <p><?php echo __('Insira os dados de endereço, cidade e datas da próxima palestra', 'local_palestra')?></p>
        <?php
    }

    function local_palestra_endereco(){
        $options = get_option('local_palestra_options');
        ?>
            <input type="text" id="local_palestra_endereco" name="local_palestra_endereco" value="<?php echo esc_attr(get_option('local_palestra_endereco'))?>" required>
        <?php
    }

    function local_palestra_cidade(){
        $options = get_option('local_palestra_options');
        ?>
            <input type="text" id="local_palestra_cidade" name="local_palestra_cidade" value="<?php echo esc_attr(get_option('local_palestra_cidade'))?>" required>
        <?php
    }

    function local_palestra_data(){
        $options = get_option('local_palestra_options');
        ?>
            <input type="date" id="local_palestra_data" name="local_palestra_data" value="<?php echo esc_attr(get_option('local_palestra_data'))?>" required>
        <?php
    }

    function verifica_endereco($endereco){
        if(empty($endereco)){
            $endereco = get_option('local_palestra_endereco');
            add_settings_error(
                'local_palestra_mensagem_erro', 'local_palestra_mensagem_erro_endereco', __('Por favor, preencha o campo de endereço'), 'error');
        }
        return $endereco;
    }

    function verifica_cidade($cidade){
        if(empty($cidade)){
            $cidade = get_option('local_palestra_cidade');
            add_settings_error('local_palestra_mensagem_erro', 'local_palestra_mensagem_erro_cidade', __('Por favor, preencha o campo de cidade'), 'error');
        }
        return $cidade;
    }

    function verifica_data($data){
        if(empty($data)){
            $data = get_option('local_palestra_data');
            add_settings_error('local_palestra_mensagem_erro', 'local_palestra_mensagem_erro_data', __('Por favor, preencha o campo de data'), 'error');
        }
        return $data;
    }
?>

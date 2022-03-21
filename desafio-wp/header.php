<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
    </head>
    <body>
        <header>
            <img src="<?php get_template_directory_uri() . '/assets/img/logo.png'?>" alt="">
            <a href="http://localhost/play/">
                <section id="logo-imagem"></section>
            </a>
            <nav>
                <?php 
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary'
                        )
                    );
                ?>
            </nav>
        </header>
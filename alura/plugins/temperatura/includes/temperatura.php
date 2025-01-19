<?php
    add_action('widgets_init', 'temperatura_register_widgets');

    function temperatura_register_widgets(){
        register_widget('Temperatura');
    }
    class Temperatura extends WP_Widget{
        public function __construct(){
            parent::__construct(
                'temperatura', 
                'Temperatura', 
                array('description' => 'Exibe a temperatura de uma cidade'
            ));
        }  

        public function widget($args, $instance){
            $cidade = urldecode(get_option('local_palestra_cidade'));
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://api.openweathermap.org/data/2.5/weather?q=". $cidade . ",br&appid=" . OPENWEATHER_API_KEY);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $resultado = curl_exec($curl);
            $resultadoArray = json_decode($resultado,true);
            ?>
                <section class="container-temperatura">
                    <p class="cidade-temperatura">
                        <?php 
                            echo get_option('local_palestra_cidade'); 
                        ?>
                    </p>
                    <p class="temperatura">
                        <?php
                            echo round($resultadoArray['main']['temp'] - 273.15);
                        ?> °C
                    </p>
                </section>
            <?PHP
        }
    }
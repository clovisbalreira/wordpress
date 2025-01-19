<?php
    add_shortcode('local_palestra', 'local_palestra_shortcode');
    function local_palestra_shortcode(){
        $endereco = urlencode(get_option('local_palestra_endereco'));
        $cidade = urlencode(get_option('local_palestra_cidade'));
        return '<div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe
                            width="100%"
                            height="450"
                            style="border:0"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps?q='.esc_attr($endereco) .',+'.esc_attr($cidade) .'&output=embed">
                        </iframe>
                    </div>
                </div>
                <h2 class="proximos-eventos">Próxima Evento</h2>
                <div id="eventos">
                    <div id="dias"></div>
                    <div id="horas"></div>
                    <div id="minutos"></div>
                    <div id="segundos"></div>
                </div>
                ';
    }
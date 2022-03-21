<?php get_header()?>
    <section id="imagem">
        <div>
            <?php
                $the_query = new WP_Query( array(
                    'post_type' => 'video',
                    'post__not_in' => array( get_the_ID() ),
                    'posts_per_page' => 1
                ) );
                if ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        ?>
                            <?php $video_meta_data = get_post_meta( $post->ID ); ?>
                            <span class="btn-branco" ><?php the_terms($id,'segmento');?></span>
                            <span class="btn-trasparente" ><?= esc_attr( $video_meta_data['tempo_id'][0] ); ?>m</span>
                            <h2><?php the_title()?></h2>
                            <a href="<?php echo get_the_permalink()?>" class="btn-vermelho">Mais informações</a>
                    <?php 
                }
            ?>       
        </div>
    </section>
    <?php 
        $termos = get_terms('segmento');        
        foreach( $termos as $termo ){?>
        <section id="galeria-termo">
            <h3>
                <a href="index.php/termo/<?php echo $termo->slug;?>">
                    <?php echo $termo->name?>
                </a>
            </h3>
            <style>
                .carrossel{
                    height: 350px;
                    width: 100%;
                    position: relative;
                    vertical-align: top;
                    text-align: end;
                }
                .carrossel .switchLeft, .carrossel .switchRight{
                    color: white;
                    font-weight: bold;
                    height: 100%;
                    width: 5px;
                    line-height: 250px;
                    font-size: 25px;
                    text-align: center;
                    font-family: sans-serif;
                    top: 0;
                    z-index: 3;
                }
                .carrossel .switchLeft{
                    position: absolute;
                    left: -50px;
                }
                .carrossel .switchRight{
                    position: absolute;
                    right: -50px;
                }
                .carrosselbox{
                    height: 350px;
                    width: auto;
                    overflow: hidden;
                    white-space: nowrap;
                    display: inline-block;
                    text-align: center;
                    padding-bottom: 10px !important;
                    display: flex;
                    vertical-align: top;
                    align-items: center;
                }
                
                .carrossel .carrosselbox {
                    text-align: left;
                    font: normal normal 900 30px/32px Circular Spotify Tx T;
                    margin: 5% 2%;
                }
                
                .carrosselbox a{
                    text-decoration: none;
                    color: white;
                    width: 160px;
                    margin: 2%;
                }
                
                .carrosselbox a img{
                    width: 100px;
                    height: 200px;
                    min-width: 147px;
                    max-width: 147px;
                    background-size: cover;
                    margin: 0;
                    cursor: pointer;
                    border-radius: 3px;
                    transition: 0.5s ease;
                    z-index: 2;
                }
                
                .carrosselbox a p{
                    width: 75px;
                    border-radius: 3px;
                    font-size: .5em;
                    text-align: center;
                    margin: 5% 2%;
                    color: #ffffff;
                    background-color: rgba(0, 0, 0, 0.123);
                    border: 1px solid #ffffff;
                }
                
                .carrosselbox a h2{
                    font-size: .5em;
                    height: 80px;
                    line-height: 1.5;
                    width: 100%;
                    white-space: normal;
                }
                
                @media (max-width: 413px) {
                    .carrossel{
                        width: 80%;
                    }
                    .carrossel .switchLeft{
                        position: absolute;
                        left: -5%;
                    }
                    .carrossel .switchRight{
                        position: absolute;
                        right: -20%;
                    }
                    .carrossel .carrosselbox {
                        width: 115%;
                    }
                }
            </style>
            <div class="carrossel">
                <div class="carrosselbox"></div>
                <a class="switchLeft sliderButton" onclick="sliderScrolLeft()"><</a>
                <a class="switchRight sliderButton" onclick="sliderScrolRight()">></a>
            </div>
            <script>
                const sliders = document.querySelector('.carrosselbox')
                var scrollPerClick;
                var ImagePadding = 20;
                
                showMovieData();
                
                var scrollAmount = 0 ;
                
                function sliderScrolLeft(){
                    sliders.scrollTo({
                        top: 0,
                        left: (scrollAmount -= scrollPerClick),
                        behavior: 'smooth'
                    });
                    if(scrollAmount < 0){
                        scrollAmount = 0
                    }
                }
                
                function sliderScrolRight(){
                    if(scrollAmount <= sliders.scrollWidth - sliders.clientWidth){
                        sliders.scrollTo({
                            top: 0,
                            left: (scrollAmount += scrollPerClick),
                            behavior: 'smooth'
                        });
                    }
                }

                function showMovieData(){
                    <?php
                        $the_query_segmento = new WP_Query( array(
                            'post_type' => 'video',
                            'post__not_in' => array( get_the_ID() ),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => $termo->taxonomy,
                                    'field'    => 'slug',
                                    'terms' => array($termo->slug)
                                ),
                            )
                        ));
                    ?>
                    var index = 0
                    <?php if ($the_query_segmento->have_posts()) : ?>
                        index++
                        <?php while ($the_query_segmento->have_posts()) : $the_query_segmento->the_post(); ?>
                        sliders.insertAdjacentHTML(
                            "beforeend",
                            `<a class="img-${index} slider-img" href="<?php the_permalink()?>">
                            <?php $video_meta_data = get_post_meta( $post->ID ); ?>
                            <img src="<?= get_template_directory_uri().'/assets/img/'.esc_attr( $video_meta_data['imagem_id'][0] ); ?>" alt="">
                            <p><?= esc_attr( $video_meta_data['tempo_id'][0] ); ?>m</p>
                            <h2><?php the_title(); ?></h2>
                            </a>`
                            )
                            <?php endwhile; ?>
                            scrollPerClick = document.querySelector(".img-1").clientWidth + ImagePadding;
                            <?php endif; ?>  
                        }
            </script>
        </section>
    <?php } ?>
<?php get_footer();
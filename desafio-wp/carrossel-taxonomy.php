
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
        var index = 0
        <?php if (have_posts()) : ?>
            index++
            <?php while (have_posts()) : the_post(); ?>
            sliders.insertAdjacentHTML(
                "beforeend",
                `<a class="img-${index} slider-img" href="<?php the_permalink()?>">
                <img src="<?php the_post_thumbnail_url(); ?>">
                <?php $video_meta_data = get_post_meta( $post->ID ); ?>
                <p><?= esc_attr( $video_meta_data['tempo_id'][0] ); ?>m</p>
                <h2><?php the_title(); ?></h2>
                </a>`
                )
                <?php endwhile; ?>
                scrollPerClick = document.querySelector(".img-1").clientWidth + ImagePadding;
                <?php endif; ?>    
            }
</script>

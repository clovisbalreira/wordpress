<?php get_header()?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <section id="singular">
                <div>
                    <?php $video_meta_data = get_post_meta( $post->ID ); ?>
                    <span class="btn-branco" ><?php 
                     the_terms($id,'segmento');?></span>               
                    <span class="btn-trasparente" ><?= esc_attr( $video_meta_data['tempo_id'][0] ); ?>m</span>
                    <h2><?php the_title(); ?></h2>
                </div>
                <embed class="play" type="video/webm" src="<?= esc_attr( $video_meta_data['video_id'][0] ); ?>" height="550px">
            </section>
        <?php endwhile; ?>
    <?php endif; ?>
<?php get_footer();

<?php
	$css_escolhido = 'single';
    get_header();
?>
<main>
    <article>
        <?php if(have_posts()): while(have_posts()): the_post();?>
            <div class="single-imovel-thumbnail">
                <?php the_post_thumbnail();?>
            </div>
            <div class="container">
                <section class="chamada-principal">
                    <?php the_title();?>
                </section>
            </div>
            <section class="single-imovel-geral">
                <div class="simgle-imovel-descricao">
                    <?php the_content();?>
                </div>
                <?php	$imoveis_meta_data = get_post_meta( $post->ID ); ?>
				 
				<dl class="single-imovel-informacoes">
					<dt>Preço</dt>
					<dd>R$ <?= esc_attr( $imoveis_meta_data['preco_id'][0] ); ?></dd>

					<dt>Vagas</dt>
					<dd><?= esc_attr( $imoveis_meta_data['vagas_id'][0] ); ?></dd>

					<dt>Banheiros</dt>
					<dd><?= esc_attr( $imoveis_meta_data['banheiros_id'][0] ); ?></dd>
					
					<dt>Quartos</dt>
					<dd><?= esc_attr( $imoveis_meta_data['quartos_id'][0] ); ?></dd>
				</dl>
            </section>
            <span class="single-imovel-data">
                <?php the_date(); ?>
            </span>
        <?php endwhile; endif;?>
    </article>
</main>
<?php get_footer();?>
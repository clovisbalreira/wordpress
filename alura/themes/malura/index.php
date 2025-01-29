<?php 
     $queryTaxonomy = array_key_exists('taxonomy', $_GET); 
     if( $queryTaxonomy && $_GET['taxonomy'] === ''){
        wp_redirect( home_url() );
        exit;
    }
	$css_escolhido = 'index';
    get_header();
?>
    <main class="home-main">
        <div class="container">
        <?php $taxonomias = get_terms('localizacao'); ?>
            <form class="busca-localizacao-form" action="<?= site_url(); ?>" method="get">
                <div class="taxonomy-select-wrapper">
                    <select name="taxonomy">
                        <option value="">Todos os imóveis</option>
                        <?php foreach($taxonomias as $taxonomia) { ?>
                            <option value="<?= $taxonomia->slug; ?>"><?= $taxonomia->name; ?></option>
                        <?php } ?>
                     </select>
                </div>
                <button type="submit">Filtrar</button>
            </form>
            <ul class="imoveis-listagem">
                <?php 
                if($queryTaxonomy) {
                    $taxQuery = array(
                        array(
                        'taxonomy' => 'localizacao',
                        'field' => 'slug',
                        'terms' => $_GET['taxonomy']
                        )
                    );
                } else {
                    $taxQuery = array();
                }
                
                $args = array(
                    'post_type' => 'imovel',
                    'tax_query' => $taxQuery
                );
                $loop = new WP_Query($args);
                if($loop->have_posts()):?>
                    <?php while($loop->have_posts()):       
                        $loop->the_post();
                    ?>
                    <li class="imoveis-listagem-item">
                        <a href="<?php the_permalink();?>">
                            <?php the_post_thumbnail();?>
                            <h2><?php the_title();?></h2>
                            <div><?php the_content();?></div>
                        </a>
                    </li>
                <?php endwhile; endif;?>
            </ul>
        </div>
    </main>
<?php get_footer();?>
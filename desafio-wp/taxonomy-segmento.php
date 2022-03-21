<?php get_header();?>
    <?php $termo = get_term_by( 'slug', get_query_var( 'segmento' ), get_query_var( 'taxonomy' ) ) ?></h1>
    <section id="descricao">
        <section>
            <h1><?php echo $termo->name;?></h1>
            <p><?php echo $termo->description; ?></p>
        </section>
        <section id="galeria-termo">
            <?php include 'carrossel-taxonomy.php';
            ?> 
        </section>
    </section>
<?php get_footer();
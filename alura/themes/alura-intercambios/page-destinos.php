<?php
    $estiloPagina = 'destinos';
    require 'header.php';
    //echo '<pre>';
    //    $paises = get_terms(array('taxonomy' => 'Paises'));
    //    print_r($paises);
    //echo '</pre>';
    ?>
    <form action="#" class="container-alura formulario-pesquisa-paises">
        <h2>Conheça nossos destinos</h2>
        <select name="paises" id="paises">
            <option value="">-- Selecione --</option>
            <?php
                $paises = get_terms(array('taxonomy' => 'Paises'));
                foreach($paises as $pais):?>
                    <option value="<?php echo $pais->name?>" 
                    <?php echo !empty($_GET['paises']) && $_GET['paises'] === $pais->name ? 'selected' : '' ?>><?php echo $pais->name?></option>
                <?php endforeach
            ?>
        </select>
        <input type="submit" value="Pesquisar">
    </form>
    <?php
    if(!empty($_GET['paises'])):
        $paisSelecionado = $arrayName = array(
            array(
                'taxonomy' => 'Paises',
                'field' => 'name',
                'terms' => $_GET['paises']
            )
        );
    endif;
    $args = array(
        'post_type' => 'destinos',
        'tax_query' => !empty($_GET['paises']) ? $paisSelecionado : ''
    );
    $query = new WP_Query($args);
    if( $query -> have_posts()):
        echo '<main class="page-destinos">';
        echo '<ul class="lista-destinos container-alura">';
        while( $query -> have_posts()):
            echo '<li class="col-md-3 destinos">';
            $query -> the_post();
            the_post_thumbnail();
            the_title('<p class="titulo-destino">', '</p>');
            The_content();
            echo '</li>';
        endwhile;
        echo '</main>';
        echo '</ul>';
    endif;
    require 'footer.php';
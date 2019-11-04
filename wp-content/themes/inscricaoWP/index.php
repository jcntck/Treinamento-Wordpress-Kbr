<?php get_header(); ?>

<main class="container">

    <h1>Treinamentos</h1>

    <div class="row">
        <?php
        // Se não funcionar apagar
        // $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

        $args = array(
            'post_type' => 'treinamento'
        );

        $items = new WP_Query($args);
        if ($items->have_posts()) : while ($items->have_posts()) : $items->the_post();
                ?>
                <div class="col l4 m6 s12">
                    <article class="card-panel">
                        <div class="center-align">
                            <?= the_post_thumbnail('thumbnail') ?>
                        </div>
                        <section class="desc-card">
                            <h2 class="title-card"><?= the_title() ?></h2>
                            <div class="col"><?= the_content() ?></div>
                        </section>
                        <section class="footer-card">
                            <a href="#">Ver mais</a>
                        </section>
                    </article>
                </div>
        <?php
            endwhile;
        endif;
        ?>
        <?php wordpress_pagination($items); ?>
    </div>
</main>

<?php get_footer(); ?>
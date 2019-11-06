<?php get_header(); ?>


<main class="container">

    <div class="row valign-wrapper">
        <div class="col s12 xl8">
            <h1 class='title'>Incrições de Treinamentos</h1>
        </div>
        <div class="col s12 xl4">
            <form>
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input id="search" type="search">
                    <label for="search">Pesquisa</label>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php
        $args = array(
            'post_type' => 'treinamento',
            'posts_per_page' => 6,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1
        );

        $items = new WP_Query($args);
        if ($items->have_posts()) : while ($items->have_posts()) : $items->the_post();
                ?>
                <div class="col l4 m6 s12">
                    <article class="card-panel">
                        <div class="center-align">
                            <?php if (has_post_thumbnail()) : the_post_thumbnail('thumbnail');
                                    else : echo "<span class='no-img'></span>";
                                    endif; ?>
                        </div>
                        <section class="desc-card">
                            <h2 class="title-card"><?= the_title() ?></h2>
                            <div class="col"><?= the_field('chamada') ?></div>
                        </section>
                        <section class="footer-card">
                            <a href="<?= the_permalink() ?>">Ver mais</a>
                        </section>
                    </article>
                </div>
        <?php
            endwhile;
        endif;
        ?>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <?php wordpress_pagination($items); ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
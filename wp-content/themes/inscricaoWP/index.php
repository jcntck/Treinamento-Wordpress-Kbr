<?php 
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../tmp'));
session_start();
get_header(); 
?>


<main class="container">

    <div class="row">
        <div class="col s12 m6 l8">
            <h1 class='title'>Treinamentos</h1>
        </div>
        <div class="col s12 m6 l4 vertical-align">
            <?= get_search_form(); ?>
        </div>
    </div>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="row">
            <div class="col s12 card-panel green accent-1">
                <p><?=$_SESSION['success']?></p>
            </div>
        </div>
    <?php 
    endif; ?>
    <div class="row">
        <?php
        $args = array(
            'post_type' => 'treinamento',
            'posts_per_page' => 6,
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
            's' => $_GET['s']
        );

        $items = new WP_Query($args);
        if ($items->have_posts()) : while ($items->have_posts()) : $items->the_post();
                ?>
                <div class="col l4 m6 s12">
                    <article class="card-panel list-treinamento" data-url="<?= the_permalink() ?>">
                        <div class="center-align img-card">
                            <?php if (has_post_thumbnail()) : the_post_thumbnail('thumbnail', array('class' => 'responsive-img'));
                                    else : echo "<span class='no-img'></span>";
                                    endif; ?>
                        </div>
                        <section class="desc-card">
                            <div class="title-card-height">
                                <h2 class="title-card"><?= the_title() ?></h2>
                            </div>
                            <div class="col chamada"><?= the_field('chamada') ?></div>
                        </section>
                        <section class="footer-card valign-wrapper flex-footer-card">
                            <?php if (get_field('gratuito') == 'false') : ?>
                                <span class="valor-index grey-text text-darken-1">R$<?= get_field('valor') ?></span>
                            <?php else : ?>
                                <span class="valor-index grey-text text-darken-1">Gratuito</span>
                            <?php endif;
                                    if (countVagas($post->ID)  > 0) :
                                        ?>
                                <span class="small green-text text-darken-1"><?= countVagas($post->ID)  ?> vagas</span>
                            <?php else : ?>
                                <span class="small red-text text-accent-4">Vagas esgotadas</span>
                            <?php endif; ?>
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
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    $('.list-treinamento').on('mouseover', function() {
        $(this).css('cursor', 'pointer');
    })

    $('.list-treinamento').click(function() {
        var link = $(this).attr('data-url');
        window.location.replace(link);
    })
</script>
<?php get_footer();
session_destroy(); ?>
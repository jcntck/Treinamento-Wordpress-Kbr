<?php get_header(); ?>

<main class="container" id="content-single">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div>
                <?php if (has_post_thumbnail()) : the_post_thumbnail();
                        else : echo "<img src='" . get_template_directory_uri() . "/images/no-img.png'>";
                        endif; ?>
            </div>
            <div class="content">
                <h2><?= the_title() ?></h2>
                <div><?= the_content() ?></div>
            </div>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>
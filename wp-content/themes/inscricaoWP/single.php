<?php
get_header();
$treinamento = get_fields();
?>

<main class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <section id="title-single" class="card-panel">
                <figure>
                    <?php if (has_post_thumbnail()) : the_post_thumbnail();
                            else : echo "<img src='" . get_template_directory_uri() . "/images/no-img.png'>";
                            endif; ?>
                </figure>
                <div class="info">
                    <h2 class="deep-orange-text text-darken-2"><?= the_title() ?></h2>
                    <h3 class="deep-orange-text text-darken-3"><?= $treinamento['chamada'] ?></h3>
                </div>
            </section>
            <section class="row">
                <div class="col s12 m7 l8">
                    <h3 id="titulo-desc-single">Descrição: </h3>
                    <div class="content">
                        <?= the_content() ?>
                    </div>
                </div>
                <aside class="col s12 m5 l4">
                    <section class="card-panel deep-orange accent-2 white-text" id="divPreco">
                        <div class="valor">
                            <?php if ($treinamento['gratuito'] == "Sim") : ?>
                                <span class="gratuito">Este é um treinamento gratuito</span>
                            <?php else : ?>
                                <span class="preco">R$<?= $treinamento['valor'] ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="vagas">
                            <p><?= $treinamento['vagas'] ?> vagas sobrando.</p>
                        </div>
                    </section>
                    <section>
                        <a class="waves-effect waves-light deep-orange darken-3 btn-large" id="btn-inscricao">Inscreva-se</a>
                    </section>
                </aside>
            </section>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>
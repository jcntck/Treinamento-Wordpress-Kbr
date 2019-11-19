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
                    <a href="<?= site_url() ?>" class="blue darken-4 waves-effect waves-light btn"><i class="material-icons">arrow_back</i>Voltar</a>
                    <h2 class="blue-text text-darken-4"><?= the_title() ?></h2>
                    <h3 class="blue-text text-darken-4"><?= $treinamento['chamada'] ?></h3>
                </div>
            </section>
            <section class="row">
                <div class="col s12 m7 l8">
                    <h3 id="titulo-desc-single">Descrição: </h3>
                    <div class="content">
                        <?= the_content() != "" ? the_content() : "Esse treinamento não possui descrição" ?>
                    </div>
                </div>
                <aside class="col s12 m5 l4">
                    <section class="card-panel blue darken-4 white-text" id="divPreco">
                        <div class="valor center">
                            <?php if ($treinamento['gratuito'] == "true") : ?>
                                <span class="gratuito">Este é um treinamento gratuito</span>
                            <?php else : ?>
                                <span class="preco">R$<?= $treinamento['valor'] ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($treinamento['vagas'] > 0) : ?>
                            <div class="vagas center">
                                <p><span id="numero"><?= $treinamento['vagas'] ?></span> vagas restantes.</p>
                            </div>
                    </section>
                    <section>
                        <a href="<?= site_url('cadastro') . "?id=" . $post->ID ?>" class="waves-effect waves-light blue accent-2 btn-large" id="btn-inscricao">Inscreva-se</a>
                    </section>
                <?php else : ?>
                    <div class="vagas esgotadas center">
                        <p>Vagas esgotadas</p>
                    </div>
            </section>
        <?php endif; ?>
        </aside>
        </section>

<?php endwhile;
endif; ?>
</main>

<?php get_footer(); ?>
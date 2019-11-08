<?php
/* Template Name: Formulário Inscritos */
get_header();

$id = isset($_GET['id']) ? $_GET['id'] : null;
$treinamento_acf = get_fields($id) ? get_fields($id) : null;
$treinamento_wp = $id ? get_post($id) : null;
$thumb = get_the_post_thumbnail($id, 'thumbnail', array('class' => 'circle'));
// var_dump($treinamento_acf);
// echo "<br><hr>";
// var_dump(get_post($id));
// echo $thumb;
?>

<main class="container">
    <div class="row">
        <h2 class='title'>Ficha de Inscrição</h2>
    </div>
    <div class="row">
        <section class="col s8 section-form">
            <form id="formInscricao" action="<?= get_template_directory_uri() . '/inscritosDAO.php' ?>" method="post" novalidate="novalidate">
                <input type="hidden" name="treinamento_id" value="<?=$id?>">
                <div class="row">
                    <div class="input-field col s11">
                        <input type="text" id="nome_completo" name="nome_completo" placeholder="Ex: José Carlos da Silva" data-error=".errorNome" minlength="5" maxlength="50" required>
                        <label for="nome_completo">Nome completo</label>
                        <div class="errorNome"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11">
                        <input type="text" id="data_nascimento" name="data_nascimento" data-error=".errorData" placeholder="00/00/0000">
                        <label for="data_nascimento">Data de nascimento</label>
                        <div class="errorData"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11">
                        <input type="text" id="cpf" name="cpf" placeholder="Ex: 000.000.000-00" data-error=".errorCPF">
                        <label for="cpf">Seu CPF</label>
                        <div class="errorCPF"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11">
                        <input type="email" id="email" name="email" placeholder="Ex: josecarlos@seuprovedor.com" data-error=".errorEmail">
                        <label for="email">E-mail</label>
                        <div class="errorEmail"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s5">
                        <input type="tel" id="telefone" name="telefone" placeholder="Ex: (00) 0000-0000" data-error=".errorTelefone">
                        <label for="telefone">Telefone:</label>
                        <div class="errorTelefone"></div>
                    </div>
                    <div class="col s1"></div>
                    <div class="input-field col s5">
                        <input type="tel" id="celular" name="celular" placeholder="Ex: (00) 00000-0000" data-error=".errorCelular">
                        <label for="celular">Celular:</label>
                        <div class="errorCelular"></div>
                    </div>
                </div>
                <div class="row">
                    <fieldset class="col s11">
                        <legend>Endereço</legend>
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" id="cep" name="cep" placeholder="Ex: 0000-000" data-error=".errorCEP">
                                <label for="cep">CEP</label>
                                <div class="errorCEP">
                                    <span class="errorCEP_api"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua Aleatória">
                                <label for="endereco">Endereço</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" id="bairro" name="bairro" placeholder="Ex: America">
                                <label for="bairro">Bairro</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="cidade" name="cidade" placeholder="Ex: São Paulo">
                                <label for="cidade">Cidade</label>
                            </div>
                            <div class="input-field col s4">
                                <input type="text" id="estado" name="estado" placeholder="Ex: São Paulo">
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="row">
                    <div class="col s11">
                        <button class="btn-large color-custom waves-effect waves-light" type="submit" name="action">Enviar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </section>
        <section class="col s4 card-panel center-align">
            <?= $thumb ?>
            <h3 id="title-form"><?= $treinamento_wp->post_title ?></h3>
            <p><?= $treinamento_acf['chamada'] ?></p>
            <div class="valor">
                <?php if ($treinamento_acf['gratuito'] == "Sim") : ?>
                    <span class="gratuito">Este é um treinamento gratuito</span>
                <?php else : ?>
                    <span class="preco">R$<?= $treinamento_acf['valor'] ?></span>
                <?php endif; ?>
            </div>
            <div class="vagas">
                <p><?= $treinamento_acf['vagas'] ?> vagas sobrando.</p>
            </div>
        </section>
    </div>
</main>

<!-- JQuery, datepicker -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="<?= get_template_directory_uri() . '/js/mask/dist/jquery.mask.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/jquery.validate.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/additional-methods.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/form.js' ?>"></script>

<?php get_footer(); ?>
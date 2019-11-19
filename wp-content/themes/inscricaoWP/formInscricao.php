<?php
/* Template Name: Formulário Inscritos */
session_start(); // Inicia a sessão
if (isset($_POST['submit'])) {
    $validCpf = validateCPF();
    $validEmail = validateEmail();
    if ($validCpf && $validEmail) {
        $success = cadastrarInscrito();
        if ($success) {
<<<<<<< HEAD
            enviarEmail($success, 1);
            $_SESSION['success'] = "Inscrição realizada";
=======
>>>>>>> d7caca1bc3f764ea5eaa234c1ee0f5179b3aa43e
            wp_redirect(home_url());
            exit;
        }
    } else {
        if (!$validCpf) $_SESSION['errorCPF'] = 'CPF já cadastrado neste treinamento';
        if (!$validEmail) $_SESSION['errorEmail'] = "E-mail já cadastrado neste treinamento";
        saveInputsValue();
    }
}
get_header();

if (isset($_GET['id'])) $treinamento = carregarTreinamento($_GET['id']);
$acf = $treinamento['acf'];
$treinamento_wp = $treinamento['wp'];
$thumb = $treinamento['thumb'];
?>
<main class="container">
    <div class="row valign-wrapper">
        <div class="col s11">
            <h2 class='title form-title'>Ficha de Inscrição</h2>
        </div>
        <div class="col s1">
            <a href="<?=site_url()?>" class="btn-floating hoverable btn-large waves-effect waves-light light-blue lighten-2" title="Voltar para a página inicial">
                <i class="material-icons">home</i></a>
        </div>
    </div>
    <div class="row">
<<<<<<< HEAD
        <section class="col s12 m6 l4">
            <div class="card-panel center-align">
                <?= $thumb ?>
                <h3 id="title-form"><?= $treinamento_wp->post_title ?></h3>
                <p><?= $acf['chamada'] ?></p>
                <div class="valor">
                    <?php if ($acf['gratuito'] == "true") : ?>
                        <span class="gratuito">Este é um treinamento gratuito</span>
                    <?php else : ?>
                        <span class="preco">R$<?= $acf['valor'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="vagas">
                    <p><?= $acf['vagas'] ?> vagas sobrando.</p>
                </div>
            </div>
        </section>
        <section class="col s12 m6 l8 section-form">
=======
        <section class="col s8 section-form">
>>>>>>> d7caca1bc3f764ea5eaa234c1ee0f5179b3aa43e
            <?php if (isset($_SESSION['errorCPF']) || isset($_SESSION['errorEmail'])) :
                $value = $_SESSION['inputs'];
                if (isset($_SESSION['errorCPF'])) :
                    ?>
<<<<<<< HEAD
                    <div class="col s12 card-panel red accent-1">
                        <p><?= $_SESSION['errorCPF'] ?></p>
                    </div>
                <?php endif;
                    if (isset($_SESSION['errorEmail'])) : ?>
                    <div class="col s12 card-panel red accent-1">
                        <p><?= $_SESSION['errorEmail'] ?></p>
                    </div>
            <?php endif;
            endif; ?>
            <?php if ($acf['gratuito'] == 'false') : ?>
                <form id="formInscricao" name="formInscricao" action="<?= site_url() ?>/forma-pagamento" method="post" novalidate="novalidate">
                <?php else : ?>
                    <form id="formInscricao" name="formInscricao" action="<?= the_permalink() . "?id=" . $_GET['id'] ?>" method="post" novalidate="novalidate">
                    <?php endif; ?>
                    <input type="hidden" name="treinamento_id" value="<?= $_GET['id'] ?>">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="nome_completo" name="nome_completo" placeholder="Ex: José Carlos da Silva" data-error=".errorNome" minlength="5" maxlength="50" required value="<?= isset($value) ? $value['nome_completo'] : null ?>">
                            <label for="nome_completo">Nome completo</label>
                            <div class="errorNome"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="data_nascimento" name="data_nascimento" data-error=".errorData" placeholder="00/00/0000" value="<?= isset($value) ? $value['data_nascimento'] : null ?>">
                            <label for="data_nascimento">Data de nascimento</label>
                            <div class="errorData"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="cpf" name="cpf" placeholder="Ex: 000.000.000-00" data-error=".errorCPF" value="<?= isset($value) ? $value['cpf'] : null ?>">
                            <label for="cpf">Seu CPF</label>
                            <div class="errorCPF"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email" id="email" name="email" placeholder="Ex: josecarlos@seuprovedor.com" data-error=".errorEmail" value="<?= isset($value) ? $value['email'] : null ?>">
                            <label for="email">E-mail</label>
                            <div class="errorEmail"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="tel" id="telefone" name="telefone" placeholder="Ex: (00) 0000-0000" data-error=".errorTelefone" value="<?= isset($value) ? $value['telefone'] : null ?>">
                            <label for="telefone">Telefone:</label>
                            <div class="errorTelefone"></div>
                        </div>
                        <div class="col s1"></div>
                        <div class="input-field col s6">
                            <input type="tel" id="celular" name="celular" placeholder="Ex: (00) 00000-0000" data-error=".errorCelular" value="<?= isset($value) ? $value['celular'] : null ?>">
                            <label for="celular">Celular:</label>
                            <div class="errorCelular"></div>
                        </div>
                    </div>
                    <div class="row">
                        <fieldset class="col s12">
                            <legend>Endereço</legend>
                            <div class="row">
                                <div class="input-field col s12 m6">
=======
                    <div class="col s11 card-panel red accent-1">
                        <p><?= $_SESSION['errorCPF'] ?></p>
                    </div>
                <?php endif;
                    if (isset($_SESSION['errorEmail'])) : ?>
                    <div class="col s11 card-panel red accent-1">
                        <p><?= $_SESSION['errorEmail'] ?></p>
                    </div>
            <?php endif;
            endif; ?>
            <?php if ($acf['gratuito'] == 'false') : ?>
                <form id="formInscricao" name="formInscricao" action="<?= site_url() ?>/forma-pagamento" method="post" novalidate="novalidate">
                    <p>Pago <?= site_url() ?>/forma-pagamento</p>
                <?php else : ?>
                    <form id="formInscricao" name="formInscricao" action="<?= the_permalink() . "?id=" . $_GET['id'] ?>" method="post" novalidate="novalidate">
                        <p>Gratuito</p>
                    <?php endif; ?>
                    <input type="hidden" name="treinamento_id" value="<?= $_GET['id'] ?>">
                    <div class="row">
                        <div class="input-field col s11">
                            <input type="text" id="nome_completo" name="nome_completo" placeholder="Ex: José Carlos da Silva" data-error=".errorNome" minlength="5" maxlength="50" required value="<?= isset($value) ? $value['nome_completo'] : null ?>">
                            <label for="nome_completo">Nome completo</label>
                            <div class="errorNome"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s11">
                            <input type="text" id="data_nascimento" name="data_nascimento" data-error=".errorData" placeholder="00/00/0000" value="<?= isset($value) ? $value['data_nascimento'] : null ?>">
                            <label for="data_nascimento">Data de nascimento</label>
                            <div class="errorData"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s11">
                            <input type="text" id="cpf" name="cpf" placeholder="Ex: 000.000.000-00" data-error=".errorCPF" value="<?= isset($value) ? $value['cpf'] : null ?>">
                            <label for="cpf">Seu CPF</label>
                            <div class="errorCPF"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s11">
                            <input type="email" id="email" name="email" placeholder="Ex: josecarlos@seuprovedor.com" data-error=".errorEmail" value="<?= isset($value) ? $value['email'] : null ?>">
                            <label for="email">E-mail</label>
                            <div class="errorEmail"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s5">
                            <input type="tel" id="telefone" name="telefone" placeholder="Ex: (00) 0000-0000" data-error=".errorTelefone" value="<?= isset($value) ? $value['telefone'] : null ?>">
                            <label for="telefone">Telefone:</label>
                            <div class="errorTelefone"></div>
                        </div>
                        <div class="col s1"></div>
                        <div class="input-field col s5">
                            <input type="tel" id="celular" name="celular" placeholder="Ex: (00) 00000-0000" data-error=".errorCelular" value="<?= isset($value) ? $value['celular'] : null ?>">
                            <label for="celular">Celular:</label>
                            <div class="errorCelular"></div>
                        </div>
                    </div>
                    <div class="row">
                        <fieldset class="col s11">
                            <legend>Endereço</legend>
                            <div class="row">
                                <div class="input-field col s4">
>>>>>>> d7caca1bc3f764ea5eaa234c1ee0f5179b3aa43e
                                    <input type="text" id="cep" name="cep" placeholder="Ex: 0000-000" data-error=".errorCEP" value="<?= isset($value) ? $value['cep'] : null ?>">
                                    <label for="cep">CEP</label>
                                    <div class="errorCEP">
                                        <span class="errorCEP_api"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
<<<<<<< HEAD
                                    <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua Aleatória" data-error=".errorEndereco" value="<?= isset($value) ? $value['endereco'] : null ?>">
                                    <label for="endereco">Endereço</label>
                                    <div class="errorEndereco"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s4 m2">
                                    <input type="text" id="num" name="num" placeholder="Ex: 000" data-error=".errorNum" value="<?= isset($value) ? $value['num'] : null ?>">
                                    <label for="endereco">Número: </label>
                                    <div class="errorNum"></div>
                                </div>
                                <div class="col s2"></div>
                                <div class="input-field col s4">
                                    <input type="text" id="complemento" name="complemento" placeholder="Ex: Bloco A" data-error=".errorComplemento" value="<?= isset($value) ? $value['complemento'] : null ?>">
                                    <label for="complemento">Complemento: </label>
                                    <div class="errorComplemento"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <input type="text" id="bairro" name="bairro" placeholder="Ex: America" data-error=".errorBairro" value="<?= isset($value) ? $value['bairro'] : null ?>">
                                    <label for="bairro">Bairro</label>
                                    <div class="errorBairro"></div>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input type="text" id="cidade" name="cidade" placeholder="Ex: São Paulo" data-error=".errorCidade" value="<?= isset($value) ? $value['cidade'] : null ?>">
                                    <label for="cidade">Cidade</label>
                                    <div class="errorCidade"></div>
                                </div>
                                <div class="input-field col s12 m4">
                                    <input type="text" id="estado" name="estado" placeholder="Ex: São Paulo" data-error=".errorEstado" value="<?= isset($value) ? $value['estado'] : null ?>">
                                    <label for="estado">Estado</label>
                                    <div class="errorCidade"></div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button class="btn-large color-custom waves-effect waves-light light-blue lighten-2" type="submit" name="submit">Cadastrar
=======
                                    <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua Aleatória" value="<?= isset($value) ? $value['endereco'] : null ?>">
                                    <label for="endereco">Endereço</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s4">
                                    <input type="text" id="bairro" name="bairro" placeholder="Ex: America" value="<?= isset($value) ? $value['bairro'] : null ?>">
                                    <label for="bairro">Bairro</label>
                                </div>
                                <div class="input-field col s4">
                                    <input type="text" id="cidade" name="cidade" placeholder="Ex: São Paulo" value="<?= isset($value) ? $value['cidade'] : null ?>">
                                    <label for="cidade">Cidade</label>
                                </div>
                                <div class="input-field col s4">
                                    <input type="text" id="estado" name="estado" placeholder="Ex: São Paulo" value="<?= isset($value) ? $value['estado'] : null ?>">
                                    <label for="estado">Estado</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row">
                        <div class="col s11">
                            <button class="btn-large color-custom waves-effect waves-light" type="submit" name="submit">Enviar
>>>>>>> d7caca1bc3f764ea5eaa234c1ee0f5179b3aa43e
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                    </form>
<<<<<<< HEAD
=======
        </section>
        <section class="col s4 card-panel center-align">
            <?= $thumb ?>
            <h3 id="title-form"><?= $treinamento_wp->post_title ?></h3>
            <p><?= $acf['chamada'] ?></p>
            <div class="valor">
                <?php if ($acf['gratuito'] == "true") : ?>
                    <span class="gratuito">Este é um treinamento gratuito</span>
                <?php else : ?>
                    <span class="preco">R$<?= $acf['valor'] ?></span>
                <?php endif; ?>
            </div>
            <div class="vagas">
                <p><?= $acf['vagas'] ?> vagas sobrando.</p>
            </div>
>>>>>>> d7caca1bc3f764ea5eaa234c1ee0f5179b3aa43e
        </section>
    </div>
</main>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="<?= get_template_directory_uri() . '/js/mask/dist/jquery.mask.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/jquery.validate.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/additional-methods.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/form.js' ?>"></script>
<script>

</script>
<?php get_footer();
session_destroy(); ?>
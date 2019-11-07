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
        <h2 class='title'>Inscrição</h2>
    </div>
    <div class="row">
        <section class="col s8 section-form">
            <form id="formInscricao">
                <div class="row">
                    <div class="input-field col s11">
                        <input type="text" id="nome_completo" name="nome_completo" placeholder="Ex: José Carlos da Silva" data-error=".errorNome" minlength="5" required>
                        <label for="nome_completo">Nome completo</label>
                        <div class="errorNome"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11">
                        <input type="date" id="data_nascimento" name="data_nascimento" data-error=".errorData">
                        <label for="data_nascimento">Data de nascimento</label>
                        <div class="errorData"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s11">
                        <input type="text" id="cpf" name="cpf" placeholder="Ex: 000.000.000-00" data-error=".errorCPF">
                        <label for="cpf">Seu CPF</label>
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
                        <input type="tel" id="telefone" name="telefone" placeholder="Ex: (00) 0000-0000">
                        <label for="telefone">Telefone:</label>
                    </div>
                    <div class="col s1"></div>
                    <div class="input-field col s5">
                        <input type="tel" id="celular" name="celular" placeholder="Ex: (00) 00000-0000">
                        <label for="celular">Celular:</label>
                    </div>
                </div>
                <div class="row">
                    <fieldset class="col s11">
                        <legend>Endereço</legend>
                        <div class="row">
                            <div class="input-field col s4">
                                <input type="text" id="cep" name="cep" placeholder="Ex: 0000-000">
                                <label for="cep">CEP</label>
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
<script src="<?= get_template_directory_uri() . '/js/validation/dist/jquery.validate.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/jquery.validate.min.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/additional-methods.js' ?>"></script>
<script src="<?= get_template_directory_uri() . '/js/validation/dist/additional-methods.min.js' ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {

        /** API CEP **/
        function limpa_formulário_cep() {
            $("#endereco").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#estado").val("");
        }

        $("#cep").blur(function() {
            var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {
                    $("#endereco").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#estado").val("...");

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            $("#endereco").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#estado").val(dados.uf);
                        } else {
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        });

        /** JQuery Mask **/
        var SPMask = function(val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMask.apply({}, arguments), options);
                }
            };

        $('#cpf').mask('000.000.000-00', {
            reverse: true
        });
        $('#telefone').mask('(00) 0000-0000');
        $('#celular').mask(SPMask, spOptions);
        $('#cep').mask('00000-000');

        /** JQuery Validation **/

        $("#formInscricao").validate({
            lang: 'pt_BR',
            rules: {
                nome_completo: {
                    required: true,
                    minlength: 5
                },
                data_nascimento: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                nome_completo: {
                    required: "Digite seu nome.",
                    minlength: "O nome deve conter pelo menos 5 caracteres."
                },
                data_nascimento: {
                    required: "Coloque a data de seu nascimento."
                },
                email: {
                    required: "Digite seu e-mail.",
                    email: "Utilize um e-mail válido"
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).addClass("error");
                    $(placement).append(error);
                } else {
                    error.inserAfter(element);
                }
            }
        })
    });
</script>

<?php get_footer(); ?>
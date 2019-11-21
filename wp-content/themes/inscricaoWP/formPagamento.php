<?php
/* Template Name: Formulário Pagamento Inscritos */
$validCpf = validateCPF();
$validEmail = validateEmail();
if ($validCpf && $validEmail) {
    get_header();
    include(get_template_directory() . "/pagseguro/configuracao.php");
    if (isset($_POST['submit'])) { }
    $treinamento_acf = get_fields($_POST['treinamento_id']);
    ?>

    <main class="container">
        <div class="row valign-wrapper">
            <div class="col s11">
                <h2 class='title form-title'>Ficha de Inscrição</h2>
                <h3 class='form-subtitle'>Forma de pagamento</h3>
            </div>
            <div class="col s1">
                <a href="<?= site_url() ?>" class="btn-floating hoverable btn-large waves-effect waves-light light-blue lighten-2" title="Voltar para a página inicial">
                    <i class="material-icons">home</i></a>
            </div>
        </div>

        <section class="row card-panel">
            <div class="error-transacao" id="error-transacao"></div>
            <form id="formPagamento" name="formPagamento" class="col s12">
                <div class="load center"></div>
                <div class="row">
                    <div class="meio-pag"></div>
                </div>

                <!-- Informações do treinamento -->
                <input type="hidden" name="treinamento_id" value="<?= $_POST['treinamento_id'] ?>">
                <input type="hidden" id="valor_total" value="<?= $treinamento_acf['valor'] ?>">
                <!-- Informações do inscrito -->
                <input type="hidden" name="nome_completo" value="<?= $_POST['nome_completo'] ?>">
                <input type="hidden" name="data_nascimento" value="<?= $_POST['data_nascimento'] ?>">
                <input type="hidden" name="cpf" value="<?= $_POST['cpf'] ?>">
                <input type="hidden" name="email" value="<?= $_POST['email'] ?>">
                <input type="hidden" name="telefone" value="<?= $_POST['telefone'] ?>">
                <input type="hidden" name="celular" value="<?= $_POST['celular'] ?>">
                <input type="hidden" name="cep" value="<?= $_POST['cep'] ?>">
                <input type="hidden" name="endereco" value="<?= $_POST['endereco'] ?>">
                <input type="hidden" name="num" value="<?= $_POST['num'] ?>">
                <input type="hidden" name="complemento" value="<?= $_POST['complemento'] ?>">
                <input type="hidden" name="bairro" value="<?= $_POST['bairro'] ?>">
                <input type="hidden" name="cidade" value="<?= $_POST['cidade'] ?>">
                <input type="hidden" name="estado" value="<?= $_POST['estado'] ?>">

                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="Nome impresso no cartão" id="nome_cartao" name="nome-cartao" type="text" data-error=".errorNomeCartao" maxlength="50">
                        <label for="nome-cartao">Nome no cartão:</label>
                        <div class="errorNomeCartao"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input placeholder="N° do cartão" id="num_cartao" name="num-cartao" type="text" maxlength="16" data-error=".errorCartao">
                        <label for="num-cartao">N° do Cartão</label>
                        <div id="erro-cartao" class="errorCartao"></div>
                    </div>
                    <div class="col s4" id="div-bandeira" style=""></div>
                </div>
                <div class="row">
                    <div class="input-field col s6 m4 l2">
                        <input placeholder="00/0000" id="vencimento_cartao" name="vencimento-cartao" type="text" data-error=".errorVencimento">
                        <label for="vencimento-cartao">Vencimento do cartão: </label>
                        <div class="errorVencimento"></div>
                    </div>
                    <div class="col s1"></div>
                    <div class="input-field col s6 m4 l2">
                        <label for="cvv-cartao">CVV: </label>
                        <input placeholder="CVV" id="cvv_cartao" name="cvv-cartao" type="text" data-error=".errorCvv" maxlength="3">
                        <span class="helper-text">Código de segurança</span>
                        <div class="errorCvv"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" id="divParcelas" style="display: none;">
                        <select name='qtdParcelas' id='qtdParcelas' class='select-qtd-parcelas' data-error=".errorParcelas">
                            <option value="">Selecione</option>
                        </select>
                        <label for="qtdParcelas">Parcelas: </label>
                        <div class="errorParcelas"></div>
                    </div>
                </div>

                <!-- Cartão -->
                <input id="valor-parcela" name="valor-parcela" type="hidden">
                <input id="card-band" name="card-band" type="hidden">
                <input id="card-token" name="card-token" type="hidden">
                <input id="hash" name="hash" type="hidden">

                <div class="row">
                    <div class="col s12">
                        <button class="btn" id="pagamento">Confirmar</button>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="<?= get_template_directory_uri() . '/js/mask/dist/jquery.mask.min.js' ?>"></script>
    <script src="<?= get_template_directory_uri() . '/js/validation/dist/jquery.validate.min.js' ?>"></script>
    <script src="<?= get_template_directory_uri() . '/js/validation/dist/additional-methods.min.js' ?>"></script>
    <script src="<?= SCRIPT_PAGSEGURO ?>"></script>
    <script>
        var amount = $('#valor_total').val();

        $(document).ready(function() {

            var endereco = '<?= URL ?>';

            $.ajax({
                url: endereco + "/pagseguro-sessao",
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    $('.load').append("<img src='<?= get_template_directory_uri() ?>/images/load.gif' width='50'>");
                    $('#pagamento').prop('disabled', true);
                },
                success: function(data) {
                    //ID da sessão retornada pelo PagSeguro
                    PagSeguroDirectPayment.setSessionId(data.id);
                },
                complete: function(retorno) {
                    listarMeioPag();
                }
            })

            $("#num_cartao").bind('paste', function(e) {
                e.preventDefault();
            });

            $('#num_cartao').mask("0000 0000 0000 0000");
            $('#vencimento_cartao').mask("00/0000");
            $('#cvv_cartao').mask("#");

        })

        function listarMeioPag() {
            PagSeguroDirectPayment.getPaymentMethods({
                amount: amount,
                success: function(retorno) {
                    $('.meio-pag').append("<p style='padding: 0 8px;'>Cartão de Crédito</p>");
                    $.each(retorno.paymentMethods.CREDIT_CARD.options, function(i, obj) {
                        $('.meio-pag').append("<span class='img-band' style='padding: 0 8px;'><img src='https://stc.pagseguro.uol.com.br" + obj.images.SMALL.path + "'></span>");
                    });
                },
                error: function() {
                    $('.meio-pag').html('Falha ao receber Informações de pagamento');
                },
                complete: function() {
                    $('.load').empty();
                    $('#pagamento').prop('disabled', false);
                }
            });

        }

        $('#num_cartao').on('blur', function() {
            var numCartao = $(this).val().split(' ').join('');
            var qtdNumero = numCartao.length;
            if (qtdNumero > 6) {
                PagSeguroDirectPayment.getBrand({
                    cardBin: numCartao,
                    success: function(data) {
                        $("#erro-cartao").empty();

                        var imgBand = data.brand.name;
                        $('#div-bandeira').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png'>");
                        $('#card-band').val(data.brand.name);
                        recupParcelas(imgBand);
                    },
                    error: function(data) {
                        $('#div-bandeira').empty();
                        $('#erro-cartao').html("Cartão inválido");
                    }
                })
            }
        });

        $("#qtdParcelas").change(function() {
            $('#valor-parcela').val($("#qtdParcelas").find(':selected').attr('data-parcela'));
        })

        function recupParcelas(bandeira) {
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                maxInstallmentNoInterest: 2,
                brand: bandeira,
                success: function(response) {
                    $('#divParcelas').show();
                    $.each(response.installments, function(ia, obja) {
                        $.each(obja, function(ib, objb) {
                            var valorParcela = objb.installmentAmount.toFixed(2).replace(".", ",");
                            if (objb.interestFree) {
                                $('#qtdParcelas').append("<option value='" + objb.quantity + "' data-parcela='" + objb.installmentAmount.toFixed(2) + "'>" + objb.quantity + "x de R$ " + valorParcela + " sem juros</option>");
                            } else {
                                $('#qtdParcelas').append("<option value='" + objb.quantity + "' data-parcela='" + objb.installmentAmount.toFixed(2) + "'>" + objb.quantity + "x de R$ " + valorParcela + "</option>");

                            }
                            $('#qtdParcelas').formSelect();
                        })
                    })
                },
                error: function(response) {
                    // callback para chamadas que falharam.
                    // console.log(response)
                },
                complete: function(response) {
                    // Callback para todas chamadas.
                }
            });

        }

        $('#formPagamento').on('submit', function(e) {
            e.preventDefault();
            $('#pagamento').prop('disabled', true);

            PagSeguroDirectPayment.createCardToken({
                cardNumber: $('#num_cartao').val().split(' ').join(''), // Número do cartão de crédito
                brand: $('#card-band').val(), // Bandeira do cartão
                cvv: $("#cvv_cartao").val(), // CVV do cartão
                expirationMonth: $('#vencimento_cartao').val().split('/')[0], // Mês da expiração do cartão
                expirationYear: $('#vencimento_cartao').val().split('/')[1], // Ano da expiração do cartão, é necessário os 4 dígitos.
                success: function(response) {
                    // Retorna o cartão tokenizado.
                    $('#card-token').val(response.card.token)
                },
                error: function(response) {
                    console.log(response)
                },
                complete: function(response) {
                    // Callback para todas chamadas.
                    recupHashCartao();
                }
            });
        })

        function recupHashCartao() {
            PagSeguroDirectPayment.onSenderHashReady(function(response) {
                if (response.status == 'error') {
                    console.log(response.message);
                    return false;
                } else {
                    $('#hash').val(response.senderHash);
                    var data = $('#formPagamento').serialize();
                    $.ajax({
                        method: "POST",
                        url: '<?= site_url() ?>/checkout',
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {
                            $('.load').append("<img src='<?= get_template_directory_uri() ?>/images/load.gif' width='50'>");
                        },
                        success: function(data) {
                            // console.log(data)
                            if (data.error) {
                                // console.log(data);
                                $('#error-transacao').empty();
                                if (data.error.code == 53122) {
                                    $('#error-transacao').append("<div class='row'> <div class='col s12 card-panel red accent-1'> <p>Domínio de e-mail inválido para efetuar a transação (*Sandbox)</p> </div> </div>");
                                } else {
                                    $('#error-transacao').append("<div class='row'> <div class='col s12 card-panel red accent-1'> <p>Ocorreu um erro na transação, por favor verifique se os dados do cartão estão corretos</p> </div> </div>");
                                }
                            } else {
                                $('#error-transacao').empty();
                                window.location.replace('<?= home_url() ?>');
                            }
                            $('.load').empty();
                            $('#pagamento').prop('disabled', false);
                        },
                        error: function(data) {
                            $('#error-transacao').append("<div class='row'> <div class='col s12 card-panel red accent-1'> <p>Ocorreu um erro na transação, tente novamente mais tarde.</p> </div> </div>");
                        },
                        complete: function() {

                        }
                    });
                }
            });
        }
    </script>
<?php
    get_footer();
} else {
    session_start(); // Inicia a sessão
    if (!$validCpf) $_SESSION['errorCPF'] = 'CPF já cadastrado neste treinamento';
    if (!$validEmail) $_SESSION['errorEmail'] = "E-mail já cadastrado neste treinamento";
    saveInputsValue();
    wp_redirect(site_url() . '/cadastro/?id=' . $_POST['treinamento_id']);
    ?>
<?php
}
?>
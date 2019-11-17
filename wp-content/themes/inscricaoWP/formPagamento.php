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
        <section class="row">

            <div class="error-transacao" id="error-transacao"></div>
            <form id="formPagamento" name="formPagamento" class="col s12">

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
                <input type="hidden" name="bairro" value="<?= $_POST['bairro'] ?>">
                <input type="hidden" name="cidade" value="<?= $_POST['cidade'] ?>">
                <input type="hidden" name="estado" value="<?= $_POST['estado'] ?>">

                <div class="row">
                    <div class="input-field col s8">
                        <input placeholder="Nome impresso no cartão" id="nome-cartao" name="nome-cartao" type="text">
                        <label for="nome-cartao">Nome no cartão:</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <input placeholder="N° do cartão" id="num-cartao" name="num-cartao" type="text" minlength="16" maxlength="16">
                        <label for="num-cartao">N° do Cartão</label>
                        <div id="erro-cartao"></div>
                    </div>
                    <div class="col s4" id="div-bandeira" style=""></div>
                </div>
                <div class="row">
                    <div class="input-field col s2">
                        <input placeholder="00/0000" id="vencimento-cartao" name="vencimento-cartao" type="text">
                        <label for="vencimento-cartao">Vencimento do cartão: </label>
                    </div>
                    <div class="col s1"></div>
                    <div class="input-field col s2">
                        <label for="cvv-cartao">CVV: </label>
                        <input placeholder="CVV" id="cvv-cartao" name="cvv-cartao" type="text">
                        <span class="helper-text">Código de segurança</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6" id="divParcelas" style="display: none;">
                        <select name='qtdParcelas' id='qtdParcelas' class='select-qtd-parcelas'>
                            <option value="">Selecione</option>
                        </select>
                        <label for="qtdParcelas">Parcelas: </label>
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
    <script src="<?= SCRIPT_PAGSEGURO ?>"></script>
    <script>
        var amount = $('#valor_total').val();

        $(document).ready(function() {

            var endereco = '<?= URL ?>';

            $.ajax({
                url: endereco + "/pagseguro-sessao",
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    //ID da sessão retornada pelo PagSeguro
                    PagSeguroDirectPayment.setSessionId(data.id);
                },
                complete: function(retorno) {
                    listarMeioPag();
                }
            })

        })

        function listarMeioPag() {
            PagSeguroDirectPayment.getPaymentMethods({
                amount: amount,
                success: function(response) {
                    // Retorna os meios de pagamento disponíveis.
                },
                error: function(response) {
                    // Callback para chamadas que falharam.
                },
                complete: function(response) {
                    // recupTokenCartao();
                }
            });

        }

        $('#num-cartao').on('blur', function() {
            var numCartao = $(this).val();
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

            PagSeguroDirectPayment.createCardToken({
                cardNumber: $('#num-cartao').val(), // Número do cartão de crédito
                brand: $('#card-band').val(), // Bandeira do cartão
                cvv: $("#cvv-cartao").val(), // CVV do cartão
                expirationMonth: $('#vencimento-cartao').val().split('/')[0], // Mês da expiração do cartão
                expirationYear: $('#vencimento-cartao').val().split('/')[1], // Ano da expiração do cartão, é necessário os 4 dígitos.
                success: function(response) {
                    // Retorna o cartão tokenizado.
                    $('#card-token').val(response.card.token)
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
                        // dataType: 'json',
                        success: function(data) {
                            console.log(data)
                            if (data.error) {
                                $('#error-transacao').empty();
                                $('#error-transacao').append("<div class='row'> <div class='col s12 card-panel red accent-1'> <p>Ocorreu um erro na transação, por favor verifique se os dados do cartão estão corretos</p> </div> </div>");
                            } else {
                                $('#error-transacao').empty();
                            }
                        },
                        error: function(data) {
                            console.log(data);
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
    if(!$validCpf) $_SESSION['errorCPF'] = 'CPF já cadastrado neste treinamento';
    if(!$validEmail) $_SESSION['errorEmail'] = "E-mail já cadastrado neste treinamento";
    saveInputsValue();
    wp_redirect(site_url().'/cadastro/?id='.$_POST['treinamento_id']);
    ?>
<?php
}
?>
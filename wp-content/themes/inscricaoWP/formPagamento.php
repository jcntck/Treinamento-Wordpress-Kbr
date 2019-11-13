<?php
/* Template Name: Formulário Pagamento Inscritos */
get_header();
include(get_template_directory() . "/pagseguro/configuracao.php");
?>

<main class="container">
    <section class="row">
        <p style="margin-top:50px;"></p>
        <!-- <form class="col s12"> -->
        <div class="row">
            <div class="input-field col s8">
                <input placeholder="N° do cartão" id="num-cartao" name="num-cartao" type="text">
                <label for="num-cartao">N° do Cartão</label>
                <div id="erro-cartao"></div>
            </div>
            <div class="col s4" id="div-bandeira" style=""></div>
        </div>
        <div class="row">
            <div class="input-field col s2">
                <input placeholder="00/0000" id="vencimento-cartao" name="vencimento-cartao" type="text">
                <label for="num-cartao">Vencimento do cartão: </label>
            </div>
            <div class="col s1"></div>
            <div class="input-field col s2">
                <label for="cvv-cartao">CVV: </label>
                <input placeholder="CVV" id="cvv-cartao" name="cvv-cartao" type="text">
                <span class="helper-text">Código de segurança</span>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <select name='qtdParcelas' id='qtdParcelas' class='select-qtd-parcelas'>

                </select>
                <label for="qtdParcelas">Parcelas: </label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn" id="pagamento">Confirmar</button>
            </div>
        </div>
        <!-- </form> -->
        <!-- Temporário -->
        <div class="input-field col">
            <input disabled id="card-token" name="card-token" type="text">
            <label for="card-token">CardToken</label>
        </div>
    </section>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?= SCRIPT_PAGSEGURO ?>"></script>
<script>
    var amount = "600.00";
    $(document).ready(function() {

        var endereco = '<?= URL ?>';

        $.ajax({
            url: endereco + "/pagamento",
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                //ID da sessão retornada pelo PagSeguro
                PagSeguroDirectPayment.setSessionId(data.id);
            }
        })

    })

    $('#num-cartao').on('keyup', function() {
        var numCartao = $(this).val();
        var qtdNumero = numCartao.length;

        if (qtdNumero == 6) {
            // console.log(numCartao)
            PagSeguroDirectPayment.getBrand({
                cardBin: numCartao,
                success: function(data) {
                    $("#erro-cartao").empty();

                    var imgBand = data.brand.name;
                    $('#div-bandeira').html("<img src='https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/42x20/" + imgBand + ".png'>");
                    recupParcelas(imgBand);
                },
                error: function(data) {
                    $('#div-bandeira').empty();
                    $('#erro-cartao').html("Cartão inválido");
                }
            })
        }
    });

    function recupParcelas(bandeira) {
        PagSeguroDirectPayment.getInstallments({
            amount: amount,
            maxInstallmentNoInterest: 2,
            brand: bandeira,
            success: function(response) {
                $.each(response.installments, function(ia, obja) {
                    $.each(obja, function(ib, objb) {
                        var valorParcela = objb.installmentAmount.toFixed(2).replace(".", ",");
                        console.log("<option value='" + objb.installmentAmount + "'>" + objb.quantity + "x de R$ " + valorParcela + "</option>")
                        $('#qtdParcelas').append("<option value='" + objb.installmentAmount + "'>" + objb.quantity + "x de R$ " + valorParcela + "</option>");
                    })
                })
            },
            error: function(response) {
                // callback para chamadas que falharam.
                // console.log(response)
            },
            complete: function(response) {
                // Callback para todas chamadas.
                // console.log(response)
            }
        });
        $('select').formSelect();
    }

    function recupTokenCartao() {
        PagSeguroDirectPayment.createCardToken({
            cardNumber: '4111111111111111', // Número do cartão de crédito
            brand: 'visa', // Bandeira do cartão
            cvv: '123', // CVV do cartão
            expirationMonth: '12', // Mês da expiração do cartão
            expirationYear: '2030', // Ano da expiração do cartão, é necessário os 4 dígitos.
            success: function(response) {
                // Retorna o cartão tokenizado.
                console.log(response)
                $('#card-token').val(response)
            },
            error: function(response) {
                // Callback para chamadas que falharam.
                console.log(response)
            },
            complete: function(response) {
                // Callback para todas chamadas.
                console.log(response)
            }
        });
    }
    $(document).ready(function (){
        recupTokenCartao();
    })
</script>
<?php get_footer(); ?>
$(document).ready(function() {

    /** API CEP **/
    function limpa_formulário_cep() {
        $("#endereco").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
        $(".errorCEP_api").empty();
    }

    function mostra_erro_cep(error) {
        var placement = $("#cep").data('error') + "_api";
        if (placement) {
            $(placement).addClass("error");
            $(placement).append('<div id="cep-error" class="error">' + error + '</div>');
        }
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
                        mostra_erro_cep("CEP não encontrado.");
                    }
                });
            } else {
                limpa_formulário_cep();
                mostra_erro_cep("Formato de CEP inválido.");
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

    $('#data_nascimento').mask('00/00/0000');
    $('#cpf').mask('000.000.000-00', { reverse: true });
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask(SPMask, spOptions);
    $('#cep').mask('00000-000');
    $('#num').mask("#");

    /** JQuery Validation **/
    $("#formInscricao").validate({
        rules: {
            nome_completo: {
                required: true,
                minlength: 8
            },
            data_nascimento: {
                required: true,
                dateFormat: true
            },
            cpf: {
                required: true,
                cpf: true
            },
            email: {
                required: true,
                email: true
            },
            telefone: {
                required: true,
                minlength: 14
            },
            celular: {
                required: true,
                minlength: 14
            },
            cep: {
                required: true
            },
            endereco: {
                required: true
            },
            num: {
                required: true,
                number: true
            },
            complemento: {
                maxlength: 18
            },
            bairro: {
                required: true
            },
            cidade: {
                required: true
            },
            estado: {
                required: true
            }
        },
        messages: {
            nome_completo: {
                required: "Coloque o seu nome.",
                minlength: "O nome deve conter pelo menos 8 caracteres."
            },
            data_nascimento: {
                required: "Coloque a data de seu nascimento."
            },
            cpf: {
                required: "Coloque o seu CPF"
            },
            email: {
                required: "Coloque o seu e-mail.",
                email: "Utilize um e-mail válido"
            },
            telefone: {
                required: "Coloque o seu telefone",
                minlength: "Informe um telefone válido"
            },
            celular: {
                required: "Coloque o seu celular",
                minlength: "Informe um celular válido"
            },
            cep: {
                required: "Coloque o seu CEP"
            },
            endereco: {
                required: "Coloque o seu endereço"
            },
            num: {
                required: "Coloque o seu numero"
            },
            complemento: {
                maxlength: "O complemento deve conter no máximo 18 caracteres"
            },
            bairro: {
                required: "Coloque o seu bairro"
            },
            cidade: {
                required: "Coloque a sua cidade"
            },
            estado: {
                required: "Coloque o seu estado"
            }
        },
        errorElement: 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).addClass("error");
                $(placement).append(error);
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod(
        "dateFormat",
        function(value, element) {
            var check = false;
            var re = /^|d{1,2}\-\d{1,2}\-\d{4}$/;

            if (re.test(value)) {

                var adata = value.split('/');
                var dd = parseInt(adata[0], 10);
                var mm = parseInt(adata[1], 10);
                var yyyy = parseInt(adata[2], 10);
                var xdata = new Date(yyyy, mm - 1, dd);

                if ((xdata.getFullYear() === yyyy) && (xdata.getMonth() === mm - 1) && (xdata.getDate() === dd)) {
                    var curYear = new Date().getFullYear();
                    if (yyyy > 1900 && yyyy <= curYear) check = true;
                    else check = false;
                } else {
                    check = false;
                }
            } else {
                check = false;
            }
            return this.optional(element) || check;
        },
        "Digite uma data válida"
    );

    $.validator.addMethod(
        "cpf",
        function(value, element) {
            value = value.replace('.', '');
            value = value.replace('.', '');
            cpf = value.replace('-', '');

            while (cpf.length < 11) cpf = "0" + cpf;
            var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;

            var a = [];
            var b = new Number;
            var c = 11;

            for (i = 0; i < 11; i++) {
                a[i] = cpf.charAt(i);
                if (i < 9) b += (a[i] * --c);
            }

            if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11 - x }
            b = 0;
            c = 11;
            for (y = 0; y < 10; y++) b += (a[y] * c--);
            if ((x = b % 11) < 2) { a[10] = 0 } else { a[10] = 11 - x }

            var check = true;
            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) check = false;

            return this.optional(element) || check;
        },
        "Informe um CPF válido"
    );

});
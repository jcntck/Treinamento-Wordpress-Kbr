<?php
/* Template Name: Checkout Pagamento */
include_once 'configuracao.php';
if (cadastrarInscrito()) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $treinamento_wp = get_post($dados['treinamento_id']);
    $treinamento_acf = get_fields($dados['treinamento_id']);

    $checkout['email'] = EMAIL_PAGSEGURO;
    $checkout['token'] = TOKEN_PAGSEGURO;

    $checkout['paymentMode'] = 'default';
    $checkout['paymentMethod'] = 'creditCard';
    $checkout['currency'] = 'BRL';
    $checkout['itemId1'] = $dados['treinamento_id'];
    $checkout['itemDescription1'] = $treinamento_wp->post_title;
    $checkout['itemAmount1'] = $treinamento_acf['valor'];
    $checkout['itemQuantity1'] = 1;
    $checkout['senderName'] = $dados['nome_completo'];
    $checkout['senderCPF'] = just_number($dados['cpf']);
    $checkout['senderAreaCode'] = substr($dados['telefone'], 1, 2);
    $checkout['senderPhone'] = str_replace('-', "", substr($dados['telefone'], 5));
    $checkout['senderEmail'] = $dados['email'];
    $checkout['senderHash'] = $dados['hash'];
    $checkout['billingAddressStreet'] = $dados['endereco'];
    $checkout['billingAddressNumber'] = '147';
    $checkout['billingAddressComplement'] = 'apto 66';
    $checkout['billingAddressDistrict'] = $dados['bairro'];
    $checkout['billingAddressPostalCode'] = just_number($dados['cep']);
    $checkout['billingAddressCity'] = $dados['cidade'];
    $checkout['billingAddressState'] = $dados['estado'];
    $checkout['billingAddressCountry'] = 'BRA';
    $checkout['creditCardToken'] = $dados['card-token'];
    $checkout['installmentQuantity'] = $dados['qtdParcelas'];
    $checkout['installmentValue'] = $dados['valor-parcela'];
    $checkout['noInterestInstallmentQuantity'] = 2;
    $checkout['creditCardHolderName'] = $dados['nome-cartao'];
    $checkout['creditCardHolderCPF'] = just_number($dados['cpf']);
    $checkout['creditCardHolderBirthDate'] = $dados['data_nascimento'];
    $checkout['creditCardHolderAreaCode'] = substr($dados['telefone'], 1, 2);
    $checkout['creditCardHolderPhone'] = str_replace('-', "", substr($dados['telefone'], 5));
    $checkout['shippingAddressRequired'] = false;
    $checkout['notificationURL'] = site_url() . '/notificacao';

    $buildQuery = http_build_query($checkout);
    $url = URL_PAGSEGURO . "transactions";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);
    $dataXml = curl_exec($curl);
    curl_close($curl);

    $data = simplexml_load_string($dataXml);
    if (isset($data->error)) {
        global $wpdb;
        $id = $wpdb->insert_id;
        apagarInscrito($id);
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
} else {
    $data['error'] = "Não foi possivel realizar seu cadastro, tente novamente mais tarde";
}

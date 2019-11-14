<?php
/* Template Name: Checkout Pagamento */
include_once 'configuracao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$treinamento_wp = get_post($dados['treinamento_id']);
$treinamento_acf = get_fields($dados['treinamento_id']);

$checkout['email']=EMAIL_PAGSEGURO;
$checkout['token']=TOKEN_PAGSEGURO;

$checkout['paymentMode']='default';
$checkout['paymentMethod']='creditCard';
$checkout['currency']='BRL';
$checkout['itemId1']=$dados['treinamento_id'];
$checkout['itemDescription1']=$treinamento_wp->post_title;
$checkout['itemAmount1']=$treinamento_acf['valor'];
$checkout['itemQuantity1']=1;
$checkout['senderName']=$dados['nome_completo'];
$checkout['senderCPF']=just_number($dados['cpf']);
$checkout['senderAreaCode']=substr($dados['telefone'], 1, 2);
$checkout['senderPhone']=str_replace('-', "", substr($dados['telefone'], 5));
$checkout['senderEmail']=$dados['email'];
$checkout['senderHash']=$dados['hash'];
$checkout['billingAddressStreet']=$dados['endereco'];
$checkout['billingAddressNumber']='147';
$checkout['billingAddressComplement']='apto 66';
$checkout['billingAddressDistrict']=$dados['bairro'];
$checkout['billingAddressPostalCode']=just_number($dados['cep']);
$checkout['billingAddressCity']=$dados['cidade'];
$checkout['billingAddressState']=$dados['estado'];
$checkout['billingAddressCountry']='BRA';
$checkout['creditCardToken']=$dados['card-token'];
$checkout['installmentQuantity']=$dados['card-token'];

// echo ;die;
header('Content-Type: application/json');
echo json_encode($dados);
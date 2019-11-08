<?php
/* Template Name: Formulário Inscritos - Server Side */
include_once('../../../wp-config.php');
include_once('../../../wp-load.php');
include_once('../../../wp-includes/wp-db.php');

global $wpdb; 
$wpdb->insert(
    'wp_inscritos',
    array(
        'nome_completo' => $_POST['nome_completo'],
        'data_nascimento' => date_converter($_POST['data_nascimento']),
        'cpf' => just_number($_POST['cpf']),
        'email' => $_POST['email'],
        'telefone' => just_number($_POST['telefone']),
        'celular' => just_number($_POST['celular']),
        'cep' => just_number($_POST['cep']),
        'endereco' => $_POST['endereco'],
        'bairro' => $_POST['bairro'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
        'treinamento_id' => $_POST['treinamento_id'] 
    )
);

function date_converter($_date = null)
{
    $format = '/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/';
    if ($_date != null && preg_match($format, $_date, $partes)) {
        return $partes[3] . '-' . $partes[2] . '-' . $partes[1];
    }
    return false;
}

function just_number($number)
{
    return preg_replace('/\D/', '', $number);
}

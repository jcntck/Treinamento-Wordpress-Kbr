<?php
// Template Name: Gerar Sessão Pagseguro - PHP
include_once 'configuracao.php';

$url = URL_PAGSEGURO . "sessions";

//Utilizar o CURL para realizar a requisição ao PagSeguro
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array("email" => EMAIL_PAGSEGURO, "token" => TOKEN_PAGSEGURO), '', '&'));
$retorno = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($retorno);
echo json_encode($xml);
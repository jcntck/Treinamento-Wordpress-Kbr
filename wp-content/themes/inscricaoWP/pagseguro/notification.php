<?php
/* Template Name: Notificação do Pagseguro */
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
include_once 'configuracao.php';
if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction') {
    $email = EMAIL_PAGSEGURO;
    $token = TOKEN_PAGSEGURO;
    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/' . $_POST['notificationCode'] . '?email=' . $email . '&token=' . $token;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $transaction= curl_exec($curl);
    if($transaction == 'Unauthorized'){
        //Insira seu código avisando que o sistema está com problemas, sugiro enviar um e-mail avisando para alguém fazer a manutenção 
    
       exit;//Mantenha essa linha
    }
    curl_close($curl);
    $transaction = simplexml_load_string($transaction);
    var_dump($transaction);
}

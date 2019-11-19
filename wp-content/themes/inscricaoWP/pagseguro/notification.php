<?php
/* Template Name: Notificação do Pagseguro */
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");

$notificationCode = preg_replace('/[^[:alnum:]-]/', '', $_POST["notificationCode"]);

$data['token'] = '632E7CCB11D94DE3A4588623AC793898';
$data['email'] = 'joao.neto@kbrtec.com.br';

$data = http_build_query($data);

$url = 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/' . $notificationCode . '?' . $data;

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $url);
$xml = curl_exec($curl);
curl_close($curl);

$xml = simplexml_load_string($xml);
$codigo = $xml->code;
$status = $xml->status;

var_dump($xml);

global $wpdb;
$inscrito = $wpdb->get_row("SELECT * FROM wp_inscritos WHERE code_transacao = '".$codigo."'");
$wpdb->update( 'wp_inscritos', ['status_transacao' => $status], ['code_transacao' => $codigo]);


if ($status != 3) {
    enviarEmail($inscrito->ID, 2);
} else {
    enviarEmail($inscrito->ID, 3);
}

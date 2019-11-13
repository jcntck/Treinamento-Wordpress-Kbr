<?php
//Necessário testar em dominio com SSL
define("URL", site_url());

//Quando o projeto estiver em desenvolvimento deixar true, quando estiver em produção colocar false para carregar as credenciais do PagSeguro
$sandbox = true;
if($sandbox) {
    //Credenciais do Sandbox
    define("EMAIL_PAGSEGURO", "joao.neto@kbrtec.com.br");
    define("TOKEN_PAGSEGURO", "632E7CCB11D94DE3A4588623AC793898");
    define("URL_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO", "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
} else {
    // Credenciais do PagSeguro
    define("TOKEN_PAGSEGURO", "632E7CCB11D94DE3A4588623AC793898");
    define("URL_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v2/");
    define("SCRIPT_PAGSEGURO", "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
}
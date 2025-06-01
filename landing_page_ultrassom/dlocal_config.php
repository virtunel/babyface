<?php
session_start();

// Carrega variáveis de ambiente do arquivo .env
$env = parse_ini_file(dirname(__DIR__) . '/.env');

if (!$env) {
    die('Erro ao carregar configurações');
}

define('DLOCAL_API_URL', 'https://api-sbx.dlocalgo.com/v1/me');
define('DLOCAL_TRANS_KEY', $env['DLOCAL_TRANS_KEY']);
define('DLOCAL_SECRET_KEY', $env['DLOCAL_SECRET_KEY']);
define('DLOCAL_CURRENCY', 'BRL');
define('DLOCAL_COUNTRY', 'BR');
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
define('DLOCAL_NOTIFICATION_URL', $protocol . $domain . '/webhook.php');
define('DLOCAL_RETURN_URL', $protocol . $domain . '/confirmacao.php');
define('DLOCAL_AMOUNT', 1990);
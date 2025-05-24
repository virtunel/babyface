<?php
session_start();
define('DLOCAL_API_URL', 'https://api-sbx.dlocalgo.com');
define('DLOCAL_TRANS_KEY', 'zHSYwQzTTShroOMMHqQKiKtYufhLWJnO');
define('DLOCAL_SECRET_KEY', 'kGDY1i7hU8oe6uwkMTZMPfTXppqgAAtIN3pecV6a');
define('DLOCAL_CURRENCY', 'BRL');
define('DLOCAL_COUNTRY', 'BR');
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
define('DLOCAL_NOTIFICATION_URL', $protocol . $domain . '/webhook.php');
define('DLOCAL_RETURN_URL', $protocol . $domain . '/confirmacao.php');
define('DLOCAL_AMOUNT', 1990);
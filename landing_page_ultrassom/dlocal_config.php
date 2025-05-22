
<?php
/**
 * Configurações do DLocal
 * Arquivo para centralizar as configurações de integração com o gateway de pagamento
 */

// Chaves de API DLocal (ambiente de sandbox)
define('DLOCAL_API_URL', 'https://api-sbx.dlocalgo.com');
define('DLOCAL_TRANS_KEY', 'zHSYwQzTTShroOMMHqQKiKtYufhLWJnO');
define('DLOCAL_SECRET_KEY', 'kGDY1i7hU8oe6uwkMTZMPfTXppqgAAtIN3pecV6a');

// Configurações de ambiente
define('DLOCAL_CURRENCY', 'BRL');
define('DLOCAL_COUNTRY', 'BR');

// URLs de callback (ajustadas automaticamente para o domínio do Replit)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'];
define('DLOCAL_NOTIFICATION_URL', $protocol . $domain . '/webhook.php');
define('DLOCAL_RETURN_URL', $protocol . $domain . '/confirmacao.php');

// Configurações de pedido
define('DLOCAL_AMOUNT', 1990); // R$ 19,90 em centavos
?>

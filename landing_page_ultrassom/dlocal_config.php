
<?php
/**
 * Configurações do DLocal
 * Arquivo para centralizar as configurações de integração com o gateway de pagamento
 */

// Chaves de API DLocal (em produção, use variáveis de ambiente)
define('DLOCAL_LOGIN', 'seu_login_dlocal');
define('DLOCAL_TRANS_KEY', 'sua_chave_transacao_dlocal');
define('DLOCAL_SECRET_KEY', 'sua_chave_secreta_dlocal');

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

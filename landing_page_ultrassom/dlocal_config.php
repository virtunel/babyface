
<?php
/**
 * Configurações do DLocal
 * Arquivo para centralizar as configurações de integração com o gateway de pagamento
 */

// Chaves de API DLocal
define('DLOCAL_LOGIN', 'seu_login_dlocal');
define('DLOCAL_TRANS_KEY', 'sua_chave_transacao_dlocal');
define('DLOCAL_SECRET_KEY', 'sua_chave_secreta_dlocal');

// Configurações de ambiente
define('DLOCAL_CURRENCY', 'BRL');
define('DLOCAL_COUNTRY', 'BR');

// URLs de callback
define('DLOCAL_NOTIFICATION_URL', 'https://seu-dominio.repl.co/webhook.php');
define('DLOCAL_RETURN_URL', 'https://seu-dominio.repl.co/confirmacao.php');

// Configurações de pedido
define('DLOCAL_AMOUNT', 1990); // R$ 19,90 em centavos
?>

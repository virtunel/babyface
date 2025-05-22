
<?php
require_once 'dlocal_config.php';

// Receber payload
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Verificar assinatura
$headers = getallheaders();
$signature = isset($headers['X-Sign']) ? $headers['X-Sign'] : '';
$date = isset($headers['X-Date']) ? $headers['X-Date'] : '';

$message = DLOCAL_LOGIN . $date . $data['id'];
$expectedSignature = hash_hmac('sha256', $message, DLOCAL_SECRET_KEY);

if (hash_equals($signature, $expectedSignature)) {
    // Processar notificação
    $orderId = $data['order_id'];
    $status = $data['status'];
    
    // Atualizar status do pedido no seu sistema
    if ($status === 'PAID') {
        // Pedido aprovado
        // Aqui você pode implementar o envio de email de confirmação
        http_response_code(200);
        echo json_encode(['message' => 'Notificação processada com sucesso']);
    } else {
        // Pedido com outro status
        http_response_code(200);
        echo json_encode(['message' => 'Status registrado: ' . $status]);
    }
} else {
    // Assinatura inválida
    http_response_code(401);
    echo json_encode(['error' => 'Assinatura inválida']);
}
?>

<?php
require_once 'dlocal_config.php';

// Adicionar log
function writeLog($message) {
    $logFile = __DIR__ . '/webhook.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

// Receber payload
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

writeLog("Payload recebido: " . $payload);

// Verificar assinatura
$headers = getallheaders();
$signature = isset($headers['X-Sign']) ? $headers['X-Sign'] : '';
$date = isset($headers['X-Date']) ? $headers['X-Date'] : '';

$message = DLOCAL_LOGIN . $date . $data['id'];
$expectedSignature = hash_hmac('sha256', $message, DLOCAL_SECRET_KEY);

if (hash_equals($signature, $expectedSignature)) {
    writeLog("Assinatura válida para pedido: " . $orderId);
    
    // Processar notificação
    $orderId = $data['order_id'];
    $status = $data['status'];
    
    if ($status === 'PAID') {
        writeLog("Pedido $orderId: Pagamento aprovado");
        http_response_code(200);
        echo json_encode(['message' => 'Notificação processada com sucesso']);
    } else {
        writeLog("Pedido $orderId: Status $status");
        http_response_code(200);
        echo json_encode(['message' => 'Status registrado: ' . $status]);
    }
} else {
    writeLog("Assinatura inválida");
    http_response_code(401);
    echo json_encode(['error' => 'Assinatura inválida']);
}
?>

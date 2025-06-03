<?php
require_once 'dlocal_config.php';
require_once 'config/database.php';

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
    
    $orderId = $data['order_id'];
    $status = $data['status'];
    
    if ($status === 'PAID') {
        try {
            $database = new Database();
            $db = $database->getConnection();
            
            $query = "UPDATE pedidos SET status = 'pago' WHERE order_id = :order_id";
            $stmt = $db->prepare($query);
            $stmt->execute([':order_id' => $orderId]);
            
            writeLog("Pedido $orderId: Pagamento aprovado e status atualizado");
            http_response_code(200);
            echo json_encode(['message' => 'Notificação processada com sucesso']);
        } catch(PDOException $e) {
            writeLog("Erro ao atualizar status: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Erro ao processar pagamento']);
        }
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

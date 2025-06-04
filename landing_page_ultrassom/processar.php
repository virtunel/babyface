<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/database.php';

// Inicializar conexão com o banco
try {
    $database = new Database();
    $conn = $database->getConnection();

    // Criar tabela se não existir
    $sql = "CREATE TABLE IF NOT EXISTS pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        telefone VARCHAR(20),
        semanas INT NOT NULL,
        arquivo_ultrassom VARCHAR(255) NOT NULL,
        order_id VARCHAR(50) NOT NULL,
        status ENUM('pendente', 'pago', 'cancelado') DEFAULT 'pendente',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $conn->exec($sql);

} catch(Exception $e) {
    $_SESSION['errors'] = ["Erro de configuração: " . $e->getMessage()];
    header("Location: erro.php");
    exit();
}

// Criar pasta uploads se não existir
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// Configurações
$uploadDir = 'uploads/';
$maxFileSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Inicializar variáveis
$errors = [];
$success = false;
$uploadedFile = '';
$redirectUrl = '';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos obrigatórios
    $requiredFields = ['nome', 'email', 'semanas', 'telefone'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "O campo " . ucfirst($field) . " é obrigatório.";
        }
    }

    // Validar email
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Por favor, informe um e-mail válido.";
    }

    // Validar telefone (simples, pode ser aprimorado)
    if (!empty($_POST['telefone']) && !preg_match('/^[0-9\-\(\) ]{8,20}$/', $_POST['telefone'])) {
        $errors[] = "Por favor, informe um telefone válido.";
    }

    // Validar semanas de gestação
    if (!empty($_POST['semanas'])) {
        $semanas = (int)$_POST['semanas'];
        if ($semanas < 12 || $semanas > 40) {
            $errors[] = "As semanas de gestação devem estar entre 12 e 40.";
        }
    }

    // Validar upload de arquivo
    if (isset($_FILES['ultrassom']) && $_FILES['ultrassom']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['ultrassom'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors[] = "O arquivo é muito grande. Tamanho máximo permitido: 5MB.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $errors[] = "O upload do arquivo foi interrompido.";
                    break;
                default:
                    $errors[] = "Ocorreu um erro no upload do arquivo.";
            }
        } else {
            // Verificar tipo de arquivo
            $fileType = $file['type'];
            if (!in_array($fileType, $allowedTypes)) {
                $errors[] = "Tipo de arquivo não permitido. Apenas JPEG, PNG, GIF e WEBP são aceitos.";
            }

            // Verificar tamanho do arquivo
            if ($file['size'] > $maxFileSize) {
                $errors[] = "O arquivo é muito grande. Tamanho máximo permitido: 5MB.";
            }

            // Processar upload se não houver erros
            if (empty($errors)) {
                $fileName = uniqid('ultrassom_') . '_' . basename($file['name']);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $uploadedFile = $fileName;
                } else {
                    $errors[] = "Ocorreu um erro ao salvar o arquivo. Por favor, tente novamente.";
                }
            }
        }
    } else {
        $errors[] = "Por favor, selecione uma imagem de ultrassom.";
    }

    // Se não houver erros, criar pedido no DLocal
    if (empty($errors)) {
        try {
            // Verifica conexão com banco
            $database = new Database();
            $db = $database->getConnection();
            
            if (!$db) {
                throw new Exception("Erro de conexão com o banco de dados");
            }

            // Verifica se a tabela existe
            $checkTable = $db->query("SHOW TABLES LIKE 'pedidos'");
            if ($checkTable->rowCount() == 0) {
                // Cria a tabela se não existir
                $sql = "CREATE TABLE IF NOT EXISTS pedidos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    telefone VARCHAR(20),
                    semanas INT NOT NULL,
                    arquivo_ultrassom VARCHAR(255) NOT NULL,
                    order_id VARCHAR(50) NOT NULL,
                    status ENUM('pendente', 'pago', 'cancelado') DEFAULT 'pendente',
                    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                $db->exec($sql);
            }

            // Definir variáveis a partir do POST
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $telefone = trim($_POST['telefone']);
            $semanas = (int)$_POST['semanas'];
            $order_id = uniqid('order_');

            $query = "INSERT INTO pedidos (nome, email, telefone, semanas, arquivo_ultrassom, order_id, status) 
                     VALUES (:nome, :email, :telefone, :semanas, :arquivo, :order_id, 'pendente')";
            
            $stmt = $db->prepare($query);
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':telefone' => $telefone,
                ':semanas' => $semanas,
                ':arquivo' => $uploadedFile,
                ':order_id' => $order_id
            ]);

            // Define sucesso após inserção bem sucedida
            $success = true;

            $paymentData = [
                "amount" => 19.90,
                "currency" => "BRL",
                "country" => "BR",
                "payment_method_id" => "CARD",
                "payment_method_flow" => "REDIRECT",
                "payer" => [
                    "name" => $nome,
                    "email" => $email,
                    "phone" => $telefone,
                    "document" => "11144477735",
                    "document_type" => "CPF"
                ],
                "order_id" => $order_id,
                "description" => "Projeção de bebê a partir de ultrassom"
            ];

            $apiKey = 'zHSYwQzTTShroOMMHqQKiKtYufhLWJnO'; // ou DLOCAL_API_KEY se definido assim
            $secretKey = 'kGDY1i7hU8oe6uwkMTZMPfTXppqgAAtIN3pecV6a';
            // $apiKey = DLOCAL_TRANS_KEY; // ou DLOCAL_API_KEY se definido assim
            // $secretKey = DLOCAL_SECRET_KEY;

            $headers = [
                'Authorization: Bearer ' . $apiKey . ':' . $secretKey,
                'Content-Type: application/json',
            ];

            // Requisição para criar o pedido no DLocal
            
            $ch = curl_init('https://api-sbx.dlocalgo.com/v1/payments');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            $result = json_decode($response, true);

            if (($httpCode === 201 || $httpCode === 200) && isset($result['redirect_url'])) {
                $success = true;
                $_SESSION['payment_url'] = $result['redirect_url'];
                header("Location: " . $result['redirect_url']);
                exit();
            } else {
                throw new Exception("Erro ao criar pagamento: " . ($result['message'] ?? 'Erro desconhecido'));
            }

        } catch(Exception $e) {
            error_log("Erro detalhado: " . $e->getMessage());
            $_SESSION['errors'] = [$e->getMessage()];
            header("Location: erro.php");
            exit();
        }
    }
}

// Modifica o redirecionamento de erro
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST; // Guarda dados do formulário
    header('Location: erro.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processando seu pedido - Projeção Bebê</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .processing {
            text-align: center;
            padding: 100px 20px;
        }
        .processing-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="container">
            <div class="logo">
                <img src="img/logo.png" alt="Projeção Bebê Logo">
            </div>
        </div>
    </header>

    <main>
        <?php if ($success): ?>
            <div class="processing">
                <div class="processing-icon">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <h2>Processando seu pedido...</h2>
                <p>Por favor, aguarde enquanto redirecionamos você para a página de confirmação.</p>
            </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2025 Projeção Bebê - Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
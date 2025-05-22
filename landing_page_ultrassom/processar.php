<?php
// Configurações
$uploadDir = 'uploads/';
$maxFileSize = 5 * 1024 * 1024; // 5MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

// Criar diretório de uploads se não existir
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Inicializar variáveis
$errors = [];
$success = false;
$uploadedFile = '';
$redirectUrl = '';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos obrigatórios
    $requiredFields = ['nome', 'email', 'semanas'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "O campo " . ucfirst($field) . " é obrigatório.";
        }
    }
    
    // Validar email
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Por favor, informe um e-mail válido.";
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
        
        // Verificar erros de upload
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
                // Gerar nome único para o arquivo
                $fileName = uniqid('ultrassom_') . '_' . basename($file['name']);
                $uploadPath = $uploadDir . $fileName;
                
                // Mover arquivo para o diretório de uploads
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
    
    // Se não houver erros, processar o pagamento e redirecionar
    if (empty($errors)) {
        // Salvar dados no banco de dados (simulado)
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $telefone = !empty($_POST['telefone']) ? htmlspecialchars($_POST['telefone']) : '';
        $semanas = (int)$_POST['semanas'];
        $comentarios = !empty($_POST['comentarios']) ? htmlspecialchars($_POST['comentarios']) : '';
        
        // Simular processamento de pagamento
        $pagamentoAprovado = true; // Em um cenário real, isso viria de uma API de pagamento
        
        if ($pagamentoAprovado) {
            // Gerar ID único para o pedido
            $pedidoId = uniqid('PED');
            
            // Em um cenário real, salvaríamos esses dados em um banco de dados
            // Aqui, apenas simulamos o sucesso da operação
            
            // Redirecionar para página de confirmação
            $redirectUrl = "confirmacao.php?pedido=" . $pedidoId;
            $success = true;
        } else {
            $errors[] = "Não foi possível processar o pagamento. Por favor, tente novamente.";
        }
    }
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
        
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .error-list {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .error-list ul {
            margin: 10px 0 0 20px;
        }
        
        .back-button {
            margin-top: 20px;
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
            <script>
                // Redirecionar após 3 segundos
                setTimeout(function() {
                    window.location.href = "<?php echo $redirectUrl; ?>";
                }, 3000);
            </script>
        <?php else: ?>
            <section class="container">
                <div class="error-container">
                    <h2>Ops! Encontramos alguns problemas</h2>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="error-list">
                            <p><strong>Por favor, corrija os seguintes erros:</strong></p>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <p>Não foi possível processar seu pedido. Por favor, volte e verifique as informações fornecidas.</p>
                    
                    <div class="back-button">
                        <a href="javascript:history.back()" class="btn btn-primary">Voltar e Corrigir</a>
                    </div>
                </div>
            </section>
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

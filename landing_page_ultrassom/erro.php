<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$formData = $_SESSION['form_data'] ?? [];

// Limpa a sessão após usar
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - Projeção Bebê</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
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
        <div class="container">
            <div class="error-content">
                <h1>Ops! Encontramos alguns problemas</h1>
                <?php if (!empty($errors)): ?>
                    <div class="error-list">
                        <p>Por favor, corrija os seguintes erros:</p>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <a href="javascript:history.back()" class="btn btn-primary">Voltar e tentar novamente</a>
            </div>
        </div>
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
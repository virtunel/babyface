<?php
session_start(); // Deve ser o primeiro comando no arquivo

// Recuperar erros
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : ['Ocorreu um erro desconhecido. Por favor, tente novamente.'];
// Limpar erros da sessão
unset($_SESSION['errors']);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        <section class="container">
            <div class="error-container">
                <h2>Ops! Encontramos alguns problemas</h2>
                <?php if (!empty($errors)): ?>
                    <div class="error-list">
                        <p><strong>Por favor, corrija os seguintes erros:</strong></p>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
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
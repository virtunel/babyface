<?php
// Configurações
$pedidoId = isset($_GET['pedido']) ? htmlspecialchars($_GET['pedido']) : '';

// Verificar se o ID do pedido foi fornecido
if (empty($pedidoId)) {
    header('Location: index.html');
    exit;
}

// Em um cenário real, buscaríamos informações do pedido no banco de dados
// Aqui, apenas simulamos os dados
$prazoEntrega = date('d/m/Y', strtotime('+1 day'));
$horaEntrega = '18:00';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Projeção Bebê</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .confirmation { 
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, #fff6fa 0%, #f0e7ff 100%);
        }
        
        .confirmation-icon {
            width: 100px;
            height: 100px;
            background-color: #4caf50;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 30px;
        }
        
        .order-details {
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            text-align: left;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #666;
        }
        
        .detail-value {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .next-steps {
            margin-top: 40px;
            background-color: var(--light-bg);
            padding: 30px;
            border-radius: var(--border-radius);
        }
        
        .step-list {
            max-width: 600px;
            margin: 30px auto;
            text-align: left;
        }
        
        .step-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .share-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .share-button {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            transition: var(--transition);
        }
        
        .share-button:hover {
            transform: translateY(-3px);
        }
        
        .share-whatsapp {
            background-color: #25d366;
        }
        
        .share-facebook {
            background-color: #1877f2;
        }
        
        .share-instagram {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
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
        <section class="confirmation">
            <div class="container">
                <div class="confirmation-icon">
                    <i class="fas fa-check"></i>
                </div>
                
                <h1>Pedido Confirmado!</h1>
                <p class="section-subtitle">Estamos ansiosos para criar a projeção do seu bebê</p>
                
                <div class="order-details">
                    <h3>Detalhes do Pedido</h3>
                    
                    <div class="detail-row">
                        <span class="detail-label">Número do Pedido:</span>
                        <span class="detail-value"><?php echo $pedidoId; ?></span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">Pagamento Aprovado</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Valor:</span>
                        <span class="detail-value">R$19,90</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Previsão de Entrega:</span>
                        <span class="detail-value">Até <?php echo $prazoEntrega; ?> às <?php echo $horaEntrega; ?></span>
                    </div>
                </div>
                
                <div class="next-steps">
                    <h3>Próximos Passos</h3>
                    
                    <div class="step-list">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div class="step-text">
                                <p>Nossa equipe já recebeu seu ultrassom e começará a trabalhar na projeção do seu bebê.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div class="step-text">
                                <p>Você receberá um e-mail de confirmação com os detalhes do seu pedido nos próximos minutos.</p>
                            </div>
                        </div>
                        
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-text">
                                <p>Em até 24 horas, enviaremos a projeção do seu bebê para o e-mail cadastrado.</p>
                            </div>
                        </div>
                    </div>
                    
                    <p>Enquanto isso, que tal compartilhar essa experiência com seus amigos e familiares?</p>
                    
                    <div class="share-buttons">
                        <a href="#" class="share-button share-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="share-button share-facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="share-button share-instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div class="cta-center" style="margin-top: 40px;">
                    <a href="index.html" class="btn btn-primary">Voltar para a Página Inicial</a>
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

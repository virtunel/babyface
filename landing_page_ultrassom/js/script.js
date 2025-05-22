// Script JavaScript para interatividade da landing page

document.addEventListener('DOMContentLoaded', function() {
    // Menu mobile toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }
    
    // FAQ accordion
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Fechar todos os outros itens
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    const toggle = otherItem.querySelector('.faq-toggle i');
                    toggle.className = 'fas fa-plus';
                }
            });
            
            // Toggle do item atual
            item.classList.toggle('active');
            const toggle = item.querySelector('.faq-toggle i');
            
            if (item.classList.contains('active')) {
                toggle.className = 'fas fa-minus';
            } else {
                toggle.className = 'fas fa-plus';
            }
        });
    });
    
    // Personalização do input de arquivo
    const fileInput = document.getElementById('ultrassom');
    const fileName = document.querySelector('.file-name');
    
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            } else {
                fileName.textContent = 'Nenhum arquivo selecionado';
            }
        });
    }
    
    // Smooth scroll para links de âncora
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Fechar menu mobile se estiver aberto
                if (navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    menuToggle.classList.remove('active');
                }
            }
        });
    });
    
    // Validação do formulário
    const form = document.getElementById('upload-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            let valid = true;
            const nome = document.getElementById('nome');
            const email = document.getElementById('email');
            const semanas = document.getElementById('semanas');
            const ultrassom = document.getElementById('ultrassom');
            
            // Validar nome
            if (!nome.value.trim()) {
                showError(nome, 'Por favor, informe seu nome completo');
                valid = false;
            } else {
                removeError(nome);
            }
            
            // Validar email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value)) {
                showError(email, 'Por favor, informe um e-mail válido');
                valid = false;
            } else {
                removeError(email);
            }
            
            // Validar semanas de gestação
            if (!semanas.value || semanas.value < 12 || semanas.value > 40) {
                showError(semanas, 'Por favor, informe um valor entre 12 e 40 semanas');
                valid = false;
            } else {
                removeError(semanas);
            }
            
            // Validar upload de imagem
            if (!ultrassom.files || ultrassom.files.length === 0) {
                showError(ultrassom.parentElement, 'Por favor, selecione uma imagem de ultrassom');
                valid = false;
            } else {
                const file = ultrassom.files[0];
                const fileType = file.type;
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                
                if (!validTypes.includes(fileType)) {
                    showError(ultrassom.parentElement, 'Por favor, selecione uma imagem válida (JPEG, PNG, GIF ou WEBP)');
                    valid = false;
                } else if (file.size > 5 * 1024 * 1024) { // 5MB
                    showError(ultrassom.parentElement, 'A imagem deve ter no máximo 5MB');
                    valid = false;
                } else {
                    removeError(ultrassom.parentElement);
                }
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
    
    // Funções auxiliares para validação
    function showError(element, message) {
        // Remover mensagem de erro anterior se existir
        removeError(element);
        
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.textContent = message;
        errorMessage.style.color = 'red';
        errorMessage.style.fontSize = '0.8rem';
        errorMessage.style.marginTop = '5px';
        
        element.parentNode.appendChild(errorMessage);
        element.style.borderColor = 'red';
    }
    
    function removeError(element) {
        const errorMessage = element.parentNode.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
        element.style.borderColor = '';
    }
    
    // Contador de urgência (simulação)
    const urgencyBadge = document.querySelector('.urgency-badge');
    
    if (urgencyBadge) {
        // Gerar um número aleatório entre 10 e 50 para simular vagas restantes
        const vagasRestantes = Math.floor(Math.random() * 41) + 10;
        urgencyBadge.innerHTML = `<i class="fas fa-clock"></i> Oferta especial para as primeiras ${vagasRestantes} mamães do dia - Receba sua projeção em até 24h!`;
    }
});

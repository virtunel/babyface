# Documentação - Landing Page para Projeção de Bebê a partir de Ultrassom

## Visão Geral do Projeto

Esta landing page foi desenvolvida para oferecer um serviço de projeção de bebês a partir de imagens de ultrassom. O público-alvo são mulheres grávidas que desejam visualizar como será o rostinho de seus bebês antes do nascimento. O serviço é oferecido pelo valor de R$19,90.

## Estrutura de Arquivos

```
landing_page_ultrassom/
├── css/
│   └── styles.css          # Estilos CSS responsivos
├── js/
│   └── script.js           # Interatividade JavaScript
├── img/                    # Diretório para imagens (vazio, precisa ser preenchido)
├── uploads/                # Diretório onde as imagens enviadas serão armazenadas
├── index.html              # Página principal da landing page
├── processar.php           # Script PHP para processar o formulário
├── confirmacao.php         # Página de confirmação após envio
├── requisitos.md           # Análise de requisitos do serviço
├── gatilhos_marketing.md   # Gatilhos emocionais e estratégias de marketing
├── estrutura_landing.md    # Estrutura detalhada da landing page
├── textos_landing.md       # Textos completos para cada seção
└── todo.md                 # Lista de tarefas do projeto
```

## Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Bibliotecas**: Font Awesome (ícones), Google Fonts (tipografia)

## Funcionalidades Implementadas

1. **Landing Page Responsiva**: Design adaptável para desktop e dispositivos móveis
2. **Formulário de Envio**: Upload de imagem de ultrassom com validações
3. **Processamento de Imagem**: Validação de tipo e tamanho de arquivo
4. **Simulação de Pagamento**: Fluxo completo de pagamento (simulado)
5. **Confirmação de Pedido**: Página de confirmação com detalhes do pedido
6. **Elementos Persuasivos**: Gatilhos emocionais, depoimentos, exemplos e garantias

## Instruções de Uso

### Requisitos do Servidor

- PHP 7.4 ou superior
- Permissões de escrita no diretório `uploads/`

### Configuração

1. **Imagens**: Adicione as seguintes imagens ao diretório `img/`:
   - `logo.png`: Logo da marca
   - `logo-footer.png`: Versão do logo para o rodapé
   - `hero-image.jpg`: Imagem principal para a seção hero
   - `ultrassom1.jpg`, `ultrassom2.jpg`, `ultrassom3.jpg`: Exemplos de ultrassom
   - `projecao1.jpg`, `projecao2.jpg`, `projecao3.jpg`: Exemplos de projeções
   - `mae1.jpg`, `mae2.jpg`, `mae3.jpg`: Fotos das mães para depoimentos

2. **Configurações de E-mail** (em um ambiente de produção):
   - Edite o arquivo `processar.php` para configurar o envio de e-mails reais
   - Adicione suas credenciais SMTP ou use a função `mail()` do PHP

3. **Integração de Pagamento** (em um ambiente de produção):
   - Substitua a simulação de pagamento por uma integração real com gateway de pagamento
   - Edite o arquivo `processar.php` para incluir a API de pagamento escolhida

### Personalização

1. **Cores**: Edite as variáveis CSS no início do arquivo `css/styles.css`:
   ```css
   :root {
       --primary-color: #ff6b98;
       --secondary-color: #8a4fff;
       --accent-color: #ffca28;
       /* outras variáveis */
   }
   ```

2. **Textos**: Todos os textos podem ser editados diretamente nos arquivos HTML e PHP

3. **Formulário**: Campos adicionais podem ser incluídos no formulário em `index.html`

## Fluxo do Usuário

1. Usuário acessa a landing page (`index.html`)
2. Navega pelo conteúdo, conhecendo o serviço e benefícios
3. Preenche o formulário e envia a imagem de ultrassom
4. O sistema processa o envio (`processar.php`)
5. Em caso de sucesso, o usuário é redirecionado para a página de confirmação (`confirmacao.php`)
6. Em caso de erro, o usuário recebe feedback e pode corrigir o formulário

## Considerações de Segurança

- O sistema valida o tipo e tamanho dos arquivos enviados
- Implementa sanitização básica de inputs para prevenir XSS
- Em um ambiente de produção, recomenda-se implementar:
  - HTTPS para transmissão segura de dados
  - Proteção contra CSRF nos formulários
  - Limitação de taxa de envio para prevenir abusos

## Melhorias Futuras

1. Integração com banco de dados para armazenar pedidos
2. Sistema de login para acompanhamento de pedidos
3. Painel administrativo para gerenciamento de pedidos
4. Integração com API de pagamento real
5. Sistema de notificações por e-mail e SMS
6. Galeria de exemplos expandida com mais casos reais

## Suporte

Para dúvidas ou suporte técnico, entre em contato através dos canais indicados no rodapé da landing page.

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
        }
        
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
        }
        
        .login-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 400px;
            width: 100%;
        }
        
        .title-section {
            color: white;
        }
        
        .title-section h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .title-section p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .text-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .text-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .title-section h1 {
                font-size: 2.5rem;
            }
            
            .title-section {
                text-align: center;
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Sistema Seguro
                    </h4>
                </div>
                <div class="col-auto">
                    <nav>
                        <a href="#" class="text-white text-decoration-none me-3">Início</a>
                        <a href="#" class="text-white text-decoration-none me-3">Sobre</a>
                        <a href="#" class="text-white text-decoration-none">Contato</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <!-- Lado Esquerdo - Título e Subtítulo -->
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="title-section">
                        <h1>Bem-vindo!</h1>
                        <p class="lead">
                            Acesse sua conta e aproveite todos os recursos disponíveis em nossa plataforma. 
                            Mantenha seus dados seguros e tenha a melhor experiência conosco.
                        </p>
                        <div class="mt-4">
                            <i class="fas fa-check-circle me-2"></i>Segurança garantida<br>
                            <i class="fas fa-check-circle me-2"></i>Interface intuitiva<br>
                            <i class="fas fa-check-circle me-2"></i>Suporte 24/7
                        </div>
                    </div>
                </div>

                <!-- Lado Direito - Box de Login -->
                <div class="col-lg-6 col-md-6">
                    <div class="d-flex justify-content-center">
                        <div class="login-box">
                            <div class="text-center mb-4">
                                <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                                <h3>Fazer Login</h3>
                                <p class="text-muted">Entre com suas credenciais</p>
                            </div>

                            <form>
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </label>
                                    <input type="email" class="form-control" id="email" placeholder="seu@email.com" required>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Senha
                                    </label>
                                    <input type="password" class="form-control" id="password" placeholder="Sua senha" required>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                                    </button>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div class="text-center">
                                <p class="mb-0">Não tem uma conta?</p>
                                <a href="#" class="text-link" data-bs-toggle="modal" data-bs-target="#cadastroModal">
                                    <i class="fas fa-user-plus me-2"></i>Criar novo cadastro
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Criar Nova Conta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label for="cadastroNome" class="form-label">
                                <i class="fas fa-user me-2"></i>Nome Completo
                            </label>
                            <input type="text" class="form-control" id="cadastroNome" placeholder="Seu nome completo" required>
                        </div>

                        <div class="mb-3">
                            <label for="cadastroEmail" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="cadastroEmail" placeholder="seu@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="cadastroSenha" class="form-label">
                                <i class="fas fa-lock me-2"></i>Senha
                            </label>
                            <input type="password" class="form-control" id="cadastroSenha" placeholder="Crie uma senha segura" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-check me-2"></i>Criar Conta
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <small class="text-muted">
                        Ao criar uma conta, você concorda com nossos termos de uso e política de privacidade.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistema Seguro</h5>
                    <p class="mb-0">Sua plataforma confiável para gerenciamento seguro de dados.</p>
                </div>
                <div class="col-md-3">
                    <h6>Links Úteis</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50 text-decoration-none">Política de Privacidade</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Termos de Uso</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Suporte</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Redes Sociais</h6>
                    <div>
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0">&copy; 2025 Sistema Seguro. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
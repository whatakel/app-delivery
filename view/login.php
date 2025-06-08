<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="_public/css/style.css" rel="stylesheet">
    <link href="_public/css/login.css" rel="stylesheet">
</head>
<body>
    <!-- Cabeçalho -->
    

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="title-section">
                        <h1>Bem-vindo</h1>
                        <p class="lead">
                            Acesse sua conta para acessar nosso cardapio e fazer o seu pedido!
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="d-flex justify-content-center">
                        <div class="login-box">
                            <div class="text-center mb-4">
                                <i class="fas fa-user-circle fa-3x text-warning mb-3"></i>
                                <h3>Fazer Login</h3>
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
                                    <input type="password" class="form-control" id="password" placeholder="******" required>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-sign-in-alt me-2"></i>Entrar
                                    </button>
                                </div>
                            </form>

                            <hr class="my-4">

                            <div class="text-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#cadastroModal">
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
                <div class="modal-header bg-warning text-white ">
                    <h5 class="modal-title" id="cadastroModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Criar Nova Conta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="cadastroNome" class="form-label"><i class="fas fa-user me-2"></i>Nome</label>
                            <input type="text" name="nome" class="form-control" id="cadastroNome" placeholder="Nome e Sobrenome" required>
                        </div>

                        <div class="mb-3">
                            <label for="cadastroEmail" class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                            <input type="email" name="email" class="form-control" id="cadastroEmail" placeholder="seu@email.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="cadastroSenha" class="form-label"><i class="fas fa-lock me-2"></i>Senha</label>
                            <input type="password" name="senha" class="form-control" id="cadastroSenha" placeholder="Crie uma senha segura" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-user-check me-2"></i>Criar Conta
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <small class="text-muted">
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

function headerMenu($tipoUsuario = null, $cssExtra = 'login.css', $titulo = 'On Delivery - Sistema')
{
    $nome = $_SESSION['usuario']['nome'] ?? '';

    echo '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($titulo) . '</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="_public/css/style.css" rel="stylesheet">
    <link href="_public/css/' . htmlspecialchars($cssExtra) . '" rel="stylesheet">
</head>
<body>
<header class="header bg-warning py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col text-white">
                <a class="logo mb-0" href="index.php">
                    <i class="truck-logo fa-solid fa-truck-fast text-warning"></i>
                    On Delivery
                </a>
            </div>
            <div class="col-auto">
                <nav>';

    if ($tipoUsuario === 'adm') {
        if (!empty($nome)) {
            echo '<span class="text-warning p-2 rounded bg-white me-3">Olá, ' . htmlspecialchars($nome) . '!</span>';
        }
        echo '
                    <a href="index.php?pagina=adm_pedidos" class="text-white text-decoration-none me-3">Pedidos</a>
                    <a href="index.php?pagina=adm_usuarios" class="text-white text-decoration-none me-3">Usuários</a>
                    <a href="index.php?pagina=sair" class="text-white text-decoration-none">Sair</a>';
    } elseif ($tipoUsuario === 'cliente') {
        if (!empty($nome)) {
            echo '<span class="nome-menu text-warning p-2 rounded bg-white me-3">Olá, ' . htmlspecialchars($nome) . '!</span>';
        }
        echo '
                    <a href="index.php?pagina=cardapio" class="text-white text-decoration-none me-3">Cardapio</a>
                    <a href="index.php?pagina=meus_pedidos" class="text-white text-decoration-none me-3">Meus Pedidos</a>
                    <a href="index.php?pagina=sair" class="text-white text-decoration-none">Sair</a>';
    } else {
        echo '
                    <button class="novo-cadastro btn btn-warning text-center" data-bs-toggle="modal" data-bs-target="#cadastroModal">
                        <i class="fas fa-user-plus me-2"></i>Criar novo cadastro
                    </button>';
    }

    echo '
                </nav>
            </div>
        </div>
    </div>
</header>
<main class="main">
';
}




function footer()
{
    echo '
    </main>
    <footer class="footer text-white bg-warning  py-4 mt-auto">
        <div class="container">
            <hr class="my-3">
            <div class="row">
                <div class="col text-center">
                    <p class="mb-0">Trabalho Desenvolvimento de Sistemas - Positivo 2025</p>
                </div>
            </div>
        </div>
    </footer>
    </body>';
}

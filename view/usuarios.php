<?php
require_once './config/conexao.php';
require_once './controllers/UsuarioController.php';

$pdo = Conexao::conectar();
$usuarioController = new UsuarioController();

// Processar edição de usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_usuario'])) {
    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tipo = $_POST['tipo'];
    
    if ($usuarioController->editar($id, $nome, $email, $tipo)) {
        $_SESSION['msg_sucesso'] = "Usuário atualizado com sucesso!";
    } else {
        $_SESSION['msg_erro'] = "Erro ao atualizar usuário.";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Processar exclusão de usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_usuario'])) {
    $id = (int)$_POST['id'];
    
    if ($usuarioController->excluir($id)) {
        $_SESSION['msg_sucesso'] = "Usuário excluído com sucesso!";
    } else {
        $_SESSION['msg_erro'] = "Erro ao excluir usuário.";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$usuarios = $usuarioController->listar();

// Lógica para exibir mensagens sucesso/erro da sessão
$mensagem = '';
if (isset($_SESSION['msg_sucesso'])) {
    $mensagem = "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['msg_sucesso']) . "</div>";
    unset($_SESSION['msg_sucesso']);
} elseif (isset($_SESSION['msg_erro'])) {
    $mensagem = "<div class='alert alert-danger'>" . htmlspecialchars($_SESSION['msg_erro']) . "</div>";
    unset($_SESSION['msg_erro']);
}
?>

<div class="container shadow-lg p-5 rounded">
    <h2 class="mb-4">Usuários</h2>

    <?php echo $mensagem ?>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (is_array($usuarios) && count($usuarios) > 0) {
                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($usuario->id) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario->nome) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario->email) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario->tipo) . "</td>";
                    
                    // Coluna de Ações
                    echo "<td>";
                    // Botão Editar
                    echo "<button type='button' class='btn btn-sm btn-primary me-2' data-bs-toggle='modal' data-bs-target='#editarModal" . $usuario->id . "'>";
                    echo "<i class='fa fa-edit'></i> Editar";
                    echo "</button>";
                    
                    // Botão Excluir
                    echo "<form method='POST' class='d-inline' onsubmit='return confirm(\"Tem certeza que deseja excluir este usuário?\");'>";
                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($usuario->id) . "'>";
                    echo "<button type='submit' name='excluir_usuario' class='btn btn-sm btn-danger'>";
                    echo "<i class='fa fa-trash-alt'></i> Excluir";
                    echo "</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";

                    // Modal de Edição
                    echo "<div class='modal fade' id='editarModal" . $usuario->id . "' tabindex='-1' aria-labelledby='editarModalLabel" . $usuario->id . "' aria-hidden='true'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='editarModalLabel" . $usuario->id . "'>Editar Usuário</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<form method='POST'>";
                    echo "<div class='modal-body'>";
                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($usuario->id) . "'>";
                    
                    echo "<div class='mb-3'>";
                    echo "<label for='nome' class='form-label'>Nome</label>";
                    echo "<input type='text' class='form-control' id='nome' name='nome' value='" . htmlspecialchars($usuario->nome) . "' required>";
                    echo "</div>";
                    
                    echo "<div class='mb-3'>";
                    echo "<label for='email' class='form-label'>Email</label>";
                    echo "<input type='email' class='form-control' id='email' name='email' value='" . htmlspecialchars($usuario->email) . "' required>";
                    echo "</div>";
                    
                    echo "<div class='mb-3'>";
                    echo "<label for='tipo' class='form-label'>Tipo</label>";
                    echo "<select class='form-select' id='tipo' name='tipo' required>";
                    $tipos = ['admin', 'cliente', 'entregador'];
                    foreach ($tipos as $tipo) {
                        echo "<option value='" . htmlspecialchars($tipo) . "'" . ($usuario->tipo == $tipo ? ' selected' : '') . ">" . htmlspecialchars(ucfirst($tipo)) . "</option>";
                    }
                    echo "</select>";
                    echo "</div>";
                    
                    echo "</div>";
                    echo "<div class='modal-footer'>";
                    echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>";
                    echo "<button type='submit' name='editar_usuario' class='btn btn-primary'>Salvar</button>";
                    echo "</div>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'><p class='alert alert-info'>Nenhum usuário encontrado para exibir.</p></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

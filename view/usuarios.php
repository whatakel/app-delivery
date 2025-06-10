<?php
require_once './config/conexao.php';
require_once './controllers/UsuarioController.php';
$pdo = Conexao::conectar();
$usuarioController = new UsuarioController();

$usuarioController->processarRequisicao();
$usuarios = $usuarioController->listar();
$mensagem = $usuarioController->obterMensagem();
?>

<div class="container shadow-lg p-5 rounded">
    <h2 class="mb-4">Usuários</h2>
    <?= $mensagem ?>
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Ações</th></tr>
        </thead>
        <tbody>
        <?php if (!empty($usuarios)): foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario->id) ?></td>
                <td><?= htmlspecialchars($usuario->nome) ?></td>
                <td><?= htmlspecialchars($usuario->email) ?></td>
                <td><?= htmlspecialchars($usuario->tipo) ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editarModal<?= $usuario->id ?>"><i class="fa fa-edit"></i> Editar</button>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                        <input type="hidden" name="id" value="<?= $usuario->id ?>">
                        <button type="submit" name="excluir_usuario" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i> Excluir</button>
                    </form>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="editarModal<?= $usuario->id ?>" tabindex="-1" aria-labelledby="editarModalLabel<?= $usuario->id ?>" aria-hidden="true">
                <div class="modal-dialog"><div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel<?= $usuario->id ?>">Editar Usuário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?= $usuario->id ?>">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($usuario->nome) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($usuario->email) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                                <input type="password" class="form-control" name="senha" minlength="6">
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" name="tipo" required>
                                    <?php 
                                    $tipos = ['administrador' => 'Administrador', 'usuario' => 'Usuário'];
                                    foreach ($tipos as $valor => $label): 
                                    ?>
                                        <option value="<?= $valor ?>" <?= ($usuario->tipo === 'adm' && $valor === 'administrador') || $usuario->tipo === $valor ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" name="editar_usuario" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div></div>
            </div>
        <?php endforeach; else: ?>
            <tr><td colspan="5" class="text-center"><p class="alert alert-info">Nenhum usuário encontrado para exibir.</p></td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

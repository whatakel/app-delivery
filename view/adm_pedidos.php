<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="_public/css/style.css" rel="stylesheet">
    <link href="_public/css/adm_pedidos.css" rel="stylesheet">
</head>
 <div class="container shadow-lg p-5 rounded">
    <h2 class="mb-4">Pedidos</h2>
    <table class="table table-bordered table-hover bg-white">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Total</th>
          <th>Status</th>
          <th>Pagamento</th>
          <th>Data</th>
          <th>Ações</th>
          <th>Excluir</th>
        </tr>
      </thead>
      <tbody>
        
        
        <tr>
          <td>1</td>
          <td>João Silva</td>
          <td>R$ 120,00</td>
          <td class="status-pendente">Pendente</td>
          <td>Pix</td>
          <td>07/06/2025</td>
          <td>
            <form method="POST" action="">
              <input type="hidden" name="pedido_id" value="1">
              <select class="form-select form-select-sm" name="status" onchange="this.form.submit()">
                <option selected disabled>Alterar status</option>
                <option value="Pendente">Pendente</option>
                <option value="Preparando">Preparando</option>
                <option value="Saiu para entrega">Saiu para entrega</option>
                <option value="Entregue">Entregue</option>
              </select>
            </form>
          </td>
          <td>
            <form method="POST" action="">
              <input type="hidden" name="pedido_id" value="1">
              <button type="submit" class="btn btn-sm btn-warning">Excluir</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
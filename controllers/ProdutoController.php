<?php
require_once 'models/Produto.php';

class ProdutoController
{
    public function mostrarProdutos()
    {
        $produto = new Produto();
        return $produto->listarProdutos();
    }
}

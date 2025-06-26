<?php

namespace App\Controllers;

use App\Models\Login;
use App\Models\Pedido;
use App\Models\Produtos;
use Exception;

class CarrinhoController
{
    private $login;
    private $produtos;
    private $pedido;

    public function __construct()
    {
        $this->login = new Login();
        $this->login->checkAuth();
        $this->produtos = new Produtos();
        $this->pedido = new Pedido();
    }
    
    public function cart()
    {
        header('Content-Type: application/json');
        try {
            $produtoId = $_POST['produto_id'];
            $produtoSelecionado = $this->produtos->getOrFail($produtoId);
            $carrinho = $this->pedido->cart($_POST,$produtoSelecionado);
            echo json_encode([
                'status' => true,
                'carrinho' => $carrinho
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function cartRemove()
    {
        header('Content-Type: application/json');
        try {
            $carrinho = $this->pedido->cartRemove();
            echo json_encode([
                'status' => true,
                'carrinho' => $carrinho
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\Cupons;
use App\Models\Login;
use App\Models\Pedido;
use App\Models\Produtos;

class PedidosController
{
    private $login;
    private $pedido;
    private $produtos;
    private $cupom;

    public function __construct()
    {
        $this->login = new Login();
        $this->login->checkAuth();
        $this->pedido = new Pedido();
        $this->produtos = new Produtos();
        $this->cupom = new Cupons();
    }

    public function index()
    {
        $pedidos = $this->pedido->list();
        require __DIR__ . '/../Views/pedidos.php';
    }
    
    public function edit($id)
    {
        header('Content-Type: application/json');
        try {
            $form = json_decode(file_get_contents("php://input"), true);
            $this->pedido->edit($id);
            $this->pedido->sendEmail($form);
            echo json_encode([
                'status' => true,
                'message' => 'Editado com sucesso!'
            ]);   
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
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

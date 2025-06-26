<?php

namespace App\Controllers;

use App\Models\Login;
use App\Models\Produtos;
use Exception;

class ProdutosController
{
    private $login;
    private $produtos;

    public function __construct()
    {
        $this->login = new Login();
        $this->login->checkAuth();
        $this->produtos = new Produtos();
    }

    public function index()
    {
        $carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
        require __DIR__ . '/../Views/products.php';
    }
    public function products()
    {
        header('Content-Type: application/json');
        try {
            echo json_encode([
                'status' => true,
                'produtos' => $this->produtos->list()
            ]);   
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'produtos' => []
            ]);
        }
    }
    public function save()
    {
        header('Content-Type: application/json');
        try {
            $this->produtos->save($_POST);

            echo json_encode([
                'status' => true,
                'message' => 'Salvo com sucesso'
            ]);   
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        header('Content-Type: application/json');
        try {
            $form = json_decode(file_get_contents("php://input"), true);
            $this->produtos->getOrFail($id);
            $this->produtos->edit($id,$form);
            echo json_encode([
                'status' => true,
                'message' => 'Editado com sucesso'
            ]);   
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function excluir($id)
    {
        header('Content-Type: application/json');
        try {
            $this->produtos->getOrFail($id);
            $this->produtos->excluir($id);
            echo json_encode([
                'status' => true,
                'message' => 'Removido com sucesso'
            ]);   
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}

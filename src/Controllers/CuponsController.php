<?php

namespace App\Controllers;

use App\Models\Cupons;
use App\Models\Login;
use App\Models\Pedido;
use Exception;

class CuponsController
{
    private $cupons;
    private $login;
    private $pedido;
    public function __construct()
    {
        $this->login = new Login();
        $this->cupons = new Cupons();
        $this->pedido = new Pedido();
    }

    public function index()
    {
        $this->login->checkAuth();
        $cupons = $this->cupons->listarCupons();
        include __DIR__ . "/../Views/cupons.php";
    }

    public function addCupom($id)
    {
        $this->login->checkAuth();
        header('Content-Type: application/json');
        try {
            $form = json_decode(file_get_contents("php://input"), true);
            $cupom = $this->cupons->validarCupom($form['cupom']);
            $carrinho = $this->pedido->addCupomPedido($id, $cupom);
            echo json_encode([
                'status' => true,
                'message' => 'Editado com sucesso!',
                'carrinho' => $carrinho
            ]);   
        } catch (\Throwable $th) {
            echo json_encode([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    
    public function migrarCupons()
    {
        $this->cupons->migrarCupons();
    }
}

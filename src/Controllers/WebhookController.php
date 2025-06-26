<?php

namespace App\Controllers;

use App\Models\Database;
use App\Models\Pedido;

class WebhookController
{
    private $pedido;
    private $db;

    public function __construct()
    {
        $this->pedido = new Pedido();
        $this->db = new Database();
    }

    public function webhook()
    {
        // Verifica autenticação básica
        $user = $_SERVER['PHP_AUTH_USER'] ?? '';
        $pass = $_SERVER['PHP_AUTH_PW'] ?? '';

        if ($user !== 'montink' || $pass !== 'montink') {
            http_response_code(401);
            header('WWW-Authenticate: Basic realm="Montink Webhook"');
            echo json_encode(['status' => false, 'mensagem' => 'Acesso não autorizado']);
            return;
        }

        // Verifica dados do POST
        $idPedido = $_POST['id_pedido'] ?? null;
        $status   = $_POST['status'] ?? null;

        if (!$idPedido || !$status) {
            http_response_code(400);
            echo json_encode(['status' => false, 'mensagem' => 'Dados inválidos']);
            return;
        }

        // Verifica se o pedido existe
        $table  = "pedidos";
        $fields = "id";
        $where  = "id = :id";
        $params = ['id' => $idPedido];

        $pedido = $this->db->select($table, $fields, $where, $params);

        if (empty($pedido)) {
            http_response_code(404);
            echo json_encode(['status' => false, 'mensagem' => 'Pedido não encontrado']);
            return;
        }

        if ($status === 'cancelado') {
            $this->db->delete("pedidos", "id = :id", ['id' => $idPedido]);
            echo json_encode(['status' => true, 'mensagem' => 'Pedido cancelado e deletado']);
        } else {
            $data   = ['status' => $status];
            $where  = "id = :id";
            $params = ['id' => $idPedido];
            $this->db->update("pedidos", $data, $where, $params);
            echo json_encode(['status' => true, 'mensagem' => "Status atualizado para: {$status}"]);
        }
    }
}

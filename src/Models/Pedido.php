<?php

namespace App\Models;

class Pedido extends Database
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();
    }

    public function list()
    {
        $table = "pedidos p
            LEFT JOIN pedido_itens pi ON pi.pedido_id = p.id
            LEFT JOIN produtos prod ON prod.id = pi.produto_id";

        $fields = "p.id, 
            p.status, 
            p.criado_em, 
            pi.quantidade, 
            pi.preco_unitario, 
            prod.nome AS produto_nome";

        $orderBy = "p.id DESC";

        // Consulta
        $result = $this->db->select($table, $fields, '', [], $orderBy);

        // Agrupar itens dentro de cada pedido
        $pedidos = [];

        foreach ($result as $row) {
            $id = $row['id'];

            if (!isset($pedidos[$id])) {
                $pedidos[$id] = [
                    'id'        => $row['id'],
                    'status'    => $row['status'],
                    'criado_em' => $row['criado_em'],
                    'itens'     => []
                ];
            }

            // Adiciona item do pedido
            if (!empty($row['produto_nome'])) {
                $pedidos[$id]['itens'][] = [
                    'produto_nome'   => $row['produto_nome'],
                    'quantidade'     => $row['quantidade'],
                    'preco_unitario' => $row['preco_unitario']
                ];
            }
        }

        return array_values($pedidos);
    }

    
    public function edit($id)
    {
        // Atualizar pedido
            $table = "pedidos";
            $data = [
                'status'       => 'pago'
            ];
            $where = "id = :id";
            $params = ['id' => $id];
            $this->db->update($table, $data, $where, $params);

        // Remover carrinho da sessão
        unset($_SESSION['carrinho']);

    }

    public function addCupomPedido($id_pedido, $cupom)
    {
        // Buscar o total atual do pedido
            $table = "pedidos";
            $fields = "total";
            $where = "id = :id";
            $params = ['id' => $id_pedido];

            $pedido = $this->db->select($table, $fields, $where, $params);

            if (!$pedido || empty($pedido[0])) {
                throw new \Exception("Pedido não encontrado.");
            }

            $pedidoTotal = (float) $pedido[0]['total'];

        // 2. Calcular o valor do desconto
            $desconto = 0;
            if ($cupom['tipo'] === 'percentual') {
                $desconto = $pedidoTotal * ((float) $cupom['valor'] / 100);
            } elseif ($cupom['tipo'] === 'fixo') {
                $desconto = (float) $cupom['valor'];
            }

        // Garante que o total nunca fique negativo
        $novoTotal = max($pedidoTotal - $desconto, 0);

        // 3. Atualizar o pedido no banco com o cupom e novo total
            $data = [
                'id_cupom' => $cupom['id'],
                'total'    => $novoTotal
            ];
            $this->db->update($table, $data, $where, $params);

        // 4. Atualizar o carrinho na sessão
            $_SESSION['carrinho']['cupom'] = [
                'id'      => $cupom['id'],
                'codigo'  => $cupom['codigo'],
                'tipo'    => $cupom['tipo'],
                'valor'   => $cupom['valor'],
                'desconto_aplicado' => $desconto
            ];
            $_SESSION['carrinho']['total_geral'] = $novoTotal;
            return $_SESSION['carrinho'];
    }

    public function cart($produtoPost, $produto)
    {
        // Inicia a sessão do carrinho se não existir
            if (!isset($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = [
                    'id_pedido' => null,
                    'pedidos_itens' => [],
                    'total_geral' => 0
                ];
            }

        // Verifica se há estoque suficiente
            if ($produto['estoque'] === null || $produto['estoque'] < $produtoPost['quantidade']) {
                throw new \Exception("Estoque insuficiente.");
            }

        // Atualiza o estoque do produto
            $this->db->update(
                'estoque',[
                    'quantidade' => $produto['estoque'] - $produtoPost['quantidade'],
                    'atualizado_em' => date('Y-m-d H:i:s')
                ],
                "produto_id = :id",
                ['id' => $produto['id']]
            );

        // Se não existir pedido no carrinho, cria um novo pedido
            if (!$_SESSION['carrinho']['id_pedido']) {
                $this->db->insert(
                    'pedidos',
                    [
                        'total' => 0, // Inicia com zero, vamos calcular depois
                        'criado_em' => date('Y-m-d H:i:s'),
                        'cep' => $produtoPost['cep'],
                        'frete' => 0
                    ]
                );
                $_SESSION['carrinho']['id_pedido'] = $this->db->lastInsertId();
            }

            $id_pedido = $_SESSION['carrinho']['id_pedido'];

        // Cria o item do pedido
            $item = [
                'pedido_id'         => $id_pedido,
                'produto_id'        => $produto['id'],
                'preco_unitario'    => $produto['preco'],
                'quantidade'        => $produtoPost['quantidade'],
            ];

        // Insere o item na tabela pedido_itens
            $this->db->insert(
                'pedido_itens',
                [
                    'pedido_id'  => $item['pedido_id'],
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco_unitario']
                ]
            );

        // Adiciona o item na sessão do carrinho
            $item['produto_nome'] = $produto['nome'];
            $_SESSION['carrinho']['pedidos_itens'][] = $item;

        // Calcula o subtotal dos itens
            $subtotal = 0;
            foreach ($_SESSION['carrinho']['pedidos_itens'] as $item_produto) {
                $subtotal += $item_produto['preco_unitario'] * $item_produto['quantidade'];
            }

        // Aplica a regra do frete
            if ($subtotal >= 52 && $subtotal <= 166.59) {
                $frete = 15.00;
            } elseif ($subtotal > 200) {
                $frete = 0.00; // Frete grátis
            } else {
                $frete = 20.00;
            }

        // Calcula o total geral (subtotal + frete)
        $total_geral = $subtotal + $frete;

        // Atualiza a sessão com frete e total geral
            $_SESSION['carrinho']['total_geral'] = $total_geral;
            $_SESSION['carrinho']['frete'] = $frete;

        // Atualiza total e o frete
            $this->db->update(
                'pedidos',
                [
                    'total' => $total_geral,
                    'frete' => $frete
                ],
                "id = :id",
                ['id' => $id_pedido]
            );

        return $_SESSION['carrinho'];

    }

    public function cartRemove()
    {
        unset($_SESSION['carrinho']);
        return [];
    }

    public function sendEmail($form)
    {
        $to = "leo87gyn@gmail.com";
        $subject = "Novo Pedido - Carrinho";
        
        // Monta o corpo da mensagem
        $message = "Novo pedido recebido:\n\n";
        $message .= "Email: {$form['email']}\n";
        $message .= "Endereço: {$form['endereco']}\n";
        $message .= "Cidade: {$form['cidade']}\n";
        $message .= "Estado: {$form['estado']}\n";
        $message .= "CEP: {$form['cep']}\n";

        // Cabeçalhos do e-mail
        $headers = "From: noreply@seudominio.com\r\n" .
                "Reply-To: {$form['email']}\r\n" .
                "X-Mailer: PHP/" . phpversion();

        // Envia
        if (mail($to, $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }

}

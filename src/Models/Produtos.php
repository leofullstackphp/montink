<?php

namespace App\Models;

class Produtos extends Database
{
    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();
    }

    public function list()
    {
        $table = "produtos p 
        LEFT JOIN variacoes_produtos v ON v.produto_id = p.id
        LEFT JOIN estoque e ON e.produto_id = p.id";

        $fields = "p.*, 
        v.id AS variacao_id, 
        v.tipo, 
        v.valor, 
        e.quantidade AS estoque";

        $orderBy = "p.id ASC";

        // Faz a consulta
        $result = $this->db->select($table, $fields, '', [], $orderBy);

        // Agrupar variações dentro dos produtos
        $produtos = [];

        foreach ($result as $row) {
            $id = $row['id'];

            // Se o produto ainda não existe no array, adiciona
            if (!isset($produtos[$id])) {
                $produtos[$id] = [
                    'id'         => $row['id'],
                    'nome'       => $row['nome'],
                    'preco'      => $row['preco'],
                    'criado_em'  => $row['criado_em'],
                    'estoque'    => (int) $row['estoque'],
                    'variacoes'  => []
                ];
            }

            // Se existe variação, adiciona
            if (!empty($row['variacao_id'])) {
                $produtos[$id]['variacoes'][] = [
                    'id'    => $row['variacao_id'],
                    'tipo'  => $row['tipo'],
                    'valor' => $row['valor']
                ];
            }
        }

        return array_values($produtos);
    }

    public function save($produto)
    {
        // Capta
        $nome = $produto['nome'];
        $preco = $produto['preco'];
        $estoque = $produto['estoque'];
        $variacoes = isset($produto['variacoes']) ? $produto['variacoes'] : [];

        // Valida
        $this->validate($nome, $preco);

        // Processa    
        $table = "produtos";
        $data = [
            'nome'       => $nome,
            'preco'      => $preco,
            'criado_em'  => date('Y-m-d H:i:s')
        ];

        $this->db->insert($table, $data);

        $id = $this->db->lastInsertId();

        $table = "estoque";
        $data = [
            'produto_id' => $id,
            'quantidade' => $estoque,
            'atualizado_em' => date('Y-m-d H:i:s')
        ];
        $this->db->insert($table, $data);

        foreach ($variacoes as $variacao) {
            $table = "variacoes_produtos";
            $data = [
                'produto_id' => $id,
                'tipo'       => $variacao['tipo'],
                'valor'      => $variacao['valor']
            ];
            $this->db->insert($table, $data);
        }
    }

    public function getOrFail($id)
    {
        $table = "produtos 
            LEFT JOIN estoque e ON e.produto_id = produtos.id";

        $fields = "produtos.id, 
            produtos.nome, 
            produtos.preco, 
            e.quantidade AS estoque";

        $where = "produtos.id = :id";
        $params = ['id' => $id];

        $produto = $this->db->select($table, $fields, $where, $params);

        if (count($produto) == 0) {
            throw new \Exception('Produto não encontrado.');
        }

        return $produto[0];
    }


    public function edit($id, $produto)
    {
        //  Atualizar produto
        $table = "produtos";
        $data = [
            'nome'       => $produto['nome'],
            'preco'      => $produto['preco']
        ];
        $where = "id = :id";
        $params = ['id' => $id];
        $this->db->update($table, $data, $where, $params);

        //  Atualizar estoque
        $table = "estoque";
        $data = [
            'quantidade' => $produto['estoque'],
            'atualizado_em' => date('Y-m-d H:i:s')
        ];
        $where = "produto_id = :id";
        $params = ['id' => $id];
        $this->db->update($table, $data, $where, $params);

        // Atualizar variações
        $table = "variacoes_produtos";
        $this->db->delete($table, "produto_id = :id", ['id' => $id]);
        foreach ($produto['variacoes'] as $variacao) {
            $data = [
                'produto_id' => $id,
                'tipo'       => $variacao['tipo'],
                'valor'      => $variacao['valor']
            ];
            $this->db->insert($table, $data);
        }
    }

    public function excluir($id)
    {
        $table = "produtos";
        $where = "id = :id";
        $params = ['id' => $id];
        $this->db->delete($table, $where, $params);
    }



    public function validate($nome, $preco)
    {
        if (empty($nome)) {
            throw new \Exception('O nome do produto precisa ser preenchido.');
        }
        if (empty($preco)) {
            throw new \Exception('O preco do produto precisa ser preenchido.');
        }
    }
}

<?php

namespace App\Models;

class Cupons extends Database
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();
    }

    public function migrarCupons()
    {
        $this->iniciarMigracao('cupons');

        $caminhoCsv = __DIR__ . '/../../cupons.csv';

        if (!file_exists($caminhoCsv)) {
            echo "\033[31m[ERRO] Arquivo cupons.csv não encontrado.\033[0m\n";
            return;
        }

        $contador = 0;

        if (($handle = fopen($caminhoCsv, "r")) !== false) {
            $linha = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($linha === 0) {
                    $linha++;
                    continue;
                }

                list($codigo, $tipo, $valor, $quantidade_uso, $usado, $validade) = $data;

                $this->db->insert("cupons", [
                    'codigo'         => $codigo,
                    'tipo'           => $tipo,
                    'valor'          => $valor,
                    'quantidade_uso' => $quantidade_uso,
                    'usado'          => $usado,
                    'validade'       => $validade
                ]);

                echo "✔️  Cupom inserido: {$codigo}\n";
                $contador++;
                $linha++;
            }
            fclose($handle);
        } else {
            echo "\033[31m[ERRO] Falha ao abrir o arquivo CSV.\033[0m\n";
            return;
        }

        $this->logRegistrosObtidos($contador);
        $this->finalizarMigracao('cupons');
    }

    public function listarCupons()
    {
        $cupons = $this->db->select('cupons', '*');
        return $cupons;
    }

   public function validarCupom(string $codigo)
    {
        $table = "cupons";
        $fields = "*";
        $where = "codigo = :codigo";
        $params = ['codigo' => $codigo];

        $cupom = $this->db->select($table, $fields, $where, $params);

        if (!$cupom || empty($cupom[0])) {
            throw new \Exception("Cupom não encontrado.");
        }

        $cupom = $cupom[0]; // como seu select retorna um array de resultados

        $hoje = date('Y-m-d');
        if ($cupom['validade'] < $hoje) {
            throw new \Exception("Cupom expirado.");
        }

        return $cupom;
    }



    // Métodos auxiliares

    private function horaAtual(): string
    {
        return date('H:i:s');
    }

    private function iniciarMigracao(string $nomeRequisicao): void
    {
        $hora = $this->horaAtual();
        echo "\033[32m[$hora] ▶️  Iniciando a migração...\033[0m\n";
        sleep(1);
    }

    private function logRegistrosObtidos(int $quantidade): void
    {
        $hora = $this->horaAtual();
        $textoQtd = $quantidade === 1 ? '1 registro foi obtido' : "$quantidade registros foram obtidos";
        echo "\033[34m[$hora] 📦 $textoQtd para inserção no banco de dados.\033[0m\n";
        sleep(1);
    }

    private function finalizarMigracao(string $nomeRequisicao): void
    {
        $hora = $this->horaAtual();
        echo "\033[36m[$hora] ✅ Migração de '$nomeRequisicao' concluída com sucesso!\033[0m\n";
    }
}

<?php

namespace App\Models;

use PDO;
use PDOException;

class Database {
    private $pdo;
    private $stmt;
    private $error;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $host = $_ENV['DB_HOST'];
        $db = $_ENV['DB_DATABASE'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Connection failed: " . $this->error;
        }
    }

    public function query($sql, $params = []) {
        $this->stmt = $this->pdo->prepare($sql);
        $this->bind($params);
    }

    private function bind($params) {
        foreach ($params as $key => $value) {
            $this->stmt->bindValue(is_int($key) ? $key + 1 : ":$key", $value);
        }
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount() {
        return $this->stmt->rowCount();
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }

    public function closeConnection() {
        $this->stmt = null;
        $this->pdo = null;
    }

    public function insert($table, $data) {
        $keys = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($keys) VALUES ($placeholders)";
        $this->query($sql, $data);
        $this->execute();

        return $this->lastInsertId();
    }

    public function update($table, $data, $where, $whereParams = []) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');
    
        $sql = "UPDATE $table SET $fields WHERE $where";
        
        // Mesclar os parâmetros de dados e os parâmetros do where
        $params = array_merge($data, $whereParams);
        
        $this->query($sql, $params);
        return $this->execute();
    }
    

   public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        $this->query($sql, $params);
        return $this->execute();
    }

    public function select($table, $fields = '*', $where = '', $params = [], $orderBy = '') {
        $sql = "SELECT $fields FROM $table";
        
        // Adiciona a cláusula WHERE, se existir
        if ($where) {
            $sql .= " WHERE $where";
        }
    
        // Adiciona a cláusula ORDER BY, se existir
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
    
        $this->query($sql, $params);
        return $this->resultSet();
    }
    
}

<?php

namespace App\Controllers;

use App\Models\Login;

class LoginController
{
    private $login;

    public function __construct()
    {
        $this->login = new Login();
    }

    public function index()
    {
        // Se já estiver logado, manda para o dashboard
        if ($this->login->isAuthenticated()) {
            header('Location: /dashboard');
            exit;
        }

        require __DIR__ . '/../Views/login.php';
    }

    public function login()
    {
        $document = $_POST['document'] ?? '';
        $password = $_POST['password'] ?? '';

        try {
            if ($this->login->login($document, $password)) {
                $this->login->setSession($document);
                header('Location: /dashboard');
                exit;
            } else {
                throw new \Exception('Documento ou senha incorretos.');
            }
        } catch (\Exception $e) {
            header('Location: /login?error=1');
            exit;
        }
    }

    public function logout()
    {
        $this->login->logout();
    }
}

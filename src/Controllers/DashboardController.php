<?php

namespace App\Controllers;

use App\Models\Login;

class DashboardController
{
    private $login;

    public function __construct()
    {
        $this->login = new Login();
        $this->login->checkAuth(); // Se não tiver sessão, volta pro login
    }

    public function index()
    {
        require __DIR__ . '/../Views/dashboard.php';
    }
}

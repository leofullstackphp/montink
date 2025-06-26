<?php

use App\Controllers\CuponsController;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

// Inicializa e carrega as variáveis de ambiente do .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$cuponsController = new CuponsController();
$cuponsController->migrarCupons();
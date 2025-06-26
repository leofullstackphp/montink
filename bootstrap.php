<?php

use Dotenv\Dotenv;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

// Inicializa e carrega as variáveis de ambiente do .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configura o roteador
    $dispatcher = simpleDispatcher(function(RouteCollector $r) {
        $r->addRoute('GET', '/', 'App\Controllers\LoginController@index');
        $r->addRoute('GET', '/404', 'App\Controllers\HomeController@notFound');
        $r->addRoute('GET', '/usuario/{id:\d+}', 'App\Controllers\HomeController@show');
        $r->addRoute('GET', '/login', 'App\Controllers\LoginController@index');
        $r->addRoute('GET', '/logout', 'App\Controllers\LoginController@logout');
        $r->addRoute('POST', '/login', 'App\Controllers\LoginController@login');
        $r->addRoute('GET', '/dashboard', 'App\Controllers\DashboardController@index');
        $r->addRoute('GET', '/produtos', 'App\Controllers\ProdutosController@index');
        $r->addRoute('GET', '/api/produtos', 'App\Controllers\ProdutosController@products');
        $r->addRoute('POST', '/api/produtos', 'App\Controllers\ProdutosController@save');
        $r->addRoute('PUT', '/api/produtos/{id:\d+}', 'App\Controllers\ProdutosController@edit');
        $r->addRoute('DELETE', '/api/produtos/{id:\d+}', 'App\Controllers\ProdutosController@excluir');
        $r->addRoute('POST', '/api/carrinho', 'App\Controllers\PedidosController@cart');
        $r->addRoute('DELETE', '/api/carrinho', 'App\Controllers\PedidosController@cartRemove');
        $r->addRoute('PUT', '/api/carrinho/{id:\d+}', 'App\Controllers\PedidosController@edit');
        $r->addRoute('GET', '/cupons', 'App\Controllers\CuponsController@index');
        $r->addRoute('PUT', '/api/carrinho/{id:\d+}/cupom', 'App\Controllers\CuponsController@addCupom');
        $r->addRoute('POST', '/api/webhook', 'App\Controllers\WebhookController@webhook');
        $r->addRoute('GET', '/pedidos', 'App\Controllers\PedidosController@index');

    });

    // Obtém as informações da rota atual
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // Remove a query string da URI, se houver
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    // Faz o roteamento
    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            header('Location: /404');
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            http_response_code(405);
            echo '405 - Método não permitido';
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];

            [$controller, $method] = explode('@', $handler);
            $controller = new $controller();
            call_user_func_array([$controller, $method], $vars);
            break;
}

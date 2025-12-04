<?php

require_once __DIR__ . '/controllers/ContaController.php';

$controller = new ContaController();
$acao = $_GET['acao'] ?? 'home';

switch ($acao) {
    case 'listar':
        $controller->listar();
        break;
    case 'cadastrar':
        $controller->cadastrar();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'movimentar':
        $controller->movimentar();
        break;
    default:
        require __DIR__ . '/views/home.php';
        break;
}

<?php
use DI\Container;
use Slim\Factory\AppFactory;

require 'System/DatabaseConnector.php';
require 'Services/InventoryService.php';
require 'Services/CpuService.php';
require 'Controllers/InventoryController.php';
require 'Controllers/CpuController.php';

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

// Create app for routing
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Setup Controllers
$container->set('InventoryController', function() {
    $inventoryService = new InventoryService(DatabaseConnector::getInstance());
    return new InventoryController($inventoryService);
});
$container->set('CpuController', function() {
    $cpuService = new CpuService(DatabaseConnector::getInstance());
    return new CpuController($cpuService);
});

// Middleware (all requests go through this first)
$app->add(function ($request, $handler) {
    // add JSON content header
    $response = $handler->handle($request);

    // Allow cross origin requests for required domains
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8888')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('Content-Type', 'application/json');
    return $response;
});


//Create Routes -----------------------------------------------------

// - /inventory
$app->get('/inventory',  \InventoryController::class . ':getAll'); 
$app->get('/inventory/{id}', \InventoryController::class . ':getOne'); 
$app->post('/inventory',\InventoryController::class . ':create');
$app->put('/inventory',\InventoryController::class . ':put');
$app->options('/inventory', \InventoryController::class . ':default');

// - /cpu
$app->get('/cpu', \CpuController::class . ':getAll');
$app->get('/cpu/{id}', \CpuController::class . ':getOne');
$app->post('/cpu', \CpuController::class . ':create');
$app->options('/cpu', \CpuController::class . ':default');

// -------------------------------------------------------------------

// Start App
$app->run();

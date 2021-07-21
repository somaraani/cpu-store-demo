<?php
require 'BaseController.php';
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class InventoryController extends BaseController
{

    private $inventoryService;

    public function __construct($inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $response->getBody()->write($this->inventoryService->getAll());
        return $response;
    }

    public function getOne(Request $request, Response $response, $args)
    {
        $item = $this->inventoryService->get($args['id']);
        if (is_null($item)) {
            // if null, return 404
            $response = $response->withStatus(404);
            $response->getBody()->write($this->error("An item with id " . $args['id'] . " was not found."));
            return $response;
        }

        $response->getBody()->write($item);
        return $response;
    }

    public function create(Request $request, Response $response, $args)
    {
        $params = $request->getParsedBody();
        if ($this->paramsInvalid($params, $response, array('id', 'price', 'quantity'))) {
            return $response->withStatus(400);
        }

        $this->inventoryService->create($params['id'], $params['quantity'], $params['price']);
        $response->getBody()->write($this->inventoryService->get($params['id']));
        return $response;
    }

    public function put(Request $request, Response $response, $args)
    {
        $params =  $request->getParsedBody();

        if ($this->paramsInvalid($params, $response, array('id', 'price', 'quantity'))) {
            return $response;
        }

        $item = $this->inventoryService->get($params["id"]);
        if (is_null($item)) {
            // if null, return 404
            $response = $response->withStatus(404);
            $response->getBody()->write($this->error("An item with id " . $params["id"] . " was not found."));
            return $response;
        }

        $this->inventoryService->update($params["id"], $params["quantity"], $params["price"]);

        $response->withStatus(200); // 201: Created
        $response->getBody()->write($this->inventoryService->get($params["id"]));
        return $response;
    }
}

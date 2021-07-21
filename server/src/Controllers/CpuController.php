<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CpuController extends BaseController
{

    private $cpuService;

    public function __construct($cpuService)
    {
        $this->cpuService = $cpuService;
    }

    public function getAll(Request $request, Response $response, $args)
    {
        $getOnlyInStock = $request->getQueryParams()['filterInStock'] ?? 'false';

        if($getOnlyInStock == 'true') {
            $response->getBody()->write($this->cpuService->getOnlyInStock());
        }else {
            $response->getBody()->write($this->cpuService->getAll());
        }

        return $response;
    }

    public function getOne(Request $request, Response $response, $args)
    {
        $item = $this->cpuService->get($args['id']);
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
        if ($this->paramsInvalid($params, $response, array('manufacturer', 'model', 'speed', 'cores'))) {
            return $response->withStatus(400);
        }

        $id = $this->cpuService->create($params['manufacturer'], $params['model'], $params['speed'], $params['cores'], $params['imgurl']);
        $response->getBody()->write($this->cpuService->get($id));
        return $response->withStatus(201);
    }
}

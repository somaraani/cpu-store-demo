<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{

    // Checks a list of parameters against a list of required parameters, 
    // If invalid, returns true, and sets response, otherwise returns false
    function paramsInvalid($params, $response, $requiredParams)
    {
        $missing = array();
        foreach ($requiredParams as &$requiredParam) {
            if (!isset($params[$requiredParam])) {
                array_push($missing, $requiredParam);
            }
        }

        if (!empty($missing)) {
            // if any variables are missing, return 400 with proper message
            $response->getBody()->write($this->error("The variables " . implode(',', $missing) . " must be set."));
            return true;
        }

        return false;
    }

    // parses an error message as a json
    function error($msg)
    {
        return json_encode(["errorMsg" => $msg]);
    }

    function default(Request $request, Response $response, $args) {
        return $response;
    }
}

<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use UnexpectedValueException;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!$request->hasHeader('Authorization')) {
            return Services::response()->setHeader('Content-Type', 'application/json')->setBody(json_encode(["message" => "Invalid Token"]))->setStatusCode(401);
        }

        $tokenRaw = $request->getHeaderLine('Authorization');
        $token = explode(" ", $tokenRaw)[1];

        $key = getenv('TOKEN_SECRET');

        $decoded = "";

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (UnexpectedValueException $e) {
            return Services::response()->setHeader('Content-Type', 'application/json')->setBody(json_encode(["message" => "Invalid Token"]))->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}

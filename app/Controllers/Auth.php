<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    protected $modelName = 'App\Models\UsersModel';
    protected $format    = 'json';

    public function login()
    {
        $username = $this->request->getJSON()->username;
        $password = $this->request->getJSON()->password;

        if ($username === "")
            return $this->respond(["message" => "Username cannot be empty"], 400);

        if ($password === "")
            return $this->respond(["message" => "Password cannot be empty"], 400);

        $user = $this->model->where('username', $username)->first();

        if (!$user)
            return $this->respond(["message" => "Wrong password or username"], 401);


        $correctHash = $user["password"];

        if (!password_verify($password, $correctHash))
            return $this->respond(["message" => "Wrong password or username"], 401);

        $payload = [
            "id" => $user["id"],
        ];

        $key = getenv('TOKEN_SECRET');

        $jwt = JWT::encode($payload, $key, 'HS256');

        return $this->respond(["data" => [
            "token" => "Bearer " . $jwt
        ]], 200);
    }

    public function register()
    {
        $username = $this->request->getJSON()->username;
        $password = $this->request->getJSON()->password;

        if ($username === "")
            return $this->respond(["message" => "Username cannot be empty"], 400);

        if ($password === "")
            return $this->respond(["message" => "Password cannot be empty"], 400);

        $user = $this->model->where('username', $username)->find();

        if ($user)
            return $this->respond(["message" => "Username already exist"], 400);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->model->insert([
            "username" => $username,
            "password" => $hash,
        ]);

        return $this->respond(["message" => "User created", "data" => [
            "id" => $this->model->getInsertId()
        ]], 201);
    }
}

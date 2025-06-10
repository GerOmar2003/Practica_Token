<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'vendor/autoload.php';

$secretKey = "CLAVE_SECRETA_123"; // Cambia esta clave por una más segura

function crearJWT($usuario) {
    global $secretKey;
    $payload = [
        'iss' => 'http://localhost',
        'aud' => 'http://localhost',
        'iat' => time(),
        'exp' => time() + 60, // 3 minutos de validez
        'user' => $usuario,
        "codigo" => str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT)
    ];

    return JWT::encode($payload, $secretKey, 'HS256');
}

function verificarJWT($token) {
    global $secretKey;

    try {
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}

$codigo = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);


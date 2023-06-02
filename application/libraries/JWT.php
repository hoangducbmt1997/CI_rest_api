<?php
use Firebase\JWT\JWT;

class JWT
{
    public function encode($payload, $key)
    {
        return JWT::encode($payload, $key);
    }

    public function decode($jwt, $key)
    {
        return JWT::decode($jwt, $key, array('HS256'));
    }
}

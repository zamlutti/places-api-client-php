<?php

class AuthenticationBuilder
{
    private $login;
    private $key;

    public function __construct($login, $key)
    {
        $this->login = $login;
        $this->key = $key;
    }

    public function generateHash($date, $uri)
    {
        return 'GET\n' . $date . '\n' . $uri . '\n' . $this->login;

    }

    public function generateSignature($hashContent)
    {
        return hexdec(hash_hmac('sha1', $hashContent, $this->key));
    }

    public function generateBase($signature)
    {
        return $this->login . ':' . $signature;
    }

    public function build($authBase)
    {
        return base64_encode($authBase);
    }
}
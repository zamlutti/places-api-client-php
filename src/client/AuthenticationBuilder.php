<?php

class AuthenticationBuilder
{
    private $login;
    private $key;
    private $authenticationString;

    public function __construct($login, $key)
    {
        $this->login = $login;
        $this->key = $key;
        $this->authenticationString = '';
    }

    public function withHashContent($date, $uri)
    {
        $this->authenticationString = sprintf("GET\n%s\n%s\n%s", $date, $uri, $this->login);
        return $this;

    }

    public function withSignature()
    {
        $this->authenticationString = hash_hmac('sha1', $this->authenticationString, $this->key);
        return $this;
    }

    public function withBase()
    {
        $this->authenticationString = sprintf("%s:%s", $this->login, $this->authenticationString);
        return $this;
    }

    public function build()
    {
        return base64_encode($this->authenticationString);
    }
}
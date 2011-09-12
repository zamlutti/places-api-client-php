<?php

class CategorySearcher
{
    private $client;

    public function __construct(HttpClientWrapper $client)
    {
        $this->client = $client;
    }

    public function getAll($login, $key)
    {
        return $this->client->request('/categories', $login, $key);
    }

}

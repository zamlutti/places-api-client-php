<?php

class CategorySearcher
{
    private $client;

    public function __construct(HttpClientWrapper $client)
    {
        $this->client = $client;
    }

    public function getAll()
    {
        return $this->client->request('/categories');
    }

}

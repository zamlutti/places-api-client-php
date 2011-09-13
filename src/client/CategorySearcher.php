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
        return simplexml_load_string($this->client->request('/categories'));
    }

}

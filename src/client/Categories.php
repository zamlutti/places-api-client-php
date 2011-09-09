<?php

class Categories 
{
    private $client;
    
    public function __construct(HttpClient $client) {
        $this->client = $client;
    }
    
    public function getAll() {
        return $this->client->request('/categories');
    }

}

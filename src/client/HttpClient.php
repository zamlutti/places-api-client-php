<?php

class HttpClient
{    
    private $baseUri;
    public function __construct($baseUri) {
        $this->baseUri = $baseUri;
    }
    
    public function request($call) {
        return file_get_contents($this->baseUri . $call);
    }
}

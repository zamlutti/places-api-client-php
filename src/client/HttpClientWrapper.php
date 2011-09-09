<?php

class HttpClientWrapper
{
    private $host;
    public function __construct($host) {
        $this->host = $host;
    }

    public function request($call) {
        return file_get_contents($this->host . $call);
    }
}

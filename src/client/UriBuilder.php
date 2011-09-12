<?php

class UriBuilder
{
    private $baseCall;
    private $queryBuilt;

    public function __construct()
    {

    }

    public function build()
    {
        return empty($this->queryBuilt)
                ? ''
                : $this->queryBuilt;
    }

    public function withBase($baseCall)
    {
        $this->baseCall = $baseCall;
        $this->queryBuilt = $baseCall;
        return $this;
    }

    public function withParameter($parameter, $value)
    {
        $concat = $this->isFirstParameter() ? '?' : '&';
        $this->queryBuilt = $this->queryBuilt . $concat .
                            urlencode($parameter) . '=' . urlencode($value);
        return $this;
    }

    private function isFirstParameter()
    {
        return ($this->queryBuilt == $this->baseCall);
    }
}
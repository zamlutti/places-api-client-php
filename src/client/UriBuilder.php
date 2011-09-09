<?php

class UriBuilder
{
    private $baseCall;
    private $queryBuilt;

    public function __construct() {

    }

    public function buildQuery() {
        return empty($this->queryBuilt)
                    ? ''
                    : $this->queryBuilt;
    }

    public function setBase($baseCall) {
        $this->baseCall = $baseCall;
        $this->queryBuilt = $baseCall;
    }

    public function addParameter($parameter, $value) {
        $concat = $this->isFirstParameter() ? '?' : '&';
        $this->queryBuilt = $this->queryBuilt . $concat .
                            urlencode($parameter) . '=' . urlencode($value);

    }

    private function isFirstParameter() {
        return ($this->queryBuilt == $this->baseCall);
    }
}
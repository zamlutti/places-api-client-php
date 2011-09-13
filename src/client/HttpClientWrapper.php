<?php

class HttpClientWrapper
{
    private $host;
    private $authenticationBuilder;

    public function __construct($host, AuthenticationBuilder $authenticationBuilder)
    {
        $this->host = $host;
        $this->authenticationBuilder = $authenticationBuilder;
    }

    public function request($call)
    {
        $url = $this->host . $call;

        $ch = $this->initialize();
        $this->setUrl($ch, $url);

        $date = $this->getFormattedDate();

        $auth = $this->authenticationBuilder
                ->withHashContent($date, $url)
                ->withSignature()
                ->withBase()
                ->build();

        $this->addAuthenticationHeaders($ch, $date, $auth);

        $this->setOptions($ch);

        $response = $this->getResponse($ch);
        $info = $this->getInfo($ch);
        $this->closeConnection($ch);


        if ($info['http_code'] == 200 || $info['http_code'] == 404) {
            return $response;
        }

        throw new Exception($response, $info['http_code']);
    }

    private function initialize()
    {
        return curl_init();
    }

    private function addAuthenticationHeaders($ch, $date, $auth)
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array('X-Maplink-Date: ' . $date, 'Authorization: MAPLINKWS ' . $auth));
    }

    private function setUrl($ch, $url)
    {
        curl_setopt($ch, CURLOPT_URL, $url);
    }

    private function setOptions($ch)
    {
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    }

    private function getFormattedDate()
    {
        date_default_timezone_set('GMT');
        return date('D, d M Y H:i:s e');
    }

    private function getResponse($ch)
    {
        return curl_exec($ch);
    }

    private function getInfo($ch)
    {
        return curl_getinfo($ch);
    }

    private function closeConnection($ch)
    {
        curl_close($ch);
    }
}

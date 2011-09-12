<?php

class PlaceSearcher
{

    private $client;
    private $queryBuilder;

    public function __construct(HttpClientWrapper $client, UriBuilder $queryBuilder)
    {
        $this->client = $client;
        $this->queryBuilder = $queryBuilder;
    }

    public function byRadius($login, $key, $radius, $latitude, $longitude, $term = null,
        $categoryId = null, $startIndex = null)
    {

        $this->queryBuilder->setBase('/places/byradius');
        $this->queryBuilder->addParameter('radius', $radius);
        $this->queryBuilder->addParameter('latitude', $latitude);
        $this->queryBuilder->addParameter('longitude', $longitude);

        if (!empty($term)) {
            $this->queryBuilder->addParameter('term', $term);
        }

        if (!is_null($categoryId)) {
            $this->queryBuilder->addParameter('category', $categoryId);
        }

        if (!empty($startIndex)) {
            $this->queryBuilder->addParameter('start', $startIndex);
        }

        return $this->client->request($this->queryBuilder->buildQuery(), $login, $key);
    }

    public function byUri($login, $key, $uri)
    {
        return $this->client->request($uri, $login, $key);
    }
}


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

    public function byRadius($radius, $latitude, $longitude, $term = null,
        $categoryId = null, $startIndex = null)
    {

        $this->queryBuilder->withBase('/places/byradius');
        $this->queryBuilder->withParameter('radius', $radius);
        $this->queryBuilder->withParameter('latitude', $latitude);
        $this->queryBuilder->withParameter('longitude', $longitude);

        if (!empty($term)) {
            $this->queryBuilder->withParameter('term', $term);
        }

        if (!is_null($categoryId)) {
            $this->queryBuilder->withParameter('category', $categoryId);
        }

        if (!empty($startIndex)) {
            $this->queryBuilder->withParameter('start', $startIndex);
        }

        return new SimpleXMLElement($this->client->request($this->queryBuilder->build()));
    }

    public function byUri($uri)
    {
        return new SimpleXMLElement($this->client->request($uri));
    }
}


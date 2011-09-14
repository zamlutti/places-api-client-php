<?php

class PlaceSearcher
{
    private $client;
    private $queryBuilder;
    private $placesConverter;

    public function __construct(HttpClientWrapper $client, UriBuilder $queryBuilder, PlacesConverter $placesConverter)
    {
        $this->client = $client;
        $this->queryBuilder = $queryBuilder;
        $this->placesConverter = $placesConverter;
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

        $response = $this->client->request($this->queryBuilder->build());
        return $this->placesConverter->toPlaceResult($response);
    }

    public function byUri($uri)
    {
        $response = $this->client->request($uri);
        return $this->placesConverter->toPlaceResult($response);
    }
}


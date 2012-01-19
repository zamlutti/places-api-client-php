<?php

class PlaceSearcher
{
    private $client;
    private $uriBuilder;
    private $placesConverter;

    public function __construct(HttpClientWrapper $client, UriBuilder $uriBuilder, PlacesConverter $placesConverter)
    {
        $this->client = $client;
        $this->uriBuilder = $uriBuilder;
        $this->placesConverter = $placesConverter;
    }

    public function byRadius($radius, $latitude, $longitude, $term = null,
                             $categoryId = null, $startIndex = null)
    {
        $this->uriBuilder->withBase('/places/byradius');
        $this->uriBuilder->withParameter('radius', $radius);
        $this->uriBuilder->withParameter('latitude', $latitude);
        $this->uriBuilder->withParameter('longitude', $longitude);

        if (!empty($term)) {
            $this->uriBuilder->withParameter('term', $term);
        }

        if (!is_null($categoryId)) {
            $this->uriBuilder->withParameter('category', $categoryId);
        }

        if (!empty($startIndex)) {
            $this->uriBuilder->withParameter('start', $startIndex);
        }

        $response = $this->client->request($this->uriBuilder->build());
        return $this->placesConverter->toPlaceResult($response);
    }

    public function byTerm($term, $state = null, $city = null, $startIndex = null)
    {
        $this->uriBuilder->withBase('/places/byterm');
        $this->uriBuilder->withParameter('term', $term);

        if (!empty($state)) {
            $this->uriBuilder->withParameter('state', $state);
        }

        if (!empty($city)) {
            $this->uriBuilder->withParameter('city', $city);
        }

        if (!empty($startIndex)) {
            $this->uriBuilder->withParameter('start', $startIndex);
        }

        $response = $this->client->request($this->uriBuilder->build());
        return $this->placesConverter->toPlaceResult($response);
    }

    public function byCategory($categoryId, $state = null, $city = null, $startIndex = null)
    {
        $this->uriBuilder->withBase('/places/bycategory');
        $this->uriBuilder->withParameter('category', $categoryId);

        if (!empty($state)) {
            $this->uriBuilder->withParameter('state', $state);
        }

        if (!empty($city)) {
            $this->uriBuilder->withParameter('city', $city);
        }

        if (!empty($startIndex)) {
            $this->uriBuilder->withParameter('start', $startIndex);
        }

        $response = $this->client->request($this->uriBuilder->build());
        return $this->placesConverter->toPlaceResult($response);
    }

    public function byUri($uri)
    {
        $response = $this->client->request($uri);
        return $this->placesConverter->toPlaceResult($response);
    }
}


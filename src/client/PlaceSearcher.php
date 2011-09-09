<?php

class PlaceSearcher {

    private $client;
    private $queryBuilder;

    public function __construct(HttpClient $client, UriBuilder $queryBuilder) {
        $this->client = $client;
        $this->queryBuilder = $queryBuilder;
    }

    public function byRadius($radius, $latitude, $longitude, $term = null,
                             $categoryId = null, $startIndex = null) {

        $this->queryBuilder->setBase('/places/byradius');
        $this->queryBuilder->addParameter('radius', $radius);
        $this->queryBuilder->addParameter('latitude', $latitude);
        $this->queryBuilder->addParameter('longitude', $longitude);

        if(!empty($term)) {
            $this->queryBuilder->addParameter('term', $term);
        }

        if(!is_null($categoryId)) {
            $this->queryBuilder->addParameter('category', $categoryId);
        }

        if(!empty($startIndex)) {
            $this->queryBuilder->addParameter('start', $startIndex);
        }

        return $this->client->request($this->queryBuilder->buildQuery());
    }
}


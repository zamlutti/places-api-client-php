<?php

class PlaceSearcher {

    private $client;

    public function __construct(HttpClient $client) {
        $this->client = $client;
    }

    public function byRadius($radius, $latitude, $longitude, $term = null,
                             $category = null, $startIndex = null) {

        $call = sprintf('/places/byradius?radius=%.2f&latitude=%.2f&longitude=%.2f',
                        $radius, $latitude, $longitude);

        if(!empty($term)) {
            $call .= '&term=' . $term;
        }

        if(!empty($category)) {
            $call .= '&category=' . $category;
        }

        if(!empty($startIndex)) {
            $call .= '&start=' . $startIndex;
        }

        return $this->client->request($call);
    }
}


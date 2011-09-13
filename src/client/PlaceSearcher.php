<?php
require_once 'XML/Unserializer.php';

class PlaceSearcher
{

    private $client;
    private $queryBuilder;
    private $unserializer;
    private $options = array(
        'complexType' => 'object',
        'tagMap' => array(
            'places' => 'PlaceResult',
            'place' => 'Place',
            'start-index' => 'startIndex',
            'total-found' => 'totalFound',
            'zip-code' => 'zipCode',
            'sub-category' => 'subCategory',
            'distance' => 'distanceInKilometers',
        ),
        'keyAttribute' => array(
            'atom:link' => 'rel'
        ),
        'returnResult' => true

    );

    public function __construct(HttpClientWrapper $client, UriBuilder $queryBuilder)
    {
        $this->client = $client;
        $this->queryBuilder = $queryBuilder;
        $this->unserializer = &new XML_Unserializer($this->options);
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

        return $this->unserializer->unserialize($response);
    }

    public function byUri($uri)
    {
        $response = $this->client->request($uri);
        return $this->unserializer->unserialize($response);
    }
}


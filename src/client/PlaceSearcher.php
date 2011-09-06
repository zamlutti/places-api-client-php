<?php

class PlaceSearcher {

    private $placeSearchResultFactory;

    public function __construct(PlaceSearchResultFactory $placeSearchResultFactory){
        $this->placeSearchResultFactory = $placeSearchResultFactory;
    }

    public function byRadius(PlaceSearchRequest $placeSearchRequest){
        return $this->placeSearchResultFactory->create();
    }
}

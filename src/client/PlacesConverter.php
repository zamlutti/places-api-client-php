<?php
require_once 'XML/Unserializer.php';

class PlacesConverter
{
    private $placeResult;
    private $unserializer;
    private $options = array(
        'parseAttributes' => true,
        'keyAttribute' => array(
            'atom:link' => 'rel'
        ),
        'returnResult' => true
    );

    public function __construct(){
        $this->placeResult = new PlaceResult();
        $this->unserializer = &new XML_Unserializer($this->options);
    }

    public function toPlaceResult($response)
    {
        $placesSerialized = $this->unserializer->unserialize($response);

        $this->placeResult->places = $placesSerialized["place"];
        $this->placeResult->totalFound = $placesSerialized["total-found"];
        $this->placeResult->startIndex = $placesSerialized["start-index"];
        $this->placeResult->previous = $placesSerialized["previous"]["href"];
        $this->placeResult->next = $placesSerialized["next"]["href"];
        
        return $this->placeResult;
    }
}

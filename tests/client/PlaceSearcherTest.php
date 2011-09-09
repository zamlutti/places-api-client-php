<?php
include_once('../Autoloader.php');

class PlaceSearcherTest extends PHPUnit_Framework_TestCase{

    public function testRetrieveByRadius(){
        $placeSearchResultCreated = new PlaceSearchResult();

        $factoryStubbed = $this->getMock("PlaceSearchResultFactory");
        $factoryStubbed->expects($this->any())
            ->method('create')
            ->will($this->returnValue($placeSearchResultCreated));

        $searcher = new PlaceSearcher($factoryStubbed);
        $placeSearchRequest = new PlaceSearchRequest();
        
        $placesRetrieved =  $searcher->byRadius($placeSearchRequest);

        $this->assertInstanceOf("PlaceSearchResult", $placesRetrieved);
        $this->assertSame($placeSearchResultCreated, $placesRetrieved);
    }
}

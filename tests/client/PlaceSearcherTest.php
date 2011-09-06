<?php
require_once('../src/client/PlaceSearcher.php');
require_once('../src/client/PlaceSearchRequest.php');
require_once('../src/client/PlaceSearchResult.php');
require_once('../src/client/PlaceSearchResultFactory.php');


class PlaceSearcherTest extends PHPUnit_Framework_TestCase{

    public function testRetrieveByRadius(){
        $placeSearchResultCreated = new PlaceSearchResult();

        $factoryStubbed = $this->getMock("PlaceSearchResultFactory");
        $factoryStubbed->expects($this->any())
            ->method('create')
            ->will($this->returnValue($placeSearchResultCreated));

        $searcher = new PlaceSearcher($factoryStubbed);
        $placeSearchRequest = new PlaceSearchRequest();

        $placeSearchRequest->latitide = -23.45;
        $placeSearchRequest->longitude = -43.56;
        $placeSearchRequest->radius = 0.5;

        $placesRetrieved =  $searcher->byRadius($placeSearchRequest);

        $this->assertInstanceOf("PlaceSearchResult", $placesRetrieved);
        $this->assertSame($placeSearchResultCreated, $placesRetrieved);
    }
}

<?php
include_once('../Autoloader.php');

class PlaceSearcherTest extends PHPUnit_Framework_TestCase{

    private $clientMocked;
    private $placeSearcher;
    private $radius = 0.5;
    private $latitude = -23.45;
    private $longitude = -46.78;

    public function setUp() {
        $baseUri = "base-uri";

        $this->clientMocked = $this->getMockBuilder('HttpClient')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->clientMocked->expects($this->any())
                           ->method('request')
                           ->will($this->returnValue('places-retrieved'));

        $this->placeSearcher = new PlaceSearcher($this->clientMocked);
    }

    public function testSearchByRadius(){
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                  $this->latitude,
                                  $this->longitude);

        $this->assertEquals('places-retrieved', $placesRetrieved);
    }

    public function testSearchByRadiusWithTerm(){
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                  $this->latitude,
                                  $this->longitude,
                                  'pizza');

        $this->assertEquals('places-retrieved', $placesRetrieved);
    }

    public function testSearchByRadiusWithCategory(){
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                  $this->latitude,
                                  $this->longitude,
                                  '',
                                  'category');

        $this->assertEquals('places-retrieved', $placesRetrieved);
    }

    public function testSearchByRadiusWithStartIndex(){
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                  $this->latitude,
                                  $this->longitude,
                                  '',
                                  '',
                                  10);

        $this->assertEquals('places-retrieved', $placesRetrieved);
    }

    public function testThatSearchByRadiusCallPlaceRequest() {
        $expected = '/places/byradius?radius=0.50&latitude=-23.45&longitude=-46.78';

        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo($expected));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude);
    }

    public function testThatSearchByRadiusWithTermCallPlaceRequestWithTerm() {
        $expected = '/places/byradius?radius=0.50&latitude=-23.45&longitude=-46.78&term=pizza';

        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo($expected));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude,
                                       'pizza');
    }

    public function testThatSearchByRadiusWithCategoryCallPlaceRequestWithCategory() {
        $expected = '/places/byradius?radius=0.50&latitude=-23.45&longitude=-46.78&category=pizzaria';

        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo($expected));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude,
                                       '',
                                       'pizzaria');
    }

    public function testThatSearchByRadiusWithStartIndexCallPlaceRequestWithStartIndex() {
        $expected = '/places/byradius?radius=0.50&latitude=-23.45&longitude=-46.78&start=10';

        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo($expected));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude,
                                       '',
                                       '',
                                       10);
    }


}

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
        $placesRetrieved = $this->placeSearcher->byRadius(0.5,
                                  $this->latitude,
                                  $this->longitude);

        $this->assertEquals('places-retrieved', $placesRetrieved);
    }


    public function testThatSearchByRadiusCallRequestWithRadius() {
        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo('/places/byradius?radius=0.50&latitude=-23.45&longitude=-46.78'));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude);
    }
}

<?php
include_once('../Autoloader.php');

class PlaceSearcherTest extends PHPUnit_Framework_TestCase
{

    private $clientMocked;
    private $uriBuilderMocked;
    private $placeSearcher;
    private $radius = 0.5;
    private $latitude = -23.45;
    private $longitude = -46.78;
    private $baseUri = "base-uri";
    private $queryBuilt = 'query-built';
    private $placesRetrieved;
    private $places = '<places>
                            <place>
                                <id>1</id>
                                <name>first-place</name>
                            </place>
                            <place>
                                <id>2</id>
                                <name>second-place</name>
                            </place>
                        </places>';
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


    public function setUp()
    {
        $this->unserializer = &new XML_Unserializer($this->options);

        $this->clientMocked = $this->getMockBuilder('HttpClientWrapper')
                ->disableOriginalConstructor()
                ->getMock();

        $this->clientMocked->expects($this->any())
                ->method('request')
                ->will($this->returnValue($this->places));
        $this->placesRetrieved = $this->unserializer->unserialize($this->places);

        $this->uriBuilderMocked = $this->getMock('UriBuilder');
        $this->uriBuilderMocked->expects($this->any())
                ->method('build')
                ->will($this->returnValue($this->queryBuilt));


        $this->placeSearcher = new PlaceSearcher($this->clientMocked,
            $this->uriBuilderMocked);
    }

    public function testSearchByRadius()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                                          $this->latitude,
                                                          $this->longitude);

        $this->assertEquals($this->placesRetrieved, $placesRetrieved);
    }

    public function testSearchByRadiusWithTerm()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                                          $this->latitude,
                                                          $this->longitude,
                                                          'pizza');

        $this->assertEquals($this->placesRetrieved, $placesRetrieved);
    }

    public function testThatSearchByUri()
    {
        $placesRetrieved = $this->placeSearcher->byUri($this->baseUri);

        $this->assertEquals($this->placesRetrieved, $placesRetrieved);
    }

    public function testSearchByRadiusWithCategory()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                                          $this->latitude,
                                                          $this->longitude,
                                                          null,
                                                          0);

        $this->assertEquals($this->placesRetrieved, $placesRetrieved);
    }

    public function testSearchByRadiusWithStartIndex()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
                                                          $this->latitude,
                                                          $this->longitude,
                                                          null,
                                                          null,
                                                          10);

        $this->assertEquals($this->placesRetrieved, $placesRetrieved);
    }

    public function testThatSearchByRadiusCallPlaceRequest()
    {
        $this->clientMocked->expects($this->once())
                ->method('request')
                ->with($this->equalTo($this->queryBuilt));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude);
    }

    public function testThatSearchByRadiusWithTermCallPlaceRequestWithTerm()
    {
        $this->clientMocked->expects($this->once())
                ->method('request')
                ->with($this->equalTo($this->queryBuilt));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude,
                                       'pizza');
    }

    public function testThatSearchByRadiusWithCategoryCallPlaceRequestWithCategory()
    {
        $this->clientMocked->expects($this->once())
                ->method('request')
                ->with($this->equalTo($this->queryBuilt));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude,
                                       null,
                                       0);
    }

    public function testThatSearchByRadiusWithStartIndexCallPlaceRequestWithStartIndex()
    {
        $this->clientMocked->expects($this->once())
                ->method('request')
                ->with($this->equalTo($this->queryBuilt));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude,
                                       null,
                                       null,
                                       10);
    }

    public function testThatSearchByRadiusSetBaseQuery()
    {
        $this->uriBuilderMocked->expects($this->once())
                ->method('withBase')
                ->with($this->equalTo('/places/byradius'));

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude);
    }

    public function testThatSearchByRadiusAddsRequiredParameters()
    {
        $this->uriBuilderMocked->expects($this->exactly(3))
                ->method('withParameter');


        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude);
    }

    public function testThatSearchByRadiusCallsBuildQuery()
    {
        $this->uriBuilderMocked->expects($this->once())
                ->method('build');

        $this->placeSearcher->byRadius($this->radius,
                                       $this->latitude,
                                       $this->longitude);
    }

    public function testThatSearchByUriCallPlaceRequest()
    {
        $this->clientMocked->expects($this->once())
                ->method('request')
                ->with($this->equalTo($this->baseUri));

        $this->placeSearcher->byUri($this->baseUri);
    }
}

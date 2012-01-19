<?php
include_once('../Autoloader.php');

class PlaceSearcherTest extends PHPUnit_Framework_TestCase
{
    private $clientMocked;
    private $uriBuilderMocked;
    private $placesConverterMocked;
    private $placeSearcher;
    private $radius = 0.5;
    private $latitude = -23.45;
    private $longitude = -46.78;
    private $term = "lalapopo";
    private $category = 42;
    private $state = "SP";
    private $city = "São Paulo";
    private $baseUri = "base-uri";
    private $queryBuilt = 'query-built';
    private $placeResult;
    private $places = "places-retrieved";

    public function setUp()
    {
        $this->clientMocked = $this->getMockBuilder('HttpClientWrapper')
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMocked->expects($this->any())
            ->method('request')
            ->will($this->returnValue($this->places));

        $this->uriBuilderMocked = $this->getMock('UriBuilder');
        $this->uriBuilderMocked->expects($this->any())
            ->method('build')
            ->will($this->returnValue($this->queryBuilt));

        $this->placeResult = new PlaceResult();
        $this->placesConverterMocked = $this->getMock('PlacesConverter');
        $this->placesConverterMocked->expects($this->any())
            ->method('toPlaceResult')
            ->will($this->returnValue($this->placeResult));


        $this->placeSearcher = new PlaceSearcher($this->clientMocked,
            $this->uriBuilderMocked, $this->placesConverterMocked);
    }

    public function testSearchByRadius()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
            $this->latitude,
            $this->longitude);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByRadiusWithTerm()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
            $this->latitude,
            $this->longitude,
            'pizza');

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByRadiusWithTermAndCategory()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
            $this->latitude,
            $this->longitude,
            $this->term,
            $this->category);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByRadiusWithCategory()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
            $this->latitude,
            $this->longitude,
            null,
            0);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByRadiusWithStartIndex()
    {
        $placesRetrieved = $this->placeSearcher->byRadius($this->radius,
            $this->latitude,
            $this->longitude,
            null,
            null,
            10);

        $this->assertSame($this->placeResult, $placesRetrieved);
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

    public function testSearchByTerm()
    {
        $placesRetrieved = $this->placeSearcher->byTerm($this->term);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByTermFilteredByState()
    {
        $placesRetrieved = $this->placeSearcher->byTerm($this->term,
            $this->state);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByTermFilteredByStateAndCity()
    {
        $placesRetrieved = $this->placeSearcher->byTerm($this->term,
            $this->state,
            $this->city);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByTermWithStartIndex()
    {
        $placesRetrieved = $this->placeSearcher->byTerm($this->term,
            null,
            null,
            10);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testThatSearchByTermCallPlaceRequest()
    {
        $this->clientMocked->expects($this->once())
            ->method('request')
            ->with($this->equalTo($this->queryBuilt));

        $this->placeSearcher->byTerm($this->term);
    }

    public function testThatSearchByTermSetBaseQuery()
    {
        $this->uriBuilderMocked->expects($this->once())
            ->method('withBase')
            ->with($this->equalTo('/places/byterm'));

        $this->placeSearcher->byTerm($this->term);
    }

    public function testThatSearchByTermAddsRequiredParameters()
    {
        $this->uriBuilderMocked->expects($this->once())
            ->method('withParameter');


        $this->placeSearcher->byTerm($this->term);
    }

    public function testThatSearchByTermCallsBuildQuery()
    {
        $this->uriBuilderMocked->expects($this->once())
            ->method('build');

        $this->placeSearcher->byTerm($this->term);
    }

    public function testSearchByCategory()
    {
        $placesRetrieved = $this->placeSearcher->byCategory($this->category,
            $this->state,
            $this->city);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByCategoryFilteredByState()
    {
        $placesRetrieved = $this->placeSearcher->byCategory($this->category,
            $this->state);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByCategoryFilteredByStateAndCity()
    {
        $placesRetrieved = $this->placeSearcher->byCategory($this->category,
            $this->state,
            $this->city);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testSearchByCategoryWithStartIndex()
    {
        $placesRetrieved = $this->placeSearcher->byCategory($this->category,
            null,
            null,
            10);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testThatSearchByCategoryCallPlaceRequest()
    {
        $this->clientMocked->expects($this->once())
            ->method('request')
            ->with($this->equalTo($this->queryBuilt));

        $this->placeSearcher->byCategory($this->category);
    }

    public function testThatSearchByCategorySetBaseQuery()
    {
        $this->uriBuilderMocked->expects($this->once())
            ->method('withBase')
            ->with($this->equalTo('/places/bycategory'));

        $this->placeSearcher->byCategory($this->category);
    }

    public function testThatSearchByCategoryAddsRequiredParameters()
    {
        $this->uriBuilderMocked->expects($this->once())
            ->method('withParameter');

        $this->placeSearcher->byCategory($this->category);
    }

    public function testThatSearchByCategoryCallsBuildQuery()
    {
        $this->uriBuilderMocked->expects($this->once())
            ->method('build');

        $this->placeSearcher->byCategory($this->category);
    }

    public function testThatSearchByUri()
    {
        $placesRetrieved = $this->placeSearcher->byUri($this->baseUri);

        $this->assertSame($this->placeResult, $placesRetrieved);
    }

    public function testThatSearchByUriCallPlaceRequest()
    {
        $this->clientMocked->expects($this->once())
            ->method('request')
            ->with($this->equalTo($this->baseUri));

        $this->placeSearcher->byUri($this->baseUri);
    }
}

<?php

class PlacesConverterTest extends PHPUnit_Framework_TestCase
{
    private $xml;
    private $placesConverter;
    private $placesConverted;

    public function setUp()
    {
        $this->xml = file_get_contents("../placesResponse.xml");
        $this->placesConverted = new PlaceResult();
        $this->placesConverter = new PlacesConverter();
    }

    public function testThatPlaceWasConverted()
    {
        $placesConverted = $this->placesConverter->toPlaceResult($this->xml);

        $this->assertInstanceOf("PlaceResult", $placesConverted);
        $this->assertEquals(2, count($placesConverted->places));
        $this->assertEquals("60", $placesConverted->startIndex);
        $this->assertEquals("916", $placesConverted->totalFound);
        $this->assertEquals("/places/byradius/?radius=1000&latitude=-23.235&longitude=-46.2352&term=banco&category=44&start=30",
                            $placesConverted->previous);
        $this->assertEquals("/places/byradius/?radius=1000&latitude=-23.235&longitude=-46.2352&term=banco&category=44&start=90", $placesConverted->next);
    }
}

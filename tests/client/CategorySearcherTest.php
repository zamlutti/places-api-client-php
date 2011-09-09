<?php

class CategorySearcherTest extends PHPUnit_Framework_TestCase
{
    private $clientMocked;
    private $categoriesSearcher;

    public function setUp() {
        $this->clientMocked = $this->getMockBuilder('HttpClientWrapper')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->clientMocked->expects($this->any())
                           ->method('request')
                           ->will($this->returnValue('categories-retrieved'));

        $this->categoriesSearcher = new CategorySearcher($this->clientMocked);
    }


    public function testThatGetAllCategoriesRetrieveCategories() {
        $categoriesRetrieved = $this->categoriesSearcher->getAll();
        $this->assertEquals('categories-retrieved', $categoriesRetrieved);
    }

    public function testThatGetAllCategoriesCallRequestWithCategories() {
        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo('/categories'));

        $this->categoriesSearcher->getAll();
    }
}
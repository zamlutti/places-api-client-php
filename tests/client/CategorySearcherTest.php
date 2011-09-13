<?php

class CategorySearcherTest extends PHPUnit_Framework_TestCase
{
    private $clientMocked;
    private $categoriesSearcher;
    private $categoriesRetrieved;
    private $categories = '<categories>
                                <category>
                                    <id>1</id>
                                    <name>first-category</name>
                                </category>
                                <category>
                                    <id>2</id>
                                    <name>second-category</name>
                                </category>
                            </categories>';
    public function setUp()
    {
        $this->clientMocked = $this->getMockBuilder('HttpClientWrapper')
                ->disableOriginalConstructor()
                ->getMock();

        $this->clientMocked->expects($this->any())
                ->method('request')
                ->will($this->returnValue($this->categories));
        $this->categoriesRetrieved = simplexml_load_string($this->categories);
        $this->categoriesSearcher = new CategorySearcher($this->clientMocked);
    }


    public function testThatGetAllCategoriesRetrieveCategories()
    {
        $categoriesRetrieved = $this->categoriesSearcher->getAll();
        $this->assertEquals($this->categoriesRetrieved, $categoriesRetrieved);
    }

    public function testThatGetAllCategoriesCallRequestWithCategories()
    {
        $this->clientMocked->expects($this->once())
                ->method('request')
                ->with($this->equalTo('/categories'));

        $this->categoriesSearcher->getAll();
    }
}
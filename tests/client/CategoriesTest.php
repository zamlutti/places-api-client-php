<?php

class CategoriesTest extends PHPUnit_Framework_TestCase 
{
    private $clientMocked;
    private $categories;

    public function setUp() {
        $baseUri = "base-uri";
        
        $this->clientMocked = $this->getMockBuilder('HttpClient')
                                   ->disableOriginalConstructor()
                                   ->getMock();
                                        
        $this->clientMocked->expects($this->any())
                           ->method('request')
                           ->will($this->returnValue('categories-retrieved'));
 
        $this->categories = new Categories($this->clientMocked);
    }

    public function tearDown() {
    }
    
    public function testThatGetAllCategoriesRetrieveCategories() {
        $categoriesRetrieved = $this->categories->getAll();
        $this->assertEquals('categories-retrieved', $categoriesRetrieved);
    }
    
    public function testThatGetAllCategoriesCallRequestWithCategories() {        
        $this->clientMocked->expects($this->once())
                       ->method('request')
                       ->with($this->equalTo('/categories'));
        
        $this->categories->getAll();        
    }
}
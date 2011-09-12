<?php

class UriBuilderTest extends PHPUnit_Framework_TestCase
{
    private $uriBuilder;

    public function setUp()
    {
        $this->uriBuilder = new UriBuilder();

    }

    public function testBuildQuery()
    {
        $queryBuilt = $this->uriBuilder
                ->withBase('base-uri')
                ->build();

        $this->assertEquals('base-uri', $queryBuilt);
    }

    public function testBuildQueryWithOneParameter()
    {
        $expected = 'base-uri?first-parameter=first-value';
        $queryBuilt = $this->uriBuilder
                ->withBase('base-uri')
                ->withParameter('first-parameter', 'first-value')
                ->build();

        $this->assertEquals($expected, $queryBuilt);
    }

    public function testBuildQueryWithTwoParameteres()
    {
        $expected = 'base-uri?first-parameter=first-value&second-parameter=second-value';
        $queryBuilt = $this->uriBuilder
                ->withBase('base-uri')
                ->withParameter('first-parameter', 'first-value')
                ->withParameter('second-parameter', 'second-value')
                ->build();

        $this->assertEquals($expected, $queryBuilt);
    }


}
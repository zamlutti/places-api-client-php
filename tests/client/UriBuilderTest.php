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
        $this->uriBuilder->setBase('base-uri');
        $queryBuilt = $this->uriBuilder->buildQuery();

        $this->assertEquals('base-uri', $queryBuilt);
    }

    public function testBuildQueryWithOneParameter()
    {
        $this->uriBuilder->setBase('base-uri');
        $this->uriBuilder->addParameter('first-parameter', 'first-value');
        $expected = 'base-uri?first-parameter=first-value';

        $this->assertEquals($expected, $this->uriBuilder->buildQuery());
    }

    public function testBuildQueryWithTwoParameteres()
    {
        $this->uriBuilder->setBase('base-uri');
        $this->uriBuilder->addParameter('first-parameter', 'first-value');
        $this->uriBuilder->addParameter('second-parameter', 'second-value');
        $expected = 'base-uri?first-parameter=first-value&second-parameter=second-value';

        $this->assertEquals($expected, $this->uriBuilder->buildQuery());
    }


}
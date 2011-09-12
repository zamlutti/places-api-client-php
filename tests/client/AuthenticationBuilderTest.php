<?php

class AuthenticationBuilderTest extends PHPUnit_Framework_TestCase
{
    private $authenticationBuilder;
    private $licenseLogin = 'license-login';
    private $licenseKey = 'license-key';
    private $hashContent = 'GET\ndate\nuri\nlicense-login';
    private $signature = 'generated-signature';
    private $base = 'license-login:generated-signature';

    public function setUp()
    {
        $this->authenticationBuilder = new AuthenticationBuilder($this->licenseLogin, $this->licenseKey);
    }

    public function testThatHashContentWasGenerated()
    {
        $hash = $this->authenticationBuilder->generateHash('date', 'uri');
        $this->assertEquals($this->hashContent, $hash);
    }

    public function testThatSignatureWasGenerated()
    {
        $signature = $this->authenticationBuilder->generateSignature($this->hashContent);
        $this->assertNotEmpty($signature);
    }

    public function testThatBaseWasGenerated(){
        $base = $this->authenticationBuilder->generateBase($this->signature);
        $this->assertEquals($this->base, $base);
    }

    public function testThatAuthenticationStringWasBuilt()
    {
        $authenticationString = $this->authenticationBuilder->build($this->base);
        $this->assertNotEmpty($authenticationString);
    }
}
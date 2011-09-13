<?php

class AuthenticationBuilderTest extends PHPUnit_Framework_TestCase
{
    private $authenticationBuilder;
    private $licenseLogin = 'license-login';
    private $licenseKey = 'license-key';
    private $hashContent = 'GET\ndate\nuri\nlicense-login';
    private $base = 'license-login:';

    public function setUp()
    {
        $this->authenticationBuilder = new AuthenticationBuilder($this->licenseLogin, $this->licenseKey);
    }

    public function testThatAnEmptyAuthenticationStringWasBuilt()
    {
        $authenticationString = $this->authenticationBuilder->build();
        $this->assertEmpty($authenticationString);
    }

    public function testThatAuthenticationStringWasBuiltWithHashContent()
    {
        $hashContentEncoded = $this->authenticationBuilder
                ->withHashContent('date', 'uri')
                ->build();
        $hash = base64_decode($hashContentEncoded);
        $this->assertEquals($this->hashContent, $hash);
    }

    public function testThatSignatureWasGenerated()
    {
        $signatureEncoded = $this->authenticationBuilder
                ->withSignature()
                ->build();
        $signature = base64_decode($signatureEncoded);
        $this->assertNotEmpty($signature);
    }

    public function testThatBaseWasGenerated()
    {
        $baseEncoded = $this->authenticationBuilder->withBase()->build();
        $base = base64_decode($baseEncoded);
        $this->assertEquals($this->base, $base);
    }


}
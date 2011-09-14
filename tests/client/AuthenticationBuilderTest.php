<?php

class AuthenticationBuilderTest extends PHPUnit_Framework_TestCase
{
    private $authenticationBuilder;
    private $licenseLogin = 'license-login';
    private $licenseKey = 'license-key';

    private $hashContent = "GET\ndate\nuri\nlicense-login";
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
        $this->assertEquals("0f13184cf7e54783f3acbe42d1c55ffe5b70f5ee", $signature);
    }

    public function testThatBaseWasGenerated()
    {
        $baseEncoded = $this->authenticationBuilder->withBase()->build();
        $base = base64_decode($baseEncoded);
        $this->assertEquals($this->base, $base);
    }

    public function testThatAuthorizationStringWasBuilt()
    {
        $authorization = $this->authenticationBuilder
                ->withHashContent("date", "uri")
                ->withSignature()
                ->withBase()
                ->build();
        $this->assertEquals("license-login:5617994a81c8f3993bafca3d407d9bd97e8577d5",
                            base64_decode($authorization));

    }

}
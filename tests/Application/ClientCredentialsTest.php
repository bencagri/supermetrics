<?php

namespace Tests\Application;

use SuperMetrics\Application\Client\Credentials;
use Tests\TestCase;

class ClientCredentialsTest extends TestCase
{
    public function testGivenCredentials()
    {
        $credentials = new Credentials("some client id", "some client email", "client name");

        $this->assertSame("some client id", $credentials->getClientId());
        $this->assertSame("some client email", $credentials->getClientEmail());
        $this->assertSame("client name", $credentials->getClientName());
    }
}

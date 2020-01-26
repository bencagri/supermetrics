<?php

namespace Tests\Application;

use stdClass;
use SuperMetrics\Application\Shared\JsonResponse;
use Tests\TestCase;

class JsonResponseTest extends TestCase
{
    public function testStringGivenResponse()
    {
        $given = "howdy dude?";

        $response = new JsonResponse($given);

        $this->assertJsonStringEqualsJsonString('["howdy dude?"]', $response->getBody()->getContents());
    }

    public function testArrayGivenResponse()
    {
        $given = ["foo" => "bar"];

        $response = new JsonResponse($given);
        $this->assertJson($response->getBody()->getContents());
    }

    public function testObjectGivenResponse()
    {
        $given = new stdClass();
        $given->foo = 'bar';

        $response = new JsonResponse($given);
        $this->assertJson($response->getBody()->getContents());
    }
}

<?php

namespace Tests\Functional\QEdu\QEduHub\GimmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    const SUCCESS_URL = '/gimme/092c8bfa69/pkg/js/landingideb.js';
    const FAIL_URL    = '/gimme/092c8bfa69/pkg/js/non-exist.js';

    public function testGetExistentAsset()
    {
        $client = static::createClient();
        $client->request('GET', self::SUCCESS_URL);

        $response = $client->getResponse();

        $statusCode = $response->getStatusCode();
        $content    = $response->getContent();

        $statusCodeExpected = Response::HTTP_OK;
        $contentExpected    = 'Meritt/QEdu/UI/IdebLanding/Assets/js/view/IdebInStates';

        $this->assertEquals($statusCodeExpected, $statusCode);
        $this->assertContains($contentExpected, $content);
    }

    public function testGetNonExistAsset()
    {
        $client = static::createClient();
        $client->request('GET', self::FAIL_URL);

        $response = $client->getResponse();

        $statusCode = $response->getStatusCode();

        $statusCodeExpected = Response::HTTP_NOT_FOUND;

        $this->assertEquals($statusCodeExpected, $statusCode);
    }
}

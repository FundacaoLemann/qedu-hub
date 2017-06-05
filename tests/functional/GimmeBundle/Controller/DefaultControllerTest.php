<?php

namespace Tests\Functional\QEdu\QEduHub\GimmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    const FAIL_URL    = '/gimme/092c8bfa69/pkg/js/non-exist.js';

    /**
     * @dataProvider assetProvider
     */
    public function testGetExistentJavascript(
        $successUrl,
        $contentTypeExpected,
        $contentExpected
    ) {
        $client = static::createClient();
        $client->request('GET', $successUrl);

        $response = $client->getResponse();

        $statusCode  = $response->getStatusCode();
        $content     = $response->getContent();
        $contentType = $response->headers->get('Content-Type');

        $statusCodeExpected  = Response::HTTP_OK;

        $this->assertEquals($statusCodeExpected, $statusCode);
        $this->assertEquals($contentTypeExpected, $contentType);
        $this->assertContains($contentExpected, $content);
    }

    public function assetProvider()
    {
        return [
            'javascript' => [
                'url'     => '/gimme/092c8bfa69/pkg/js/landingideb.js',
                'type'    => 'application/javascript',
                'content' => 'Meritt/QEdu/UI/IdebLanding/Assets/js/view/IdebInStates',
            ],
            'css' => [
                'url'     => '/gimme/c17a152ffb/pkg/css/provabrasil/banner.css',
                'type'    => 'application/css',
                'content' => 'meumunicipio-banner-ct',
            ],
        ];
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

<?php

namespace QEdu\QEduHub\GimmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/{hash}/pkg/js/{asset}",
     *     name="gimme_path",
     *     requirements={
     *         "hash": ".*",
     *         "asset": "landingideb.js|Header.js"
     *     }
     * )
     */
    public function indexAction($asset)
    {
        $file = $this->locateResource($asset);

        if (file_exists($file) === false) {
            throw $this->createNotFoundException('Asset not found');
        }

        return $this->createJavascriptResponse($file);
    }

    private function locateResource($fileName)
    {
        $resource = $this->container
            ->get('kernel')
            ->locateResource('@GimmeBundle/Resources/assets/javascript/dist/');

        return $resource . $fileName;
    }

    private function createJavascriptResponse($file)
    {
        $content = file_get_contents($file);

        $response = new Response($content);
        $response->headers->set('Content-Type','text/javascript');

        return $response;
    }
}

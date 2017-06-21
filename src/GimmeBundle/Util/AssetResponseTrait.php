<?php

namespace GimmeBundle\Util;

use Symfony\Component\HttpFoundation\Response;

trait AssetResponseTrait {

    private function createAssetResponse($file)
    {
        $fileContent = file_get_contents($file);

        $fileInfo = new \SplFileInfo($file);

        switch ($fileInfo->getExtension()) {
            case 'css':
                $contentType = 'application/css';
                break;
            case 'js':
                $contentType = 'application/javascript';
                break;
            default:
                $contentType = 'text/html';
                break;
        }

        $response = new Response($fileContent);
        $response->headers->set('Content-Type', $contentType);

        return $response;
    }
}

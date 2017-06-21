<?php

namespace QEdu\QEduHub\GimmeBundle\Controller;

use QEdu\QEduHub\GimmeBundle\Util\AssetResponseTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Config\FileLocator;

class DefaultController extends Controller
{
    use AssetResponseTrait;

    private $fileLocator;

    public function __construct(FileLocator $fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }

    /**
     * @Route("/{hash}/pkg/{prefix}/{fileName}",
     *     name="gimme_path",
     *     requirements={
     *         "hash": ".*",
     *         "prefix": ".*",
     *         "fileName": ".*"
     *     }
     * )
     */
    public function indexAction($fileName)
    {
        try {
            $file = $this->fileLocator->locate($fileName);

            return $this->createAssetResponse($file);
        } catch (\InvalidArgumentException $exception) {
            throw $this->createNotFoundException('File not found', $exception);
        }
    }
}

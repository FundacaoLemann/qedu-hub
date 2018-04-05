<?php

namespace AppBundle\Controller;

use AppBundle\Repository\EbookRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EbookController extends Controller
{
    private $ebookRepository;

    public function __construct(EbookRepository $ebookRepository)
    {
        $this->ebookRepository = $ebookRepository;
    }

    /**
     * @Route("/ebook/{ebookSlug}",
     *     name="ebook",
     *     requirements={
     *         "ebookSlug": ".*"
     *     }
     * )
     */
    public function ebookAction($ebookSlug)
    {
        $ebook = $this->ebookRepository->findBySlug($ebookSlug);

        if (is_null($ebook)) {
            throw new NotFoundHttpException('Ebook not found');
        }

        return $this->render('ebook/index.html.twig', [
            'ebook' => $ebook,
        ]);
    }
}

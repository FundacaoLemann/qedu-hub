<?php

namespace AppBundle\Controller;

use AppBundle\Census\CensusPage;
use AppBundle\Exception\SchoolNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CensusController extends Controller
{
    private $censusPage;

    public function __construct(CensusPage $censusPage)
    {
        $this->censusPage = $censusPage;
    }

    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/{section}",
     *     name="census_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*",
     *         "section": "(sobre|censo-escolar)"
     *     }
     * )
     */
    public function schoolAction(int $schoolId)
    {
        try {
            $this->censusPage->build($schoolId);

            return $this->render('census/school.html.twig', [
                'header' => $this->censusPage->getHeader(),
                'content' => $this->censusPage->getContent(),
                'school' => $this->censusPage->getSchool(),
            ]);
        } catch (SchoolNotFoundException $exception) {
            throw new NotFoundHttpException($exception);
        }
    }
}

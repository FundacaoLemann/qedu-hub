<?php

namespace AppBundle\Controller;

use AppBundle\Census\CensusPage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CensusController extends Controller
{
    private $censusPage;

    public function __construct(CensusPage $censusPage)
    {
        $this->censusPage = $censusPage;
    }

    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/sobre-dev",
     *     name="census_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function schoolAction(int $schoolId)
    {
        $this->censusPage->build($schoolId);

        return $this->render('census/school.html.twig', [
            'header' => $this->censusPage->getHeader(),
            'content' => $this->censusPage->getContent(),
            'school' => $this->censusPage->getSchool(),
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CensusController extends Controller
{
    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/sobre-dev",
     *     name="census_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function schoolAction()
    {
        return $this->render('census/school.html.twig');
    }
}

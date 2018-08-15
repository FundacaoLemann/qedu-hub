<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EnemController extends Controller
{
    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/enem-dev",
     *     name="enem_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function schoolAction()
    {
        return $this->render('enem/school.html.twig');
    }
}

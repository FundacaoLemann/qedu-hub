<?php

namespace AppBundle\Controller;

use AppBundle\Enem\EnemPage;
use AppBundle\Exception\SchoolNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EnemController extends Controller
{
    private $enemPage;

    public function __construct(EnemPage $enemPage)
    {
        $this->enemPage = $enemPage;
    }

    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/enem-dev",
     *     name="enem_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function schoolAction(int $schoolId)
    {
        try {
            $this->enemPage->build($schoolId);

            return $this->render('enem/school.html.twig', [
                'header' => $this->enemPage->getHeader(),
                'school' => $this->enemPage->getSchool(),
                'content' => $this->enemPage->getContent(),
            ]);
        } catch (SchoolNotFoundException $exception) {
            throw new NotFoundHttpException($exception);
        }
    }
}

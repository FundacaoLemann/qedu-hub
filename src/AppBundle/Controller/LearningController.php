<?php

namespace AppBundle\Controller;

use AppBundle\Learning\LearningService;
use AppBundle\Learning\ProvaBrasilService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LearningController extends Controller
{
    private $provaBrasilService;
    private $learningService;

    public function __construct(
        ProvaBrasilService $provaBrasilService,
        LearningService $learningService
    ) {
        $this->provaBrasilService = $provaBrasilService;
        $this->learningService = $learningService;
    }

    /**
     * @Route("/brasil/aprendizado", name="learning_brazil")
     */
    public function brazilAction()
    {
        $provaBrasilEdition = $this->provaBrasilService->getLastEdition();
        $brazilLearning = $this->learningService->getBrazilLearningByEdition($provaBrasilEdition);

        return $this->render('learning/brazil.html.twig', [
            'provaBrasilEdition' => $provaBrasilEdition,
            'brazilLearning' => $brazilLearning,
        ]);
    }

    /**
     * @Route("/amp/escola/{schoolId}-{schoolSlug}/aprendizado",
     *     name="learning_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function schoolAction(int $schoolId)
    {
        $provaBrasilEdition = $this->provaBrasilService->getLastEdition();
        $schoolLearning = $this->learningService->getSchoolLearningByEdition($schoolId, $provaBrasilEdition);
        $schoolName = $this->getSchoolRepository()->find($schoolId)->getName();

        if (count($schoolLearning) === 0) {
            throw new NotFoundHttpException();
        }

        return $this->render('learning/amp/school.html.twig', [
            'schoolName' => $schoolName,
            'provaBrasilEdition' => $provaBrasilEdition,
            'schoolLearning' => $schoolLearning,
        ]);
    }

    private function getSchoolRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:School', 'waitress_entities');
    }
}

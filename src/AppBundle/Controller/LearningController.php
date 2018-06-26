<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Learning\School;
use AppBundle\Learning\LearningService;
use AppBundle\Learning\ProvaBrasilService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LearningController extends Controller
{
    private $provaBrasilLastEdition;
    private $learningService;

    public function __construct(
        ProvaBrasilService $provaBrasilService,
        LearningService $learningService
    ) {
        $this->provaBrasilLastEdition = $provaBrasilService->getLastEdition();
        $this->learningService = $learningService;
    }

    /**
     * @Route("/brasil/aprendizado", name="learning_brazil")
     */
    public function brazilAction()
    {
        $brazilLearning = $this->learningService->getBrazilLearningByEdition($this->provaBrasilLastEdition);

        return $this->render('learning/brazil.html.twig', [
            'provaBrasilEdition' => $this->provaBrasilLastEdition,
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
        $school = $this->getDoctrine()->getRepository('AppBundle:School', 'waitress_entities')->find($schoolId);

        $schoolProficiency = $this->getDoctrine()->getRepository('AppBundle:Learning\School', 'waitress_dw_prova_brasil')->findSchoolProficiencyByEdition($school, $this->provaBrasilLastEdition)[0];

        if (is_null($schoolProficiency)) {
            throw new NotFoundHttpException();
        }

        $schoolLearning = $this->learningService->getSchoolLearningByEdition($schoolProficiency, $this->provaBrasilLastEdition);

        return $this->render('learning/amp/school.html.twig', [
            'school' => $school,
            'provaBrasilEdition' => $this->provaBrasilLastEdition,
            'schoolLearning' => $schoolLearning,
        ]);
    }
}

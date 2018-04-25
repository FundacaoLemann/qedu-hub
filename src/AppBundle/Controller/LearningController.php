<?php

namespace AppBundle\Controller;

use AppBundle\Entity\School;
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
        $school = $this->findSchool($schoolId);
        $schoolLearning = $this->findSchoolLearningFromLastEdition($school);

        return $this->render('learning/amp/school.html.twig', [
            'school' => $school,
            'provaBrasilEdition' => $this->provaBrasilLastEdition,
            'schoolLearning' => $schoolLearning,
        ]);
    }

    private function findSchool(int $schoolId)
    {
        $school = $this->getSchoolRepository()->find($schoolId);

        if (is_null($school)) {
            throw new NotFoundHttpException();
        }

        return $school;
    }

    private function getSchoolRepository()
    {
        return $this->getDoctrine()->getRepository('AppBundle:School', 'waitress_entities');
    }

    private function findSchoolLearningFromLastEdition(School $school)
    {
        $schoolLearning = $this->learningService->getSchoolLearningByEdition($school, $this->provaBrasilLastEdition);

        if (count($schoolLearning) === 0) {
            throw new NotFoundHttpException();
        }

        return $schoolLearning;
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Learning\School;
use AppBundle\Exception\SchoolLearningNotFoundException;
use AppBundle\Exception\SchoolNotFoundException;
use AppBundle\Learning\LearningService;
use AppBundle\Learning\ProvaBrasilService;
use AppBundle\Learning\SchoolLearningPage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LearningController extends Controller
{
    private $provaBrasilLastEdition;
    private $learningService;
    private $schoolLearningPage;

    public function __construct(
        ProvaBrasilService $provaBrasilService,
        LearningService $learningService,
        SchoolLearningPage $schoolLearningPage
    ) {
        $this->provaBrasilLastEdition = $provaBrasilService->getLastEdition();
        $this->learningService = $learningService;
        $this->schoolLearningPage = $schoolLearningPage;
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
        try {
            $this->schoolLearningPage->build($schoolId, $this->provaBrasilLastEdition);

            return $this->render('learning/amp/school.html.twig', [
                'school' => $this->schoolLearningPage->getSchool(),
                'provaBrasilEdition' => $this->provaBrasilLastEdition,
                'schoolLearning' => $this->schoolLearningPage->getSchoolLearning(),
            ]);
        } catch (SchoolNotFoundException | SchoolLearningNotFoundException $exception) {
            throw new NotFoundHttpException($exception);
        }
    }
}

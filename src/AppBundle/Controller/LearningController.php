<?php

namespace AppBundle\Controller;

use AppBundle\Component\Header;
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
    private $header;

    public function __construct(
        ProvaBrasilService $provaBrasilService,
        LearningService $learningService,
        SchoolLearningPage $schoolLearningPage,
        Header $header
    ) {
        $this->provaBrasilLastEdition = $provaBrasilService->getLastEdition();
        $this->learningService = $learningService;
        $this->schoolLearningPage = $schoolLearningPage;
        $this->header = $header;
    }

    /**
     * @Route("/brasil/aprendizado", name="learning_brazil")
     */
    public function brazilAction()
    {
        $brazilLearning = $this->learningService->getBrazilLearningByEdition($this->provaBrasilLastEdition);

        return $this->render('learning/brazil.html.twig', [
            'provaBrasilEdition' => $this->provaBrasilLastEdition,
            'learnings' => $brazilLearning,
        ]);
    }

    /**
     * @Route("/amp/escola/{schoolId}-{schoolSlug}/aprendizado",
     *     name="learning_school_amp",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function ampSchoolAction(int $schoolId)
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

    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/aprendizado-dev",
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

            $school =  $this->schoolLearningPage->getSchool();

            $this->header->build($school);

            return $this->render('learning/school.html.twig', [
                'header' => $this->header,
                'school' => $school,
                'provaBrasilEdition' => $this->provaBrasilLastEdition,
                'learnings' => $this->schoolLearningPage->getSchoolLearning(),
            ]);
        } catch (SchoolNotFoundException | SchoolLearningNotFoundException $exception) {
            throw new NotFoundHttpException($exception);
        }
    }
}

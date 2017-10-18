<?php

namespace AppBundle\Controller;

use AppBundle\Learning\LearningService;
use AppBundle\Learning\ProvaBrasilService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Route("/brasil/aprendizado-new", name="learning_brazil")
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
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LearningController extends Controller
{
    /**
     * @Route("/brasil/aprendizado-new", name="learning_brazil")
     */
    public function brazilAction()
    {
        return $this->render('learning/brazil.html.twig');
    }
}

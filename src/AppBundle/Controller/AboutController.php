<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
    /**
     * @Route("/sobre", name="about")
     */
    public function indexAction()
    {
        return $this->render('about/index.html.twig');
    }
}

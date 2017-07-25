<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AboutController extends Controller
{
    /**
     * @Route("/sobre", name="about")
     */
    public function indexAction(Request $request)
    {
        return $this->render('about/index.html.twig');
    }
}

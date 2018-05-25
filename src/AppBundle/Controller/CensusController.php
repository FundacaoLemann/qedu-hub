<?php

namespace AppBundle\Controller;

use AppBundle\Util\Breadcrumb;
use AppBundle\Util\MenuBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CensusController extends Controller
{
    private $menuBuilder;

    public function __construct(MenuBuilder $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;
    }

    /**
     * @Route("/escola/{schoolId}-{schoolSlug}/sobre-dev",
     *     name="census_school",
     *     requirements={
     *         "schoolId": "\d+",
     *         "schoolSlug": ".*"
     *     }
     * )
     */
    public function schoolAction(Request $request, int $schoolId)
    {
        $school = $this->getDoctrine()
            ->getRepository('AppBundle:School', 'waitress_entities')
            ->find($schoolId);

        $breadcrumb = new Breadcrumb($school, $request);
        $menuItems = $this->menuBuilder->buildItems($school, $request);

        return $this->render('census/school.html.twig', [
            'school' => $school,
            'breadcrumb' => $breadcrumb,
            'menuItems' => $menuItems,
        ]);
    }
}

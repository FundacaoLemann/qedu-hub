<?php

namespace AppBundle\Controller;

use AppBundle\Census\CensusFilter;
use AppBundle\Util\Breadcrumb;
use AppBundle\Util\MenuBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CensusController extends Controller
{
    private $breadcrumb;
    private $menuBuilder;
    private $censusFilter;

    public function __construct(Breadcrumb $breadcrumb, MenuBuilder $menuBuilder, CensusFilter $censusFilter)
    {
        $this->breadcrumb = $breadcrumb;
        $this->menuBuilder = $menuBuilder;
        $this->censusFilter = $censusFilter;
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

        $breadcrumbItems = $this->breadcrumb->buildItems($school, $request);
        $menuItems = $this->menuBuilder->buildItems($school, $request);

        return $this->render('census/school.html.twig', [
            'school' => $school,
            'breadcrumbItems' => $breadcrumbItems,
            'menuItems' => $menuItems,
            'filter' => $this->censusFilter,
        ]);
    }
}

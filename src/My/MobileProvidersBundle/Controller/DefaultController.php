<?php

namespace My\MobileProvidersBundle\Controller;
use APY\DataGridBundle\Grid\Source\Vector;
use Doctrine\ODM\MongoDB\DocumentManager;
use My\MobileProvidersBundle\Document\Tariff;
use My\MobileProvidersBundle\Form\UsagePatternType;
use My\MobileProvidersBundle\TariffCalc\CostModel;
use My\MobileProvidersBundle\TariffCalc\CostModelManager;
use My\MobileProvidersBundle\TariffCalc\UsagePattern;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param Form $form
     * @param CostModelManager $costs
     * @internal param UsagePattern $usagePattern
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderPage($form = null, $costs = null) {
        return $this->render(
            'MyMobileProvidersBundle:Default:index.html.twig',
            array(
                'form' => $form->createView(),
                'costs' => $costs
            )
        );
    }

//    /**
//     * @Route("/")
//     * @Method("GET")
//     * @Template("MyMobileProvidersBundle:Default:grid.html.twig")
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function indexAction()
//    {
//        $usagePattern = new UsagePattern();
//        $form = $this->createForm(new UsagePatternType(), $usagePattern);
//        $grid = $this->get('grid');
//        return $grid->getGridResponse(
//            "MyMobileProvidersBundle:Default:grid.html.twig",
//            [
//                'form' => $form->createView(),
//                'minTariff' => null
//            ]
//        );
//    }

    /**
     * @Route("/")
     * @Template("MyMobileProvidersBundle:Default:grid.html.twig")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request) {
        $usagePattern = new UsagePattern();
        $form = $this->createForm(new UsagePatternType(), $usagePattern);
        $form->handleRequest($request);

        $costs = CostModelManager::calculateCosts(
            $usagePattern,
            $this->get('doctrine_mongodb')->getManager()->getRepository('MyMobileProvidersBundle:Tariff')->findAll()
        );

        $grid = $this->get('grid');
        $grid->setSource($costs->getCostsVector());
        $grid->setLimits([200]);

        return $grid->getGridResponse([
            'form' => $form->createView(),
            'minTariff' => $costs->getMinTariff()
        ]);
    }
}

<?php

namespace Da\StatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Da\StatBundle\Exception\SecurityException;
use Da\StatBundle\Exception\NoDataException;

/**
 * @Route("/stat/{_locale}")
 */
class MainController extends Controller
{
    /**
     * Charge la description du rendu graphique d'une statistique 
     * en ajax.
     *
     * @Route("/buildChart/{statId}", defaults={"_format"="json"})
     * @Template()
     */
    public function buildChartAction($statId)
    {
        try
        {
            $criteria = $this->get('request')->query->get('criteria', array());
            $chart = $this->get('da.stat.handler')->buildChart($statId, $criteria);
        }
        catch (SecurityException $e)
        {
            throw new AccessDeniedException($e->getMessage());
        }
        catch (NoDataException $e)
        {
            throw new NotFoundHttpException('No data has been found for the chart');
        }

        return array('chart' => $chart);
    }
}

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
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 *
 * @Route("/stat/{_locale}")
 */
class MainController extends Controller
{
    /**
     * Load the description of a rendering of a statistic (ajax).
     *
     * @Route("/buildChart/{statId}", defaults={"_format"="json"})
     * @Template()
     */
    public function buildChartAction($statId)
    {
        try {
            $criteria = $this->get('request')->query->get('criteria', array());
            $chart = $this->get('da_stat.moderator')->buildChart($statId, $criteria);
        } catch (SecurityException $e) {
            throw new AccessDeniedException($e->getMessage());
        } catch (NoDataException $e) {
            throw new NotFoundHttpException('No data has been found for the chart');
        }

        return array('chart' => $chart);
    }
}

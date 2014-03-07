<?php

namespace Da\StatBundle\Handler;

use Da\StatBundle\Aggregator\AggregatorInterface;
use Da\StatBundle\Renderer\RendererInterface;
use Da\StatBundle\Filter\FilterInterface;
use Da\StatBundle\Criterion\CriterionInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Finder\Finder;

/**
 * StatMediator is the mediator of the statistic architecture.
 * It handles the interactions between the different components.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class StatMediator implements StatMediatorInterface
{
    /**
     * The router.
     *
     * @var Router
     */
    private $router;

    /**
     * The translator.
     *
     * @var Translator
     */
    private $translator;

    /**
     * The aggregators.
     *
     * @var array
     */
    private $aggregators = array();

    /**
     * The renderers.
     *
     * @var array
     */
    private $renderers = array();

    /**
     * The filters.
     *
     * @var array
     */
    private $filters = array();

    /**
     * The configuration of the statistics.
     *
     * @var array
     */
    private $statConfig;

    /**
     * The configuration of the assemblies.
     *
     * @var array
     */
    private $assembliesConfig;

    /**
     * The configuration of the menu.
     *
     * @var array
     */
    private $menuConfig;

    /**
     * Constructeur.
     *
     * @param Router              $router         The router.
     * @param TranslatorInterface $translator     The translator.
     * @param string              $statConfig     The configuration of the statistics.
     * @param string              $assembliesConfig The configuration of the assemblies.
     * @param string              $menuConfig     The configuration of the menu.
     */
    public function __construct(Router $router, TranslatorInterface $translator, array $statConfig, array $assembliesConfig, array $menuConfig)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->statConfig = $statConfig;
        $this->assembliesConfig = $assembliesConfig;
        $this->menuConfig = $menuConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function addAggregator(AggregatorInterface $aggregator, $aggregatorId)
    {
        $this->aggregators[$aggregatorId] = $aggregator;
    }

    /**
     * {@inheritdoc}
     */
    public function addRenderer(RendererInterface $renderer, $rendererId)
    {
        $this->renderers[$rendererId] = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(FilterInterface $filter, $filterId)
    {
        $this->filters[$filterId] = $filter;
    }

    /**
     * Get an aggregator.
     *
     * @param string $id The id of the aggregator.
     */
    protected function getAggregator($id)
    {
        if (!isset($this->aggregators[$id])) {
            throw new \LogicException(sprintf(
                'The aggregator "%s" does not exist.',
                $id
            ));
        }

        return $this->aggregators[$id];
    }

    /**
     * Get a renderer.
     *
     * @param string $id The id of the renderer.
     */
    protected function getRenderer($id)
    {
        if (!isset($this->renderers[$id])) {
            throw new \LogicException(sprintf(
                'The renderer "%s" does not exist.',
                $id
            ));
        }

        return $this->renderers[$id];
    }

    /**
     * Get a filter.
     *
     * @param string $id The id of the filter.
     */
    protected function getFilter($id)
    {
        if (!isset($this->filters[$id])) {
            throw new \LogicException(sprintf(
                'The filter "%s" does not exist.',
                $id
            ));
        }

        return $this->filters[$id];
    }

     /**
     * {@inheritdoc}
     */
    protected function getAssembly($id)
    {
        if (!isset($this->assembliesConfig[$id])) {
            throw new \LogicException(sprintf(
                'The assembly "%s" is not defined in the configuration.',
                $id
            ));
        }

        return $this->assembliesConfig[$id];
    }

    /**
     * {@inheritdoc}
     */
    public function getMenu($category = '', $statId = '')
    {
        if (!isset($this->menuConfig)) {
            return array('items' => array());
        }

        $formattedMenu = array();

        foreach ($this->menuConfig['items'] as $menuName => $item) {
            $menuKey = count($formattedMenu);

            if (empty($category) || $category === $item['category']) {
                $formattedMenu[$menuKey] = array(
                    'name' => $this->translator->trans($menuName, array(), 'menu'),
                    'stat' => $item['stat'],
                    'assembly' => ($assembly = $this->getAssembly($item['stat'])) ? $assembly : array($item['stat']),
                    'isActive' => ($statId === $item['stat'])
                );
            }
        }

        return array('items' => $formattedMenu);
    }

    /**
     * {@inheritdoc}
     */
    public function getChartsFiltersCriteria(array $statIds)
    {
        $chartsCriteria = array();

        foreach ($statIds as $statId) {
            $chartsCriteria[$statId] = $this->getChartFilterCriteria($statId);
        }

        return $chartsCriteria;
    }

    /**
     * {@inheritdoc}
     */
    public function getChartFilterCriteria($statId)
    {
        if ($statIds = $this->getAssembly($statId)) {
            return $this->getChartsFilters($statIds);
        }

        if (!isset($this->statConfig[$statId])) {
            throw new \Exception(sprintf(
                'The statistic "%s" is not defined in the configuration.',
                $statId
            ));
        }

        $chartCriteria = array();

        if (isset($this->statConfig[$statId]['filter'])) {
            $filterId = $this->statConfig[$statId]['filter'];
            $filter = $this->getFilter($filterId);
            $chartCriteria = $filter->getCriteria();

            foreach ($chartCriteria as $key => $criterion) {
                if ($criterion instanceof CriterionInterface) {
                    $chartCriteria[$key] = $criterion->getCriterionDescription();
                } else {
                    throw new \Exception(sprintf(
                        'The method "getCriteria" of the filter "%s" must return an array of objects implementing the interface "CriterionInterface".',
                        $filterId
                    ));
                }
            }
        }

        return $chartCriteria;
    }

    /**
     * {@inheritdoc}
     */
    public function buildChart($statId, $criteria)
    {
        if (isset($this->statConfig[$statId]))
        {
            $statConfig = $this->statConfig[$statId];

            $aggregatorId = $statConfig['aggregator'];
            $aggregator = $this->getAggregator($aggregatorId);

            $rendererId = $statConfig['renderer'];
            $renderer = $this->getRenderer($rendererId);

            $criteria = $aggregator->formatCriteria($criteria);
            $criteria = $aggregator->checkCriteria($criteria);
            $data = $aggregator->aggregate($criteria);

            if (!$renderer->supports($data)) {
                throw new \LogicException(sprintf(
                    'The renderer "%s" does not support data of class "%s" returned by the aggregator for the statistic "%s".',
                    $rendererId,
                    get_class($data),
                    $statId
                ));
            }

            $renderingDescription = $renderer->render($data);
            $type = $renderer->getType();
            $renderingDescription = $this->buildChartSpecificType($statId, $type, $renderingDescription);
            $renderingDescription = array('type' => $type, 'data' => $renderingDescription);

            return json_encode($renderingDescription);
        }

        if (isset($this->assembliesConfig[$statId])) {
            throw new \LogicException(sprintf(
                'The assembly "%s" cannot be rendered. Only simple statistics can be build.',
                $statId
            ));
        }

        throw new \LogicException(sprintf(
            'The statistic "%s" is not defined in the configuration.',
            $statId
        ));
    }

    /**
     * Build the specific description of the type of renderer.
     *
     * @param string $statId               The id of the statistic.
     * @param string $type                 The type of renderer.
     * @param array  $renderingDescription The rendering description.
     *
     * @return array The completed rendering description.
     */
    private function buildChartSpecificType($statId, $type, $renderingDescription)
    {
        $statConfig = $this->statConfig[$statId];

        switch ($type) {
            case 'highcharts':
                if (isset($statConfig['labels']['title'])) {
                    if (!isset($renderingDescription['title'])) {
                        $renderingDescription['title'] = array();
                    }

                    $renderingDescription['title']['text'] = $this->translator->trans($statConfig['labels']['title'], array(), 'chart');
                }
                if (isset($statConfig['labels']['xAxis'])) {
                    if (!isset($renderingDescription['xAxis'])) {
                        $renderingDescription['xAxis'] = array();
                    }

                    if (!isset($renderingDescription['xAxis']['title'])) {
                        $renderingDescription['xAxis']['title'] = array();
                    }

                    $renderingDescription['xAxis']['title']['text'] = $this->translator->trans($statConfig['labels']['xAxis'], array(), 'chart');
                }
                if (isset($statConfig['labels']['yAxis'])) {
                    if (!isset($renderingDescription['yAxis'])) {
                        $renderingDescription['yAxis'] = array();
                    }

                    if (!isset($renderingDescription['yAxis']['title'])) {
                        $renderingDescription['yAxis']['title'] = array();
                    }

                    $renderingDescription['yAxis']['title']['text'] = $this->translator->trans($statConfig['labels']['yAxis'], array(), 'chart');
                }

                break;
            case 'da.widget':
                if (isset($statConfig['labels']['title'])) {
                    $renderingDescription['title'] = $this->translator->trans($statConfig['labels']['title'], array(), 'chart');
                }

                if (isset($statConfig['labels']['legend'])) {
                    $renderingDescription['legend'] = $this->translator->trans($statConfig['labels']['legend'], array(), 'chart');
                }

                break;
        }

        return $renderingDescription;
    }
}
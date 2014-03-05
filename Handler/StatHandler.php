<?php

namespace Da\StatBundle\Handler;

use Da\StatBundle\Aggregator\AggregatorInterface;
use Da\StatBundle\Renderer\RendererInterface;
use Da\StatBundle\Filter\FilterInterface;
use Da\StatBundle\Criterium\CriteriumInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Finder\Finder;

/**
 * StatHandler est la classe principale de gestion des fonctionnalités
 * liées aux statistiques. Il est l'interface de l'encapsulation du mécanisme 
 * des statistiques. C'est lui qui doit être appelé par les contrôleurs.
 *
 * @author Thomas Prelot
 */
class StatHandler implements StatHandlerInterface
{
    /**
     * Le service de routage.
     *
     * @var Router
     */
    private $router;

    /**
     * Le service de traduction.
     *
     * @var Translator
     */
    private $translator;

	/**
     * La liste des aggrégateurs.
     *
     * @var array
     */
	private $aggregators = array();

	/**
     * La liste des gestionnaires de rendu.
     *
     * @var array
     */
	private $renderers = array();

    /**
     * La liste des filtres.
     *
     * @var array
     */
    private $filters = array();

	/**
     * La configuration des statistiques.
     *
     * @var array
     */
	private $statConfig;

    /**
     * La configuration des assemblages de statistiques.
     *
     * @var array
     */
    private $assemblyConfig;

	/**
     * La configuration du menu.
     *
     * @var array
     */
	private $menuConfig;

	/**
     * Constructeur.
     *
     * @param Router              $router         Le service de routage.
     * @param TranslatorInterface $translator     Le service de traduction.
     * @param string              $statConfig     La configuration des statistiques.
     * @param string              $assemblyConfig La configuration des assemblages de statistiques.
     * @param string              $menuConfig     La configuration du menu.
     */
    public function __construct(Router $router, TranslatorInterface $translator, array $statConfig, array $assemblyConfig, array $menuConfig)
    {
        $this->router = $router;
        $this->translator = $translator;
        $this->statConfig = $statConfig;
        $this->assemblyConfig = $assemblyConfig;
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
     * {@inheritdoc}
     */
    public function getMenu($category = '', $statId = '')
    {
        if (!isset($this->menuConfig))
            return array('items' => array());

        $formattedMenu = array();
        foreach ($this->menuConfig['items'] as $menuName => $item) 
        {
            $menuKey = count($formattedMenu);
            if (empty($category) || $category === $item['category'])
            {
                $formattedMenu[$menuKey] = array
                    (
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
        foreach ($statIds as $statId) 
        {
            $chartsCriteria[$statId] = $this->getChartFilterCriteria($statId);
        }
        return $chartsCriteria;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception Si le filtre associé n'a pas été défini dans la liste des services ou si le tag da.stat.filter a été oublié lors de sa définition.
     * @throws \Exception Si la statistique n'a pas été définie dans la configuration du bundle de stat (da_stat).
     * @throws \Exception Si le retour du filtre a un format incorrect.
     */
    public function getChartFilterCriteria($statId)
    {
        if ($statIds = $this->getAssembly($statId))
            return $this->getChartsFilters($statIds);

        if (!isset($this->statConfig[$statId]))
            throw new \Exception('La statistique '.$statId.' n\'est pas définie dans la configuration de da_stat.');

        $chartCriteria = array();
        if (isset($this->statConfig[$statId]['filter']))
        {
            $filterId = $this->statConfig[$statId]['filter'];
            if (!isset($this->filters[$filterId]))
                throw new \Exception('Le filtre '.$filterId.' n\'est pas défini dans la liste des services ou le tag da.stat.filter a été oublié lors de sa définition.');
            
            $filter = $this->filters[$filterId];
            $chartCriteria = $filter->getCriteria();
            foreach ($chartCriteria as $key => $criteria) 
            {
                if ($criteria instanceof CriteriumInterface)
                    $chartCriteria[$key] = $criteria->getCriteriumDescription();
                else
                    throw new \Exception('La méthode getCriteria du filtre '.$filterId.' doit renvoyer une liste de critères implémentant l\'interface CriteriumInterface.');
            }
        }
        return $chartCriteria;
    }

    /**
     * {@inheritdoc}
     */
    public function getAssembly($statId)
    {
        if (isset($this->assemblyConfig[$statId]))
            return $this->assemblyConfig[$statId];
    }

	/**
     * {@inheritdoc}
     *
	 * @throws \Exception Si l'aggrégateur associé n'a pas été défini dans la liste des services ou si le tag da.stat.aggregator a été oublié lors de sa définition.
	 * @throws \Exception Si le gestionnaire de rendu associé n'a pas été défini dans la liste des services ou si le tag da.stat.renderer a été oublié lors de sa définition.
	 * @throws \Exception Si le gestionnaire de rendu associé ne supporte pas la données renvoyé par l'aggrégateur.
     * @throws \Exception Si la statistique n'a pas été définie dans la configuration du bundle de stat (da_stat).
     * @throws \Exception Si la statistique est un assemblage de statistiques et non une statistique simple.
     */
	public function buildChart($statId, $criteria)
	{
		if (isset($this->statConfig[$statId]))
		{
            $statConfig = $this->statConfig[$statId];
			$aggregatorId = $statConfig['aggregator'];
			if (!isset($this->aggregators[$aggregatorId]))
				throw new \Exception('L\aggrégateur '.$aggregatorId.' n\'est pas défini dans la liste des services ou le tag da.stat.aggregator a été oublié lors de sa définition.');
			$rendererId = $statConfig['renderer'];
			if (!isset($this->renderers[$rendererId]))
				throw new \Exception('Le gestionnaire de rendu '.$rendererId.' n\'est pas défini dans la liste des services ou le tag da.stat.renderer a été oublié lors de sa définition.');
			$aggregator = $this->aggregators[$aggregatorId];
            $criteria = $aggregator->formatCriteria($criteria);
            $criteria = $aggregator->checkCriteria($criteria);
            $data = $aggregator->aggregate($criteria);
            $renderer = $this->renderers[$rendererId];
            if (!$renderer->support($data))
                throw new \Exception('Le gestionnaire de rendu '.$rendererId.' ne supporte pas le type de données '.get_class($data).' renvoyé par l\aggrégateur.');
            $renderingDescription = $renderer->render($data);
            $type = $renderer->getType();
            $renderingDescription = $this->buildChartSpecificType($statId, $type, $renderingDescription);
            $renderingDescription = array('type' => $type, 'data' => $renderingDescription);
            return json_encode($renderingDescription);
		}
		
        if (isset($this->assemblyConfig[$statId]))
            throw new \Exception('L\'assemblage de statistiques '.$statId.' ne peut pas appeler la méthode de fabrication de graphique. Seules les statistiques simples peuvent le faire.');
		throw new \Exception('La statistique '.$statId.' n\'est pas définie dans la configuration de da_stat.');
	}

    /**
     * Fabrique la description spécifique au type du rendu d'une statistique.
     *
     * @param string $statId               L'identifiant de la statistique.
     * @param string $type                 Le type de rendu.
     * @param array  $renderingDescription La description du rendu déjà calculée.
     *
     * @return array La description du rendu complétée.
     */
    private function buildChartSpecificType($statId, $type, $renderingDescription)
    {
        $statConfig = $this->statConfig[$statId];
 
        switch ($type)
        {
            case 'highcharts':
                if (isset($statConfig['labels']['title']))
                {
                    if (!isset($renderingDescription['title']))
                        $renderingDescription['title'] = array();
                    $renderingDescription['title']['text'] = $this->translator->trans($statConfig['labels']['title'], array(), 'chart');
                }
                if (isset($statConfig['labels']['xAxis']))
                {
                    if (!isset($renderingDescription['xAxis']))
                        $renderingDescription['xAxis'] = array();
                    if (!isset($renderingDescription['xAxis']['title']))
                        $renderingDescription['xAxis']['title'] = array();
                    $renderingDescription['xAxis']['title']['text'] = $this->translator->trans($statConfig['labels']['xAxis'], array(), 'chart');
                }
                if (isset($statConfig['labels']['yAxis']))
                {
                    if (!isset($renderingDescription['yAxis']))
                        $renderingDescription['yAxis'] = array();
                    if (!isset($renderingDescription['yAxis']['title']))
                        $renderingDescription['yAxis']['title'] = array();
                    $renderingDescription['yAxis']['title']['text'] = $this->translator->trans($statConfig['labels']['yAxis'], array(), 'chart');
                }
                break;
            case 'da.widget':
                if (isset($statConfig['labels']['title']))
                    $renderingDescription['title'] = $this->translator->trans($statConfig['labels']['title'], array(), 'chart');
                if (isset($statConfig['labels']['legend']))
                    $renderingDescription['legend'] = $this->translator->trans($statConfig['labels']['legend'], array(), 'chart');
                break;
        }

        return $renderingDescription;
    }
}
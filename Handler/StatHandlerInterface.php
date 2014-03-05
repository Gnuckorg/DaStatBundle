<?php

namespace Da\StatBundle\Handler;

use Da\StatBundle\Aggregator\AggregatorInterface;
use Da\StatBundle\Renderer\RendererInterface;
use Da\StatBundle\Filter\FilterInterface;

/**
 * StatHandlerInterface est l'interface que doit implémenter un gestionnaire
 * principal pour les statistiques qui est l'interface de l'encapsulation du mécanisme 
 * des statistiques. C'est lui qui doit être appelé par les contrôleurs.
 *
 * @author Thomas Prelot
 */
interface StatHandlerInterface
{
	/**
     * Ajoute un aggrégateur à la liste des aggrégateurs.
     *
     * @param AggregatorInterface $aggregator   L'aggrégateur.
     * @param string              $aggregatorId L'identifiant de l'aggrégateur.
     */
    function addAggregator(AggregatorInterface $aggregator, $aggregatorId);

    /**
     * Ajoute un gestionnaire de rendu à la liste des gestionnaires.
     *
     * @param RendererInterface $renderer   Le gestionnaire de rendu.
     * @param string            $rendererId L'identifiant du gestionnaire de rendu.
     */
    function addRenderer(RendererInterface $renderer, $rendererId);

    /**
     * Ajoute un filtre à la liste des filtres.
     *
     * @param FilterInterface $filter     Le filtre.
     * @param string          $filterId L'identifiant du filtre.
     */
    function addFilter(FilterInterface $filter, $filterId);

    /**
     * Récupère la liste des menus pour une ou toutes les catégories et pour une ou toutes les statistiques.
     *
     * @param string $category La categorie des menus à récupérer.
     * @param string $statId   L'identifiant de la statistique ou de l'assemblage de statistiques.
     *
     * @return array La liste des menus.
     */
    function getMenu($category = '', $statId = '');

    /**
     * Récupère les critères de filtrage pour un ensemble de statistiques.
     *
     * @param array $statIds Les identifiants des statistiques.
     *
     * @return array La liste des critères de filtrage des statistiques.
     */
    function getChartsFiltersCriteria(array $statIds);

    /**
     * Récupère les critères de filtrage pour une statistique.
     *
     * @param string $statId L' identifiant de la statistique.
     *
     * @return array La liste des critères de filtrage de la statistique.
     */
    function getChartFilterCriteria($statId);

    /**
     * Récupère la liste des identifiants des statistiques de l'assemblage s'il existe.
     *
     * @param string $statId L'identifiant de la statistique ou de l'assemblage de statistiques.
     *
     * @return array|null La liste des identifiants des statistiques de l'assemblage s'il existe, null sinon.
     */
    function getAssembly($statId);

	/**
     * Fabrique la description du rendu d'une statistique.
     *
     * @param string $statId   L'identifiant de la statistique.
     * @param array  $criteria Les valeurs des critères de filtrage.
     *
     * @return array La description du rendu.
     */
	function buildChart($statId, $criteria);
}
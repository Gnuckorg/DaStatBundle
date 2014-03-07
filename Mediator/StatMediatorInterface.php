<?php

namespace Da\StatBundle\Mediator;

use Da\StatBundle\Aggregator\AggregatorInterface;
use Da\StatBundle\Renderer\RendererInterface;
use Da\StatBundle\Filter\FilterInterface;

/**
 * StatMediatorInterface is the interface that a class should implement
 * to be used as a mediator for the mechanism of the statistics.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface StatMediatorInterface
{
    /**
     * Add an aggregator to the aggregators.
     *
     * @param AggregatorInterface $aggregator The aggregator.
     * @param string              $id         The id of the aggregator.
     */
    function addAggregator(AggregatorInterface $aggregator, $id);

    /**
     * Add a renderer to the renderers.
     *
     * @param RendererInterface $renderer The renderer.
     * @param string            $id       The id of the renderer.
     */
    function addRenderer(RendererInterface $renderer, $id);

    /**
     * Add a filter to the filters.
     *
     * @param FilterInterface $filter The filter.
     * @param string          $id     The id of the filter.
     */
    function addFilter(FilterInterface $filter, $id);

    /**
     * Retrieve the menu list for one or all the categories and for one or all the statistics.
     *
     * @param string $category The category.
     * @param string $statId   The id of the statistic.
     *
     * @return array The list of the menus.
     */
    function getMenu($category = '', $statId = '');

    /**
     * Retrieve the filters criteria for many statistics.
     *
     * @param array $statIds The ids of the statistics.
     *
     * @return array The filters criteria.
     */
    function getChartsFiltersCriteria(array $statIds);

    /**
     * Retrieve the filters criteria for one statistic.
     *
     * @param string $statId The id of the statistic.
     *
     * @return array The filters criteria.
     */
    function getChartFilterCriteria($statId);

    /**
     * Retrieve the list of the ids of the statistics of an assembly.
     *
     * @param string $statId The id of the statistic.
     *
     * @return array The list of the ids of the statistics of the assembly.
     */
    function getAssembly($statId);

    /**
     * Retrieve the config of a statistic.
     *
     * @param string $statId The id of the statistic.
     *
     * @return array The config of a statistic.
     */
    function getStat($statId);

    /**
     * Build the rendering description of a statistic.
     *
     * @param string $statId   The id of the statistic.
     * @param array  $criteria The filters criteria.
     *
     * @return string The rendering description (json encoded array).
     */
    function buildChart($statId, $criteria);
}
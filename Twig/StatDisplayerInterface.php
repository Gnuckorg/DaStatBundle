<?php

namespace Da\StatBundle\Twig;

/**
 * StatDisplayerInterface is the interface that a class should implement to
 * be used displayer for the statistics.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface StatDisplayerInterface
{
    /**
     * Display a statistic.
     *
     * @param string $id The id of the statistic.
     *
     * @return string The statistic rendering.
     */
    function displayStat($id);
}
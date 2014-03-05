<?php

namespace Da\StatBundle\Data;

/**
 * SeriesDataInterface est l'interface d'une donnée qui possède
 * des séries.
 *
 * @author Thomas Prelot
 */
interface SeriesDataInterface extends DataInterface
{
	/**
     * Ajoute une série de valeurs.
     *
     * @param string $name   Le nom de la série.
     * @param array  $series Les valeurs de la série.
     *
     * @throws \Exception Si le format de la série est incorrect.
     */
	function addSeries($name, array $series);
}
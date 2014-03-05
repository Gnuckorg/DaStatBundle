<?php

namespace Da\StatBundle\Data;

/**
 * TypedSeriesDataInterface est l'interface d'une donnée qui possède
 * des séries dont on peut spécifier le type de représentation.
 *
 * @author Thomas Prelot
 */
interface TypedSeriesDataInterface extends DataInterface
{
	/**
     * Ajoute une série de valeurs.
     *
     * @param string $name   Le nom de la série.
     * @param array  $series Les valeurs de la série.
     * @param string $type   Le type de représentation de la série.
     *
     * @throws \Exception Si le format de la série est incorrect.
     */
	function addSeries($name, array $series, $type);
}
<?php

namespace Da\StatBundle\Data;

/**
 * UnitDataInterface est l'interface d'une donnée qui renseigne 
 * une unité.
 *
 * @author Thomas Prelot
 */
interface UnitDataInterface extends DataInterface
{
    /**
     * Récupère l'unité de la donnée.
     *
     * @return string L'unité.
     */
	function getUnit();

	/**
     * Fixe l'unité de la donnée.
     *
     * @param string $unit L'unité.
     */
	function setUnit($unit);
}
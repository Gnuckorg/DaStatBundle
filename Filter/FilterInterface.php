<?php

namespace Da\StatBundle\Filter;

/**
 * FilterInterface est l'interface qu'un filtre doit 
 * implémenter pour être utilisée par le service da.stat.handler.
 *
 * @author Thomas Prelot
 */
interface FilterInterface
{
	/**
     * Récupère les critères de filtrage.
     *
     * @return array Une liste de critères implémentant CriteriumInterface.
     */
	function getCriteria();
}
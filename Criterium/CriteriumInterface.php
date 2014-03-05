<?php

namespace Da\StatBundle\Criterium;

/**
 * CriteriumInterface est l'interface qu'un critère de filtrage 
 * doit implémenter.
 *
 * @author Thomas Prelot
 */
interface CriteriumInterface
{
	/**
     * Récupère la description du critère.
     *
     * @return array La description du critère.
     */
	function getCriteriumDescription();
}
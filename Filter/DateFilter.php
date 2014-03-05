<?php

namespace Da\StatBundle\Filter;

use Da\StatBundle\Criterium\SelectCriterium;

/**
 * DateFilter est la classe qui permet de récupérer
 * les critères de filtrage sur une plage de dates.
 *
 * @author Thomas Prelot
 */
class DateFilter implements FilterInterface
{
	/**
     * {@inheritdoc}
     */
	public function getCriteria()
	{
		$startDate = new SelectCriterium('startDate');
		$startDate->addOption('2008', 2008, true)
		          ->addOption('2009', 2009)
		          ->addOption('2010', 2010)
		          ->addOption('2011', 2011)
		          ->addOption('2012', 2012)
		          ->addOption('2012', 2013);
		
		$endDate = new SelectCriterium('endDate');
		$endDate->addOption('2008', 2008)
		        ->addOption('2009', 2009)
		        ->addOption('2010', 2010)
		        ->addOption('2011', 2011)
		        ->addOption('2012', 2012)
		        ->addOption('2013', 2013, true);

		return array($startDate, $endDate);
	}
}
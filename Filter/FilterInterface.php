<?php

namespace Da\StatBundle\Filter;

/**
 * FilterInterface is the interface that a class should implement
 * to be used as a filter.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface FilterInterface
{
	/**
     * Get the criteria of the filter.
     *
     * @return array An array of criteria implementing \Da\StatBundle\CriterionCriterionInterface.
     */
	function getCriteria();
}
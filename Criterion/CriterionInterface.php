<?php

namespace Da\StatBundle\Criterion;

/**
 * CriterionInterface is the interface that a class should implement to
 * be used as a criterion for a filter.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface CriterionInterface
{
    /**
     * Retrieve the description of the criterion.
     *
     * @return array The description of the criterion.
     */
    function getCriterionDescription();
}
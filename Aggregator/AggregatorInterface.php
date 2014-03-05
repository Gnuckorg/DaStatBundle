<?php

namespace Da\StatBundle\Aggregator;

use Da\StatBundle\Data\DataInterface;
use Da\StatBundle\Exception\SecurityException;

/**
 * AggregatorInterface is the interface that a class should implement 
 * to be used as an aggregator.
 *
 * @author Thomas Prelot
 */
interface AggregatorInterface
{
      /**
       * Format the criteria.
       *
       * @param array $criteria The criteria.
       *
       * @return array The formatted criteria.
       *
       * @throws \InvalidArgumentException If the criteria are not the intended ones.
       */
      function formatCriteria(array $criteria = array());

      /**
       * Check the validity and rights associated to the criteria.
       *
       * @param array $criteria The criteria.
       *
       * @return array The checked criteria.
       *
       * @throws \InvalidArgumentException If the criteria are not the intended ones.
       * @throws SecurityException If the criteria correspond to an unauthorized data.
       */
     function checkCriteria(array $criteria = array());

      /**
       * Retrieve the data.
       *
       * @param array $criteria The criteria.
       *
       * @return DataInterface The data.
       */
      function aggregate(array $criteria = array());
}
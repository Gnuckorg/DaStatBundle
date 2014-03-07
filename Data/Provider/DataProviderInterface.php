<?php

namespace Da\StatBundle\Data\Provider;

/**
 * DataProviderInterface is the interface that a class should implement
 * to be used as provider for a type of data.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface DataProviderInterface
{
    /**
     * Create and return a data.
     *
     * @return \Da\StatBundle\Data\DataInterface The data.
     */
    function create();
}
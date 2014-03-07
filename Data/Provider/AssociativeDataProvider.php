<?php

namespace Da\StatBundle\Data\Provider;

/**
 * Provider for data of type associative.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class AssociativeDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     */
    abstract protected function getDataClassName()
    {
        return '\Da\StatBundle\Data\AssociativeData';
    }
}
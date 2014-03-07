<?php

namespace Da\StatBundle\Data\Provider;

/**
 * Provider for data of type table.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class ListDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getDataClassName()
    {
        return '\Da\StatBundle\Data\TableData';
    }
}
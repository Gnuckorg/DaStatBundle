<?php

namespace Da\StatBundle\Data\Provider;

/**
 * Provider for data of type array_list.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class ArrayListDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getDataClassName()
    {
        return '\Da\StatBundle\Data\ArrayListData';
    }
}
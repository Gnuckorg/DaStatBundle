<?php

namespace Da\StatBundle\Data;

/**
 * ArrayListData is a data of type array_list.
 *
 * Example:
 *     ->setValue({'apple': 1, 'banana': 3, 'strawberry': 5})
 *     ->setValue({'apple': 5, 'banana': 3, 'strawberry': 2})
 *     ->setValue({'apple': 10, 'banana': 11, 'strawberry': 0})
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class ArrayListData extends AbstractData
{
    /**
     * {@inheritdoc}
     */
    protected function hasAssociativeValues()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkValue($value)
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                'The value should be an array; "%s" given instead.',
                gettype($value)
            ));
        }

        if (!$this->isAssociativeArray($value)) {
            throw new \InvalidArgumentException(
            	'The value should be an associative array; "list of values" given instead.'
            );
        }
    }
}
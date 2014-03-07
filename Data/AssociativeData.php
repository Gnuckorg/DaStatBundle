<?php

namespace Da\StatBundle\Data;

/**
 * AssociativeData is a data of type associative.
 *
 * Example:
 *     ->setValue('apple', 'my_fruit')
 *     ->setValue('banana', 'your_fruit')
 *     ->setValue('strawberry', 'her_fruit')
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class AssociativeData extends AbstractData
{
    /**
     * {@inheritdoc}
     */
    protected function hasAssociativeValues()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function checkValue($value)
    {
        if (is_numeric($value) || is_string($value) || $value instanceof \DateTime) {
            throw new \InvalidArgumentException(sprintf(
                'The value should be a numeric, a string or a DateTime; "%s" given instead.',
                gettype($value)
            ));
        }
    }
}
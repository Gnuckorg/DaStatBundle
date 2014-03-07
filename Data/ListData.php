<?php

namespace Da\StatBundle\Data;

/**
 * ListData is a data of type list.
 *
 * Example:
 *     ->setValue('apple')
 *     ->setValue('banana')
 *     ->setValue('strawberry')
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class ListData extends AbstractData
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
        if (!is_numeric($value) && !is_string($value) && !($value instanceof \DateTime)) {
            throw new \InvalidArgumentException(sprintf(
                'The value should be a numeric, a string or a DateTime; "%s" given instead.',
                gettype($value)
            ));
        }
    }
}
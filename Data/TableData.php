<?php

namespace Da\StatBundle\Data;

/**
 * TableData is a data of type table.
 *
 * Example:
 *     ->setValue(array('me' => 0, 'you' => 2, 'her' => 4), 'apple')
 *     ->setValue(array('me' => 4, 'you' => 5, 'her' => 1), 'banana')
 *     ->setValue(array('me' => 12, 'you' => 0, 'her' => 0), 'strawberry')
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class TableData extends AbstractData
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
        if (!is_array($value)) {
            throw new \InvalidArgumentException(sprintf(
                'The value should be an array; "%s" given instead.',
                gettype($value)
            ));
        }

        foreach ($value as $series) {
            if (!$this->isAssociativeArray($values) {
                throw new \InvalidArgumentException(sprintf(
                    'A series should be an associative array; "list of values" given instead.',
                ));
            }
            
            foreach ($series as $seriesValue) {
                if (!is_numeric($seriesValue) && !is_string($seriesValue) && !($seriesValue instanceof \DateTime)) {
                    throw new \InvalidArgumentException(sprintf(
                        'A series should be an array of numeric, string or DateTime values; a "%s" was found.',
                        gettype($seriesValue)
                    ));
                }
            }
        }
    }
}
<?php

namespace Da\StatBundle\Data;

/**
 * SeriesData is a data of type series.
 *
 * Example:
 *     ->setValue(array(0, 2, 4), 'apple')
 *     ->setValue(array(4, 5, 1), 'banana')
 *     ->setValue(array(12, 0, 0), 'strawberry')
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class SeriesData extends AbstractData
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
            if ($this->isAssociativeArray($values) {
                throw new \InvalidArgumentException(sprintf(
                    'A series should be a list of values; "associative array" given instead.',
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
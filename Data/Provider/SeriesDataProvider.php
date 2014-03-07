<?php

namespace Da\StatBundle\Data\Provider;

/**
 * Provider for data of type series.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class SeriesDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getDataClassName()
    {
        return '\Da\StatBundle\Data\SeriesData';
    }
}
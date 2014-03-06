<?php

namespace Da\StatBundle\Exception;

/**
 * Exception thrown when an aggregator find no data.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class NoDataException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No data found.');
    }
}
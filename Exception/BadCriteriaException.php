<?php

namespace Da\StatBundle\Exception;

/**
 * Exception thrown when the criteria are invalid.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class BadCriteriaException extends \Exception
{
    public function __construct(array $criteria, $message, \Exception $innerException = null)
    {
        parent::__construct(
        	sprintf(
	        	'The criteria "%s" are invalid (%s).',
	        	json_encode($criteria),
	        	$message
	        ),
	        0,
	        $innerException
	    );
    }
}
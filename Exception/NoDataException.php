<?php

namespace Da\StatBundle\Exception;

/**
 * Une exception si un agrégateur n'a pas réussi à récupérer de données.
 *
 * @author Thomas Prelot
 */
class NoDataException extends \Exception
{
	public function __construct()
	{
		parent::__construct('L\'agrégateur n\'a pas réussi à récupérer de données.');
	}
}
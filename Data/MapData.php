<?php

namespace Da\StatBundle\Data;

/**
 * MapData est la classe de données qui gère des séries de données
 * dont les éléments sont relatives aux départements.
 * 
 * Par exemple (key: value): 
 *     77: 100, 75: 256, 78: 30
 *
 * @author Thomas Prelot
 */
class MapData implements DataInterface
{
	/**
     * Les valeurs.
     *
     * @var array
     */
	private $values = array();

	/**
      * Fixe les valeurs de la donnée.
      *
      * @param array $values Les valeurs.
      */
	public function setValues(array $values)
	{
		foreach ($values as $key => $value)
		{
			if (strlen(strval($key)) == 2 && is_numeric($value))
				continue;
			throw new \InvalidArgumentException('Les valeurs doivent être un tableau associatif de nombres avec les clés étant le numéro des départements.');
		}
		$this->values = $values;
	}

	/**
     * {@inheritdoc}
     */
	public function getValues()
	{
		return $this->values;
	}
}
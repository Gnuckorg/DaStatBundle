<?php

namespace Da\StatBundle\Data;

/**
 * UnitDefinedData est la classe de données qui gère des séries de données
 * dont les éléments sont définis et qui renseigne une unité.
 * 
 * Par exemple (key: value):
 *     'pomme': 2, 'poire': 3, 'banane': 7
 *
 * @author Thomas Prelot
 */
class UnitDefinedData extends DefinedData implements UnitDataInterface
{
    /**
     * L'unité de la donnée.
     *
     * @var string
     */
	private $unit;

    /**
     * {@inheritdoc}
     */
	public function getUnit()
	{
		return $this->unit;
	}

	/**
     * {@inheritdoc}
     */
	public function setUnit($unit)
	{
		$this->unit = $unit;
	}
}
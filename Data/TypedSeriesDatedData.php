<?php

namespace Da\StatBundle\Data;

/**
 * TypedSeriesDatedData est la classe de données qui gère des séries de données
 * dont les clés sont des timestamp et les valeurs des nombres.
 * 
 * Par exemple (key: value):
 *     série 15654112: 1: 15654455, 2: 3, 15654862: 7
 *     série 15654112: 2: 15654477, 4: 4, 15654862: 0
 *
 * @author Thomas Prelot
 */
class TypedSeriesDatedData implements TypedSeriesDataInterface
{
	/**
     * Les séries.
     *
     * @var array
     */
	private $series = array();

    /**
     * Le nombre de décimal après la virgule de la donnée.
     *
     * @var integer
     */
	private $decimalNumber = 0;

	/**
     * {@inheritdoc}
     */
	public function addSeries($name, array $series, $type)
	{
		foreach ($series as $key => $value)
		{
			if (!is_int($key) || !is_numeric($value))
				throw new \Exception('La série doit être un tableau de clés représentant un timestamp et de valeurs étant un nombre.');
		}
		$this->series[$name] = array('data' => $series, 'type' => $type);
	}

	/**
     * {@inheritdoc}
     */
	public function getValues()
	{
		return $this->series;
	}

    /**
     * Fixe Le nombre de décimal après la virgule de la donnée.
     *
     * @param integer $subtitle Le nombre de décimal après la virgule.
     */
	public function setDecimalNumber($decimalNumber)
	{
		$this->decimalNumber = $decimalNumber;
	}

    /**
     * Récupère Le nombre de décimal après la virgule de la donnée.
     *
     * @return integer Le nombre de décimal après la virgule.
     */
	public function getDecimalNumber()
	{
		return $this->decimalNumber;
	}
}
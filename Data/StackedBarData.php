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
class StackedBarData implements TypedSeriesDataInterface
{
    
    /**
     * Le titre de la donnée.
     *
     * @var string
     */
	private $title = '';
    
    /**
     * L'unité de la donnée.
     *
     * @var string
     */
	private $unit = '';
    
	/**
     * Les séries.
     *
     * @var array
     */
	private $series = array();
    
    /**
     * Récupère le titre de la donnée.
     *
     * @return string Le titre.
     */
	public function getTitle()
	{
		return $this->title;
	}

	/**
     * Fixe le titre de la donnée.
     *
     * @param string $title Le titre.
     */
	public function setTitle($title)
	{
		$this->title = $title;
	}
    
    /**
     * Récupère l'unité de la donnée.
     *
     * @return string L'unité.
     */
	public function getUnit()
	{
		return $this->unit;
	}

	/**
     * Fixe l'unité de la donnée.
     *
     * @param string $unit L'unité.
     */
	public function setUnit($unit)
	{
		$this->unit = $unit;
	}

	/**
     * {@inheritdoc}
     */
	public function addSeries($name, array $series, $type)
	{
		/*foreach ($series as $key => $value)
		{
			if (!is_int($key) || !is_numeric($value))
				throw new \Exception('La série doit être un tableau de clés représentant un timestamp et de valeurs étant un nombre.');
		}*/
		$this->series[$name] = array('data' => $series, 'type' => $type);
	}

	/**
     * {@inheritdoc}
     */
	public function getValues()
	{
		return $this->series;
	}
}
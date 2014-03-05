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
class StackedColumnData implements TypedSeriesDataInterface
{
    /**
     * Le titre de la donnée.
     *
     * @var string
     */
	private $title = '';

    /**
     * Le titre de l'axe des ordonnées.
     *
     * @var string
     */
	private $ytitle = '';

	/**
     * Les séries.
     *
     * @var array
     */
	private $series = array();

    /**
     * Les catégories.
     *
     * @var array
     */
	private $categories = array();

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
     * Récupère le titre de l'axe des ordonnées.
     *
     * @return string Le titre.
     */
	public function getYtitle()
	{
		return $this->ytitle;
	}

	/**
     * Fixe le titre de l'axe des ordonnées.
     *
     * @param string $title Le titre.
     */
	public function setYtitle($yTitle)
	{
		$this->ytitle = $yTitle;
	}

    /**
     * Fixe les catégories de la donnée.
     *
     * @param array $catégories Les catégories.
     */
	public function setCategories(array $categories)
	{
		$this->categories = $categories;
	}

	/**
     * Récupère les catégories
     */
	public function getCategories()
	{
		return $this->categories;
	}

	/**
     * {@inheritdoc}
     */
	public function addSeries($name, array $series, $type)
	{
		foreach ($series as $key => $value)
		{
			if (!is_string($key) || !is_array($value)){
				throw new \Exception('La série doit être un tableau de clés représentant une string et de valeurs étant un array.');
            }
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
}
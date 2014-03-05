<?php

namespace Da\StatBundle\Data;

/**
 * TypedSeriesDefinedData est la classe de données qui gère des séries de données
 * dont les éléments sont définis et dont on peut définir le type de représentation.
 * 
 * Par exemple (key: value): 
 *     série 1: pomme: 2, poire: 3, banane: 7
 *     série 2: pomme: 3, poire: 4, banane: 0
 *
 * @author Thomas Prelot
 */
class TypedSeriesDefinedData implements TypedSeriesDataInterface
{
	/**
     * Les éléments définis.
     *
     * @var array
     */
	private $items = array();

	/**
     * Les séries.
     *
     * @var array
     */
	private $series = array();

	/**
     * Définit les éléments sur lesquels vont porter les valeurs des séries.
     *
     * @param array $items La liste des noms ou valeurs des éléments.
     */
	public function defineItems(array $items)
	{
		foreach ($items as $key => $item)
		{
			if (is_int($key) && (is_string($item) || is_numeric($item)))
				continue;
			throw new \Exception('La variable des éléments doit être un tableau non-associatif de nombres ou de chaînes de caractères.');
		}
		$this->items = array_values($items);
	}

	/**
     * Récupère la liste des éléments.
     *
     * @return array Les éléments.
     */
	public function getItems()
	{
		return $this->items;
	}

	/**
     * {@inheritdoc}
     */
	public function addSeries($name, array $series, $type)
	{
		if (empty($this->items))
			throw new \Exception('Il faut définir les éléments avant d\'ajouter des séries.');
		foreach ($series as $key => $item)
		{
			if (is_int($key) && is_numeric($item))
				continue;
			throw new \Exception('La série doit être un tableau non-associatif de nombres.');
		}
		$series['data'] = array_values($series);
		if (count($series) !== count($this->items))
			throw new \Exception('La série n\'a pas le bon nombre de valeurs qui devrait correspondre au nombre d\'éléments.');
		$series['type'] = $type;
		$this->series[$name] = $series;
	}

	/**
     * {@inheritdoc}
     */
	public function getValues()
	{
		return $this->series;
	}
}
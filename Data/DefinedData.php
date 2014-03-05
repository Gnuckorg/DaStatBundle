<?php

namespace Da\StatBundle\Data;

/**
 * DefinedData est la classe de données qui gère des séries de données
 * dont les éléments sont définis.
 * 
 * Par exemple (key: value):
 *     'pomme': 2, 'poire': 3, 'banane': 7
 *
 * @author Thomas Prelot
 */
class DefinedData implements DataInterface
{
	/**
     * Le nom de la donnée.
     *
     * @var string
     */
	private $name = '';

    /**
     * Le sous-titre de la donnée.
     *
     * @var string
     */
	private $subtitle = '';

    /**
     * Le nombre de décimal après la virgule de la donnée.
     *
     * @var integer
     */
	private $decimalNumber = 0;

    /**
     * Les valeurs.
     *
     * @var array
     */
	private $values = array();

	/**
     * Récupère le nom de la donnée.
     *
     * @return string Le nom.
     */
	public function getName()
	{
		return $this->name;
	}

	/**
     * Fixe le sous-titre de la donnée.
     *
     * @param string $subtitle Le sous-titre.
     */
	public function setSubtitle($subtitle)
	{
		$this->subtitle = $subtitle;
	}

    /**
     * Récupère le sous-titre de la donnée.
     *
     * @return string Le sous-titre.
     */
	public function getSubtitle()
	{
		return $this->subtitle;
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

	/**
     * Fixe le nom de la donnée.
     *
     * @param string $name Le nom.
     */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
     * Fixe les valeurs de la donnée.
     *
     * @param array $values Les valeurs.
     */
	public function setValues(array $values)
	{
        //var_dump($values);die;
		foreach ($values as $key => $value)
		{
			if (is_string($key) && is_numeric($value))
				continue;
			throw new \InvalidArgumentException('Les valeurs doivent être un tableau associatif de nombres.');
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
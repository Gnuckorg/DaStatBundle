<?php

namespace Da\StatBundle\Data;

/**
 * DefinedData est la classe de données qui gère des séries de données
 * dont les éléments sont définis et sont des tableaux associatifs.
 * 
 * Par exemple (key: value):
 *     'pomme': {number: 2, color: red}, 'poire': {number: 3, color: green}, 'banane': {number: 6, color: yellow}
 *
 * @author Thomas Prelot
 */
class AssociativeDefinedData implements DataInterface
{
	/**
     * Le nom de la donnée.
     *
     * @var string
     */
	private $name = '';
    
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
		foreach ($values as $key => $value) {
            if (is_int($key) && is_array($value)) {
                continue;
            } else {
                throw new \InvalidArgumentException('Les valeurs doivent être un tableau associatif de tableaux associatifs.');
            }
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
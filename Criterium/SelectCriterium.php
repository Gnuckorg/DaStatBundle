<?php

namespace Da\StatBundle\Criterium;

/**
 * SelectCriterium est la classe qui permet de représenter
 * les critères de filtrage de type liste déroulante.
 *
 * @author Thomas Prelot
 */
class SelectCriterium implements CriteriumInterface
{
	/**
     * Le nom du critère.
     *
     * @var array
     */
	private $name;

	/**
     * La liste des valeurs du critère.
     *
     * @var array
     */
	private $options = array();

	/**
     * Le constructeur.
     *
     * @param string $name Le nom du critère.
     */
    public function __construct($name)
    {
    	$this->name = $name;
    }

	/**
     * {@inheritdoc}
     */
	public function getCriteriumDescription()
	{
		return array
			(
				'type' => 'select',
				'name' => $this->name,
				'options' => $this->options
			);
	}

	/**
     * Ajoute une option à la liste des options du critère.
     *
     * @param string         $name      Le nom de l'option.
     * @param numeric|string $value     La valeur de l'option.
     * @param boolean        $isDefault Est-ce la valeur par défaut?
     */
    public function addOption($name, $value, $isDefault = false)
    {
        $this->options[] = array('name' => $name, 'value' => $value, 'isDefault' => $isDefault);
        return $this;
    }
}
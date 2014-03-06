<?php

namespace Da\StatBundle\Criterion;

/**
 * SelectCriterion is a criterion of type combobox.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class SelectCriterion implements CriterionInterface
{
    /**
     * The name of the criterion.
     *
     * @var array
     */
    private $name;

    /**
     * The list of values.
     *
     * @var array
     */
    private $options = array();

    /**
     * Constructor.
     *
     * @param string $name The name of the criterion.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriterionDescription()
    {
        return array(
            'type' => 'select',
            'name' => $this->name,
            'options' => $this->options
        );
    }

    /**
     * Add an option to the list of the options.
     *
     * @param string         $name      The name of the option.
     * @param numeric|string $value     The value of the option.
     * @param boolean        $isDefault Is this the default value?
     */
    public function addOption($name, $value, $isDefault = false)
    {
        $this->options[] = array(
            'name' => $name,
            'value' => $value,
            'isDefault' => $isDefault
        );

        return $this;
    }
}
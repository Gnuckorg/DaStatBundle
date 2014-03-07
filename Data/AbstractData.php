<?php

namespace Da\StatBundle\Data;

/**
 * AbstractData is an helper class to define a data class.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
abstract class AbstractData implements DataInterface
{
    /**
     * The options.
     *
     * @var array
     */
    protected $options;

    /**
     * The values.
     *
     * @var array
     */
    protected $values = array();

    /**
     * {@inheritdoc}
     */
    public function getOption($key, $defaultValue = null)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }

        if ($defaultValue instanceof \Exception) {
            throw $defaultValue;
        }

        return $defaultValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value, $key = null)
    {
        $hasAssociativeValues = $this->hasAssociativeValues();

        if (null === $key && $hasAssociativeValues) {
            throw new \InvalidArgumentException('The values of the data should be an associative array of values.');
        } else if (null !== $key && !$hasAssociativeValues) {
            throw new \InvalidArgumentException('The values of the data should be a list of values.');
        }

        $this->checkValue($value);

        if (null === $key) {
            $this->values[] = $value;
        } else {
            $this->values[$key] = $value;
        }
    }

    /**
     * Whether or not the values of the data should be an associative array of values.
     *
     * @return boolean True if the values of the data should be an associative array of values, false otherwise.
     */
    abstract protected function hasAssociativeValues();

    /**
     * Check that a value is valid.
     *
     * @param mixed $value The value to check.
     *
     * @throws \InvalidArgumentException If the value is not valid.
     */
    abstract protected function checkValue($value);

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     */
    public function setValues(array $values)
    {
        $isAssociativeArray = $this->isAssociativeArray($values);

        foreach ($values as $key => $value) {
            if ($isAssociativeArray) {
                $this->setValue($value, $key);
            } else {
                $this->setValue($value);
            }
        }
    }

    /**
     * Whether or not the array is associative.
     *
     * @param array $array The array.
     *
     * @return boolean True if the array is associative, false otherwise.
     */
    protected function isAssociativeArray(array $array) 
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
}
<?php

namespace Da\StatBundle\Data;

/**
 * DataInterface is the interface that a class should implement
 * to be used as an interface of communication between the aggregators
 * and the renderers.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
interface DataInterface
{
    /**
     * Get an option.
     *
     * @param string $key   The key.
     * @param mixed  $value The default value returned if the option does not exist.
     *
     * @return mixed The value.
     */
    function getOption($key, $defaultValue = null);

    /**
     * Set an option.
     *
     * @param string $key   The key.
     * @param mixed  $value The value.
     */
    function setOption($key, $value);

    /**
     * Get the options.
     *
     * @return array The options.
     */
    function getOptions();

    /**
     * Set a value.
     *
     * @param mixed $value The value.
     */
    function setValue($value, $key = null);

    /**
     * Get the values.
     *
     * @return array The values.
     */
    function getValues();

    /**
     * Set the values.
     *
     * @param array $values The values.
     */
    function setValues(array $values);
}
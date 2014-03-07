<?php

namespace Da\StatBundle\Data\Provider;

/**
 * AbstractDataProvider is an helper class to define a provider 
 * for a type of data class.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
abstract class AbstractDataProvider implements DataProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $data = new $this->getDataClassName();

        return $this->check($data);
    }

    /**
     * Get the class name of the data.
     *
     * @return string The class name of the data.
     */
    abstract protected function getDataClassName();

    /**
     * Check the data.
     *
     * @param DataInterface $data The data.
     *
     * @throws \InvalidArgumentException If the data is not valid.
     */
    protected function check(DataInterface $data)
    {
        return $data;
    }
}
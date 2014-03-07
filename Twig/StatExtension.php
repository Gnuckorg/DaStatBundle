<?php

namespace Da\StatBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * StatExtension is the Twig extention for the mechanism of the statistics.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class StatExtension extends \Twig_Extension
{
    /**
     * The dependency injection container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The dependency injection container.
     */
    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    /**
     * Get the displayer.
     *
     * @return StatDisplayerInterface The displayer.
     */
    public function getDisplayer()
    {
        return $this->container->get('da_stat.displayer');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'da_stat';
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array('da' => array('stat' => $this->getDisplayer()));
    }
}
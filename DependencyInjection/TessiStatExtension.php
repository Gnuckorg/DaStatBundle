<?php

namespace Da\StatBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class DaStatExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $statConfig = array();
        if (isset($config['stat']))
            $statConfig = $config['stat'];
        $container->setParameter('da.stat.config.stat', $statConfig);

        $assembliesConfig = array();
        if (isset($config['assemblies']))
            $assembliesConfig = $config['assemblies'];
        $container->setParameter('da.stat.config.assemblies', $assembliesConfig);

        $menuConfig = array('items' => array());
        if (isset($config['menu']))
            $menuConfig = $config['menu'];
        $container->setParameter('da.stat.config.menu', $menuConfig);
    }
}

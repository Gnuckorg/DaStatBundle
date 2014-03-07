<?php

namespace Da\StatBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
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
        $loader->load('renderers.yml');
        $loader->load('data_providers.yml');

        $container->setParameter('da_stat.stat', $config['stat']);
        $container->setParameter('da_stat.assemblies', $config['assemblies']);
        $container->setParameter('da_stat.menu', $config['menu']);
    }
}
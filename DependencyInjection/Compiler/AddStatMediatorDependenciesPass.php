<?php

namespace Da\StatBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Inject the dependencies of the stat mediator.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class AddStatMediatorDependenciesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('da_stat.mediator'))
            return;

        $definition = $container->getDefinition('da_stat.mediator');

        // Injection of the aggregators.
        $taggedServices = $container->findTaggedServiceIds('da_stat.aggregator');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addAggregator',
                    array(new Reference($id), $attributes['id'])
                );
            }
        }

        // Injection of the renderers.
        $taggedServices = $container->findTaggedServiceIds('da_stat.renderer');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addRenderer',
                    array(new Reference($id), $attributes['id'])
                );
            }
        }

        // Injection of the filters.
        $taggedServices = $container->findTaggedServiceIds('da_stat.filter');

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'addFilter',
                    array(new Reference($id), $attributes['id'])
                );
            }
        }
    }
}
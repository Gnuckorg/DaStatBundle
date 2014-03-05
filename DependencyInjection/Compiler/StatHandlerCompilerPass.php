<?php

namespace Da\StatBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class StatHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('da.stat.handler'))
            return;

        $definition = $container->getDefinition('da.stat.handler');

        // Inscription des aggrégateurs dans le gestionnaire des statistiques.
        $taggedServices = $container->findTaggedServiceIds('da.stat.aggregator');
        foreach ($taggedServices as $id => $tagAttributes) 
        {
            foreach ($tagAttributes as $attributes) 
            {
                $definition->addMethodCall
                (
                    'addAggregator',
                    array(new Reference($id), $id)
                );
            }
        }

        // Inscription des gestionnaires de rendu dans le gestionnaire des statistiques.
        $taggedServices = $container->findTaggedServiceIds('da.stat.renderer');
        foreach ($taggedServices as $id => $tagAttributes) 
        {
            foreach ($tagAttributes as $attributes) 
            {
                $definition->addMethodCall
                (
                    'addRenderer',
                    array(new Reference($id), $id)
                );
            }
        }

        // Inscription des filtres dans le gestionnaire des statistiques.
        $taggedServices = $container->findTaggedServiceIds('da.stat.filter');
        foreach ($taggedServices as $id => $tagAttributes) 
        {
            foreach ($tagAttributes as $attributes) 
            {
                $definition->addMethodCall
                (
                    'addFilter',
                    array(new Reference($id), $id)
                );
            }
        }
    }
}
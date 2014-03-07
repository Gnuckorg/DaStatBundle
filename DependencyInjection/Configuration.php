<?php

namespace Da\StatBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * @author Thomas Prelot <thomas.prelot@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('da_stat');

        $this->addStatSection($rootNode);
        $this->addAssembliesSection($rootNode);
        $this->addMenuSection($rootNode);

        return $treeBuilder;
    }

    /**
     * stat:
     *     {stat_name}:
     *         roles:
     *             _default: [{role_name1}, {role_name2}]
     *             {client_name}: [{role_name1}]
     *         aggregator: {aggregator_service_id}
     *         renderer: {renderer_service_id}
     *         filter: {filter_service_id}
     */
    private function addStatSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('stat')
                    ->useAttributeAsKey('dumb')
                    ->defaultValue(array())
                        ->prototype('array')
                            ->children()
                                ->scalarNode('aggregator')
                                    ->isRequired(true)
                                ->end()
                                ->scalarNode('renderer')
                                    ->isRequired(true)
                                ->end()
                                ->scalarNode('filter')->end()
                                ->arrayNode('roles')
                                    ->isRequired(true)
                                    ->useAttributeAsKey('dumb')
                                    ->prototype('array')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('labels')
                                    ->isRequired(true)
                                    ->children()
                                        ->scalarNode('title')
                                            ->isRequired(true)
                                        ->end()
                                        ->scalarNode('xAxis')->end()
                                        ->scalarNode('yAxis')->end()
                                        ->scalarNode('legend')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * assemblies:
     *     {stat_name}: [{stat_name1}, {stat_name2}]
     */
    private function addAssembliesSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('assemblies')
                ->useAttributeAsKey('dumb')
                ->defaultValue(array())
                    ->prototype('array')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * menu:
     *     items:
     *         {menu_name}:
     *             stat: {stat_name}
     *             category: stat
     */
    private function addMenuSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('menu')
                    ->defaultValue(array())
                    ->children()
                        ->arrayNode('items')
                            ->useAttributeAsKey('dumb')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('stat')
                                        ->isRequired(true)
                                    ->end()
                                    ->scalarNode('category')
                                        ->isRequired(true)
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
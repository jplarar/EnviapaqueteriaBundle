<?php

namespace Jplarar\EnviapaqueteriaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jplarar_enviapaqueteria');

        $rootNode
            ->children()
                ->arrayNode('enviapaqueteria_keys')
                    ->children()
                        ->scalarNode('enviapaqueteria_user')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('enviapaqueteria_password')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('enviapaqueteria_environment')
                            ->defaultValue(null)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

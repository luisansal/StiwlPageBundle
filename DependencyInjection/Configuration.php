<?php

/**
 * @author Luis Sanchez <luis.sanchez.saldana@gmail.com>
 */

namespace Stiwl\PageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('stiwl_page');

        $rootNode
                ->children()
                    ->scalarNode('developer')->defaultValue('stiwl')->end()
                    ->scalarNode('website')->defaultValue('http://www.stiwl.com')->end()
                    ->scalarNode('project')->defaultValue('STIWL Page')->end()
                    ->arrayNode('enterprise')
                        ->children()
                            ->scalarNode('name')->defaultValue('Pharmacy S.A.C')->end()
                            ->scalarNode('short_name')->defaultValue('pharmacy')->end()
                            ->scalarNode('business')->defaultValue('Pharmaceutical products')->end()
                            ->scalarNode('slogan')->defaultValue('Quality and reliability')->end()
                            ->scalarNode('money')->defaultValue('$')->end()
                            ->scalarNode('email')->defaultValue('luis.sanchez.saldana@gmail.com')->end()
                            ->scalarNode('address')->defaultValue('Av. xxx #xxx')->end()
                            ->arrayNode('phones')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('value')->isRequired()->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('google_map')
                                ->children()
                                    ->scalarNode('latitude')->defaultValue('-12.09223')->end()
                                    ->scalarNode('longitude')->defaultValue('-77.00050')->end()
                                    ->scalarNode('width')->defaultValue('300px')->end()
                                    ->scalarNode('height')->defaultValue('300px')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('pages')
                        ->children()
                            ->arrayNode('news')
                                ->children()
                                    ->booleanNode('enabled')->defaultValue(true)->end()
                                    ->scalarNode('position')->defaultValue(0)->end()
                                ->end()
                            ->end()
                            ->arrayNode('contact_us')
                                ->children()
                                    ->booleanNode('enabled')->defaultValue(true)->end()
                                    ->scalarNode('position')->defaultValue(1)->end()
                                ->end()
                            ->end()
                            ->arrayNode('products')
                                ->children()
                                    ->booleanNode('enabled')->defaultValue(true)->end()
                                    ->scalarNode('position')->defaultValue(2)->end()
                                ->end()
                            ->end()             
                            ->arrayNode('fos_user')
                            ->children()
                                ->arrayNode('login')
                                    ->children()
                                        ->booleanNode('visible')->defaultValue(false)->end()
                                        ->scalarNode('position')->defaultValue(3)->end()
                                    ->end()
                                ->end()
                                ->arrayNode('register')
                                    ->children()
                                        ->booleanNode('enabled')->defaultValue(true)->end()
                                        ->scalarNode('position')->defaultValue('last')->end()
                                    ->end()
                                ->end()
                             ->end()
                        ->end()
                        ->end()
                    ->end()
                ->end();


        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }

}

<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/8
 * Time: 21:32
 */

namespace Ming\Bundles\SwaggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('swagger');

        $rootNode
            ->children()
                ->scalarNode('template_path')
                    ->defaultValue(dirname(__DIR__).'/Resources/view/swagger.html')
                ->end()
                ->arrayNode('paths')
                    ->prototype('scalar')
                        ->validate()
                            ->ifTrue(function($v){
                                return !glob($v);
                            })
                            ->thenInvalid('path %s must be a readable file or readable dir.')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('groups')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('template_path')->end()
                            ->arrayNode('paths')->isRequired()
                                ->prototype('scalar')
                                    ->validate()
                                        ->ifTrue(function($v){
                                            return !glob($v);
                                        })
                                        ->thenInvalid('paths element must be a file or dir')
                                    ->end()
                                ->end()
                            ->end();


        return $treeBuilder;
    }
}
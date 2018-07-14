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
        $defaultTemplatePath = dirname(__DIR__).'/Resources/view/swagger.html';
        $rootNode
            ->children()
                ->scalarNode('type')
                    ->defaultValue('yaml')
                    ->validate()
                        ->ifNotInArray(array('json', 'yaml'))
                        ->thenInvalid('The type of swagger config file has to be json or yaml,default to yaml')
                    ->end()
                ->end()
                ->scalarNode('template_path')
                    ->defaultValue($defaultTemplatePath)
                ->end()
                ->arrayNode('paths')
                    ->isRequired()
                    ->prototype('scalar')
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }

}
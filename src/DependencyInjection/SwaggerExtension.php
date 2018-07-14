<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 16:36
 */

namespace Ming\Bundles\SwaggerBundle\DependencyInjection;

use Ming\Bundles\SwaggerBundle\Controller\SwaggerController;
use Ming\Bundles\SwaggerBundle\Loader\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SwaggerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $container->setParameter('swagger.type', $config['type']);
        $container->setParameter('swagger.paths', $config['paths']);
        $container->setParameter('swagger.template_path', $config['template_path']);

        $definition = new Definition();
        $definition->setClass(Loader::class)
            ->addArgument($config['type'])
            ->addArgument($config['paths']);

        $container->setDefinition(Loader::class, $definition);

        $definition = new Definition();
        $definition->setClass(SwaggerController::class)
            ->addArgument(new Reference(Loader::class))
            ->setPublic(true);

        $container->setDefinition('swagger.controller', $definition);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 16:36
 */

namespace Ming\Bundles\SwaggerBundle\DependencyInjection;

use Ming\Bundles\SwaggerBundle\Controller\SwaggerController;
use Ming\Bundles\SwaggerBundle\Swagger\Swagger;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SwaggerExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);
        $groups        = $config['groups'];
        if ($config['paths']) {
            $groups['default'] = ['paths' => $config['paths']];
        }
        $flag = false;
        foreach ($groups as $name => $group) {
            $definition = new Definition();
            $definition->setClass(Swagger::class)
                ->addArgument($name)
                ->addArgument($group['paths'])
                ->addArgument($group['template_path'] ?? $config['template_path'])
                ->setPublic(true);

            $container->setDefinition('swagger.' . $name, $definition);
            if ($flag === false && !isset($groups['default'])) {
                $container->setAlias('swagger.default', new Alias('swagger.' . $name, true));
            }
        }
        $definition = new Definition(SwaggerController::class);

        $definition->setPublic(true);
        $container->setDefinition('swagger.controller', $definition);
    }

}
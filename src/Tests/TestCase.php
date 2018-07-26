<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 19:33
 */

namespace Ming\Bundles\SwaggerBundle\Tests;

use Ming\Bundles\SwaggerBundle\DependencyInjection\SwaggerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function getContainer()
    {
        $container = new ContainerBuilder();
        $loader    = new SwaggerExtension();
        $config    = [
            'swagger' => [
                'paths'  => [
                    __DIR__ . '/DependencyInjection/demo.json'
                ],
                'groups' => [
                    [

                        'name'  => 'main',
                        'paths' => [
                            __DIR__ . '/DependencyInjection/demo.json',
                            __DIR__ . '/DependencyInjection/demo2.json'
                        ],
                    ]
                ]
            ]
        ];
        $loader->load($config, $container);

        return $container;
    }

}
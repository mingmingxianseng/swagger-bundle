<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 17:17
 */

namespace Ming\Bundles\SwaggerBundle\Tests\DependencyInjection;

use Ming\Bundles\SwaggerBundle\DependencyInjection\Configuration;
use Ming\Bundles\SwaggerBundle\DependencyInjection\SwaggerExtension;
use Ming\Bundles\SwaggerBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigurationTest extends TestCase
{

    public function testConfiguration()
    {
        $processor = new Processor();
        $configs   = [
            'swagger' => [
                'paths'  => [
                    __DIR__ . '/demo.json'
                ],
                'groups' => [
                    [
                        'name'  => 'sss',
                        'paths' => [
                            __DIR__ . '/demo.json'
                        ]
                    ]
                ]
            ]
        ];

        $configs = $processor->processConfiguration(new Configuration(), $configs);

        $this->assertArrayHasKey('paths', $configs);
        $this->assertArrayHasKey('groups', $configs);
    }

    public function testConfiguration2()
    {
        $processor = new Processor();
        $configs   = [
            'swagger' => [
                'groups' => [
                    [
                        'name'  => 'sss',
                        'paths' => [
                            __DIR__ . '/demo.json'
                        ]
                    ],
                    'ddd' => [
                        'paths' => [
                            __DIR__ . '/demo.json'
                        ]
                    ]
                ]
            ]
        ];

        $configs = $processor->processConfiguration(new Configuration(), $configs);

        $this->assertArrayHasKey('groups', $configs);
        $this->assertSame([], $configs['paths']);
    }

    public function testAlias()
    {

        $container = $this->getContainer();

        $def  = $container->findDefinition('swagger.default');
        $def2 = $container->findDefinition('swagger.main');

        $this->assertSame('main', $def2->getArgument(0));
        $this->assertSame('default', $def->getArgument(0));
        $this->assertTrue($container->hasDefinition('swagger.default'));
    }

    public function test2()
    {

        $container = new ContainerBuilder();
        $loader    = new SwaggerExtension();
        $config    = [
            'swagger' => [
                'groups' => [
                    [
                        'name'  => 'main',
                        'paths' => [
                            __DIR__ . '/demo.json',
                            __DIR__ . '/demo2.json'
                        ],
                    ],
                    [
                        'name'  => 'admin',
                        'paths' => [
                            __DIR__ . '/demo.json',
                            __DIR__ . '/demo2.json'
                        ],
                    ],
                ]
            ]
        ];
        $loader->load($config, $container);

        $def  = $container->findDefinition('swagger.default');
        $def2 = $container->findDefinition('swagger.main');
        $def3 = $container->findDefinition('swagger.admin');

        $this->assertSame($def->getArguments(), $def2->getArguments());

        $this->assertSame('admin', $def3->getArgument(0));
        $this->assertSame('main', $def2->getArgument(0));
        $this->assertSame('main', $def->getArgument(0));

        $this->assertTrue($container->hasAlias('swagger.default'));
    }
}
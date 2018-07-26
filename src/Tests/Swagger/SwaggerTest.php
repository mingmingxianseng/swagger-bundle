<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/26
 * Time: 10:38
 */

namespace Ming\Bundles\SwaggerBundle\Tests\Swagger;

use Ming\Bundles\SwaggerBundle\Swagger\Swagger;
use Ming\Bundles\SwaggerBundle\Tests\TestCase;

class SwaggerTest extends TestCase
{
    public function testCreate()
    {
        $paths   = [
            dirname(__DIR__) . '/DependencyInjection/demo.json',
            dirname(__DIR__) . '/DependencyInjection/demo2.json',
        ];
        $swagger = new Swagger(
            'ddd', $paths, '111'
        );

        $config = $swagger->getData();
        $this->assertArrayHasKey('schemes', $config);

        $this->assertSame('ddd', $swagger->getName());
        $this->assertSame($paths, $swagger->getPaths());
        $this->assertSame('111', $swagger->getTemplatePath());
    }
}
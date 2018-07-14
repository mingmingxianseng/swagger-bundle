<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 17:17
 */

namespace Ming\Bundles\SwaggerBundle\Tests\DependencyInjection;

use Ming\Bundles\SwaggerBundle\Controller\SwaggerController;
use Ming\Bundles\SwaggerBundle\Loader\Loader;
use Ming\Bundles\SwaggerBundle\Tests\TestCase;
use Symfony\Component\Yaml\Yaml;

class ConfigurationTest extends TestCase
{

    public function testCase()
    {
        $container = $this->getContainer();
        $this->assertTrue($container->hasDefinition(Loader::class));
        $this->assertTrue($container->hasDefinition(SwaggerController::class));

        $expected = dirname(dirname(__DIR__)).'/Resources/view/swagger.html';
        $this->assertSame($expected
            , $container->getParameter('swagger.template_path')
        );
    }

    /**
     * testJson
     *
     * @author  chenmingming
     * @throws \Exception
     */
    public function testJson()
    {
        $container  = $this->getContainer();
        $definition = $container->findDefinition(Loader::class);
        $definition->setPublic(true)
            ->setArgument(0, 'json')
            ->setArgument(1, [__DIR__ . '/demo.json']);

        $loader   = $container->get(Loader::class);
        $config   = $loader->load();
        $content  = file_get_contents(__DIR__ . '/demo.json');
        $expected = json_encode(json_decode($content, true));
        $this->assertSame($expected, json_encode($config));
    }

    /**
     * testJson
     *
     * @author  chenmingming
     * @throws \Exception
     */
    public function testInvalidJson()
    {
        $container  = $this->getContainer();
        $definition = $container->findDefinition(Loader::class);
        $definition->setPublic(true)
            ->setArgument(0, 'json')
            ->setArgument(
                1, [
                     __DIR__ . '/error.json'
                 ]
            );

        $loader = $container->get(Loader::class);
        $this->expectException(\InvalidArgumentException::class);
        $loader->load();
    }

    /**
     * testYaml
     *
     * @author  chenmingming
     *
     * @throws \Exception
     */
    public function testYaml()
    {
        $container  = $this->getContainer();
        $definition = $container->findDefinition(Loader::class);
        $definition->setPublic(true)
            ->setArgument(0, 'yaml')
            ->setArgument(1,[__DIR__.'/*']);

        $loader  = $container->get(Loader::class);
        $config  = $loader->load();
        $content = file_get_contents(__DIR__ . '/demo.yaml');

        $expected = json_encode(Yaml::parse($content));
        $this->assertSame($expected, json_encode($config));
    }
}
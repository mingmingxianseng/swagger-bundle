<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 19:32
 */

namespace Ming\Bundles\SwaggerBundle\Tests\Controller;

use Ming\Bundles\SwaggerBundle\Controller\SwaggerController;
use Ming\Bundles\SwaggerBundle\Tests\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SwaggerControllerTest extends TestCase
{
    public function testSwagger()
    {
        $container = $this->getContainer();

        $container->findDefinition(SwaggerController::class)
            ->setPublic(true);
        $container->setParameter('kernel.root_dir',dirname(dirname(dirname(__DIR__))));
        $container->compile();
        $controller = $container->get(SwaggerController::class);
        $controller->setContainer($container);
        $res = $controller->swaggerHtmlAction();

        $this->assertInstanceOf(Response::class, $res);
    }

    public function testSwaggerConfig(){
        $container = $this->getContainer();
        $container->findDefinition(SwaggerController::class)
            ->setPublic(true);
        $controller = $container->get(SwaggerController::class);
        $controller->setContainer($container);

        $res = $controller->swaggerConfigAction();

        $this->assertInstanceOf(JsonResponse::class, $res);

        $data = file_get_contents(dirname(__DIR__).'/DependencyInjection/demo.json');
        $json = json_encode(json_decode($data,true));
        $this->assertSame($json,$res->getContent());

    }
}
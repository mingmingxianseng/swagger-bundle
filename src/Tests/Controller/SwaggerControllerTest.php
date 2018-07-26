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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SwaggerControllerTest extends TestCase
{
    public function testSwagger()
    {
        $container = $this->getContainer();

        $container->setParameter('kernel.root_dir', dirname(dirname(dirname(__DIR__))));
        $container->compile();
        /** @var SwaggerController $controller */
        $controller = $container->get('swagger.controller');
        $controller->setContainer($container);

        $request = new Request(['group' => 'main']);
        $res     = $controller->swaggerHtmlAction($request);

        $this->assertInstanceOf(Response::class, $res);
        $this->assertTrue(strpos($res->getContent(), 'swagger.json?group=main') > 0);

        $request = new Request(['group' => 'aasss']);
        $res     = $controller->swaggerHtmlAction($request);

        $this->assertTrue(strpos($res->getContent(), 'swagger.json?group=aasss') <= 0);

    }

    public function testSwaggerConfig()
    {
        $container = $this->getContainer();
        /** @var SwaggerController $controller */
        $controller = $container->get('swagger.controller');
        $controller->setContainer($container);

        $res = $controller->swaggerConfigAction(new Request(['group' => 'main']));

        $this->assertInstanceOf(JsonResponse::class, $res);

        $this->assertSame('{"swagger":2,"paths":{"\/api\/test":[],"\/api\/test2":[]},"schemes":["http","https"]}', $res->getContent());

    }
}
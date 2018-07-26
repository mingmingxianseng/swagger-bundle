<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/10
 * Time: 13:31
 */

namespace Ming\Bundles\SwaggerBundle\Controller;

use Ming\Bundles\SwaggerBundle\Swagger\Swagger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SwaggerController extends Controller
{
    /**
     * swaggerHtmlAction
     *
     * @author chenmingming
     *
     *
     * @param Request $request
     *
     * @return Response
     */
    public function swaggerHtmlAction(Request $request)
    {
        /** @var Swagger $swagger */
        $swagger = $this->getSwagger($request->query->get('group', 'default'));

        $content     = file_get_contents($swagger->getTemplatePath());
        $replacement = './swagger.json';

        if ($request->query->has('group')) {
            $replacement .= '?group=' . $request->query->get('group');
        }

        return new Response(str_replace("__URL__", $replacement, $content));
    }

    /**
     * swaggerConfigAction
     *
     * @author chenmingming
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function swaggerConfigAction(Request $request)
    {
        /** @var Swagger $swagger */
        $swagger = $this->getSwagger($request->query->get('group', 'default'));

        return new JsonResponse($swagger->getData());
    }

    /**
     * getSwagger
     *
     * @author chenmingming
     *
     * @param $group
     *
     * @return Swagger
     */
    private function getSwagger($group)
    {
        $serviceName = 'swagger.' . $group;

        if (!$this->has($serviceName)) {
            $serviceName = 'swagger.default';
        }

        /** @var Swagger $swagger */
        $swagger = $this->get($serviceName);

        return $swagger;
    }
}
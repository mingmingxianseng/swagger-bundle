<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/10
 * Time: 13:31
 */

namespace Ming\Bundles\SwaggerBundle\Controller;

use Ming\Bundles\SwaggerBundle\Loader\Loader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SwaggerController extends Controller
{
    /**
     * @var Loader
     */
    private $loader;

    public function __construct(Loader $loader)
    {

        $this->loader = $loader;
    }

    /**
     * swaggerHtmlAction
     *
     * @author chenmingming
     *
     *
     * @return Response
     */
    public function swaggerHtmlAction()
    {
        $templatePath = $this->getParameter('swagger.template_path');
        if (!is_file($templatePath) || !is_readable($templatePath)) {
            throw new BadRequestHttpException("swagger 模板文件缺失".$templatePath);
        }

        return new Response(file_get_contents($templatePath));
    }

    /**
     * swaggerConfigAction
     * @author chenmingming
     * @return JsonResponse
     */
    public function swaggerConfigAction()
    {
        return new JsonResponse($this->loader->load());
    }
}
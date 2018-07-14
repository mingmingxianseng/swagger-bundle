<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 16:57
 */

namespace Ming\Bundles\SwaggerBundle\Loader;

interface LoaderInterface
{
    public function getType(): string;

    /**
     * parseFile
     *
     * @author chenmingming
     *
     * @param $file
     *
     * @return array
     */
    public function parseFile($file): array;
}
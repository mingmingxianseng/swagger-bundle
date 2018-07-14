<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 16:57
 */

namespace Ming\Bundles\SwaggerBundle\Loader;

class JsonLoader implements LoaderInterface
{
    public function getType(): string
    {
        return 'json';
    }

    public function parseFile($file): array
    {
        $content = file_get_contents($file);
        $config  = json_decode($content, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        return $config;
    }

}
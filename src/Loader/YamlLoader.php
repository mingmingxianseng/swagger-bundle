<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 17:02
 */

namespace Ming\Bundles\SwaggerBundle\Loader;

use Symfony\Component\Yaml\Yaml;

class YamlLoader implements LoaderInterface
{
    public function getType(): string
    {
        return 'yaml';
    }

    public function parseFile($file): array
    {
        return  Yaml::parseFile($file);
    }

}
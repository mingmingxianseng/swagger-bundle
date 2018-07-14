<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/13
 * Time: 16:52
 */

namespace Ming\Bundles\SwaggerBundle\Loader;

class Loader
{
    /**
     * @var LoaderInterface
     */
    private $loader;
    private $paths = [];

    public function __construct(string $type, array $paths)
    {
        $this->paths = $paths;
        if ($type === 'yaml') {
            $this->loader = new YamlLoader();
        } else {
            $this->loader = new JsonLoader();
        }

    }

    /**
     * load
     *
     * @author chenmingming
     * @return array
     */
    public function load()
    {
        $config = [];
        foreach ($this->paths as $path) {
            if (substr($path, -5) !== '.' . $this->loader->getType()) {
                $path .= '.' . $this->loader->getType();
            }
            $files = glob($path);
            foreach ($files as $file) {
                $content = $this->loader->parseFile($file);
                $config  = array_merge_recursive($config, $content);
            }
        }

        return $config;
    }
}
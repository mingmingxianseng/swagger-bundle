<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2018/7/26
 * Time: 10:15
 */

namespace Ming\Bundles\SwaggerBundle\Swagger;

use Symfony\Component\Yaml\Yaml;

class Swagger
{
    /**
     * @var string
     */
    private $templatePath;
    /**
     * @var array
     */
    private $paths = [];
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name, array $paths, string $templatePath)
    {
        $this->name         = $name;
        $this->paths        = $paths;
        $this->templatePath = $templatePath;
    }

    /**
     * @return string
     */
    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    /**
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * getData
     *
     * @author chenmingming
     * @return array
     */
    public function getData()
    {
        $config = [];
        foreach ($this->paths as $path) {
            foreach (glob($path) as $file) {
                $tmp    = explode('.', $file);
                $suffix = end($tmp);
                switch ($suffix) {
                case 'yaml':
                case 'yml':
                    $content = $this->parseYamlFile($file);
                    break;
                case 'json':
                    $content = $this->parseJsonFile($file);
                    break;
                default:
                    throw new \InvalidArgumentException("can't load this file type.");
                }
                $config = $this->merge($config, $content);
            }

        }

        return $config;
    }

    /**
     * parseJsonFile
     *
     * @author chenmingming
     *
     * @param $file
     *
     * @return array
     */
    private function parseJsonFile($file)
    {
        $content = file_get_contents($file);
        $config  = json_decode($content, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        return $config;
    }

    /**
     * parseYamlFile
     *
     * @author chenmingming
     *
     * @param $file
     *
     * @return array
     */
    private function parseYamlFile($file)
    {
        return Yaml::parseFile($file);
    }

    /**
     * merge
     *
     * @author chenmingming
     *
     * @param $a1
     * @param $a2
     *
     * @return array
     */
    private function merge($a1, $a2)
    {
        foreach ($a1 as $k => $v) {
            isset($a2[$k]) && is_array($a2[$k]) && is_array($v) && $a[$k] = array_merge($v, $a2[$k]);
        }
        foreach ($a2 as $k => $v) {
            // 新字段
            if (!isset($a1[$k])) {
                $a1[$k] = $v;
                continue;
            }
            if (is_array($v) && is_array($a1[$k])) {
                $a1[$k] = array_merge($a1[$k], $v);
                if (array_values($v) === $v) {
                    $a1[$k] = array_values(array_unique($a1[$k], SORT_REGULAR));
                }
            }
        }

        return $a1;
    }
}
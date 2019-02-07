<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 07.12.18
 * Time: 19:50
 */

namespace A12\Modules\Config;


use A12\Interfaces\Configuration\ConfigProviderInterface;

class ConfigProvider implements ConfigProviderInterface
{
    private $vars;
    
    public function __construct(array $vars)
    {
        $this->vars = $vars;
    }
    
    /**
     * @param $key
     * @return mixed
     * @throws ConfigurationException
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->vars)) {
            return $this->vars[$key];
        }
    
        return $this->errorKeyNotFound($key);
    }
    
    /**
     * @param $key
     * @throws ConfigurationException
     */
    private function errorKeyNotFound($key)
    {
        throw new ConfigurationException("Config key [{$key}] not found");
    }
}
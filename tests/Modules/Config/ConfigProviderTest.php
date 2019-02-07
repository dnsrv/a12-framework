<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 11.12.18
 * Time: 16:38
 */

namespace A12\Tests\Modules\Config;

use A12\Interfaces\Configuration\ConfigProviderInterface;
use A12\Modules\Config\ConfigProvider;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    public function testGet()
    {
        $provider = new ConfigProvider([
            'key1' => 'value1',
            'key2' => 'value2'
        ]);
        
        self::assertEquals($provider->get('key1'), 'value1');
        self::assertEquals($provider->get('unknown', 'def'), 'def');
        
        return $provider;
    }
    
    /**
     * @depends testGet
     */
    public function testBind(ConfigProviderInterface $provider)
    {
        $newInstance = $provider->bind([
            'key1' => 'val1',
            'key3' => 'val3'
        ]);
        
        // ------- ------- -------
        self::assertInstanceOf(ConfigProviderInterface::class, $newInstance);
        // is new instance
        self::assertNotEquals($newInstance->get('key1'), $provider->get('key1'));
        //
        self::assertEquals($newInstance->get('key1'), 'val1');
        self::assertEquals($newInstance->get('key2'), 'value2');
    }
}

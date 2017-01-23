<?php

namespace Utils;

/*
 *  @class          Cache
 *  @author         Anton Morozov
 *  @email          anton@webbylab.com
 *  @description    this class need for caching other data. Work like abstract factory. Default
 *                  empty usege empty class for caching emulation
 */
define('LONG_EXPIRATION_TIME', 60 * 60);        //  1 h.
define('MIDDLE_EXPIRATION_TIME', 20 * 60);      // 20 min
define('SHOT_EXPIRATION_TIME', 1 * 60);         //  1 min

class Cache
{
    const DEFAULT_EXPIRATION = MIDDLE_EXPIRATION_TIME;

    private static $cacheBackend;

    public function getResultCode()
    {
        return $this->getBackend()->getResultCode();
    }

    public function getResultStatus()
    {
        return class_exists('Memcached')
            ? ($this->getBackend()->getResultCode() == \Memcached::RES_SUCCESS)
            : false;
    }

    public function get($key)
    {
        return $this->getBackend()->get($key);
    }

    public function set($key, $val, $exp = self::DEFAULT_EXPIRATION)
    {
        return $this->getBackend()->set($key, $val, $exp);
    }

    public function delete($key)
    {
        return $this->getBackend()->delete($key);
    }

    public function flush()
    {
        return $this->getBackend()->flush();
    }

    protected function getBackend()
    {
        if (self::$cacheBackend === null) {
            $conf = include __DIR__ . '/../../etc/app-conf.php';
            $cacheConfig = $conf['cacheConfig'];

            if ($cacheConfig['cacheSystem'] == 'memcached') {
                $MC = new \Memcached();
                $MC->addServer($cacheConfig['memcachedHost'], $cacheConfig['memcachedPort']);
                self::$cacheBackend = $MC;
            } else {
                self::$cacheBackend = new EmptyCacheSystem();
            }
        }

        return self::$cacheBackend;
    }
}

<?php

namespace Utils;

/*
 *  @class          EmptyCacheSystem
 *  @description    Need for caching emulation
 */
class EmptyCacheSystem
{
    public function get($k)
    {
        return false;
    }
    public function set($k, $v, $e)
    {
        return true;
    }
    public function delete($k)
    {
        return true;
    }
    public function flush()
    {
        return true;
    }
    public function getResultCode()
    {
        return 99999;
    }
    public function getResultStatus()
    {
        return false;
    }
}

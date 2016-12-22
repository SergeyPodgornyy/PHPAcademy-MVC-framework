<?php

namespace Service;

use Service\Traits\Helpers;

abstract class Base
{
    use Helpers;

    private $config;
    private $userId;

    public function __construct(array $attrs = [])
    {
        if (isset($attrs['config'])) {
            $this->config = $attrs['config'];
        }
        if (isset($attrs['UserId'])) {
            $this->userId = $attrs['UserId'];
        }
    }

    protected function config()
    {
        return $this->config;
    }

    protected function userId()
    {
        return $this->userId;
    }

    final public function run($params = [])
    {
        try {
            $validated = $this->validate($params);
            $result = $this->execute($validated);

            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

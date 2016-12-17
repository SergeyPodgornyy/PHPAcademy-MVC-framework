<?php

namespace Model\Utils;

class Functions
{
    public static function pluck(array $oldElement, $keys)
    {
        $newElement = [];

        if (is_array($keys)) {
            foreach ($keys as $key) {
                $newElement[$key] = $oldElement[$key];
            }
        } else {
            $newElement = $oldElement[$keys];
        }

        return $newElement;
    }

    public static function pluckArray(array $oldElements, $keys)
    {
        return array_map(function ($oldElement) use ($keys) {
            return self::pluck($oldElement, $keys);
        }, $oldElements);
    }
}

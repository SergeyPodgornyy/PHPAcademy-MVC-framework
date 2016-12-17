<?php

namespace Model;

interface ModelInterface
{
    public static function getConnection();
    public static function create($data);
}

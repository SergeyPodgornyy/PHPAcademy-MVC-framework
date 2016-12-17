<?php

namespace Service\Traits;

trait Helpers
{
    protected function defaultParams(array $params, $field)
    {
        return array_merge([
            'Search'    => '',

            'Limit'     => 10,
            'Offset'    => 0,

            'SortField' => $field,
            'SortOrder' => 'asc'
        ], $params);
    }
}

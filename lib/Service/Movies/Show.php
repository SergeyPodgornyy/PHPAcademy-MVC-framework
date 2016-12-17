<?php

namespace Service\Movie;

class Show extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        return $params;
    }
}

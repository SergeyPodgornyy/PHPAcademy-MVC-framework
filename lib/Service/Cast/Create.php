<?php

namespace Service\Cast;

class Create extends \Service\Base
{
    public function validate($params)
    {
        $rules = [
            'Name'      => ['required', ['max_length' => 255]],
            'Surname'   => ['required', ['max_length' => 255]],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params += [
            'Name'      => '',
            'Surname'   => '',
        ];

        $castId = \Model\Cast::create($params);

        return [
            'Status'   => 1,
            'CastId'   => $castId,
        ];
    }
}

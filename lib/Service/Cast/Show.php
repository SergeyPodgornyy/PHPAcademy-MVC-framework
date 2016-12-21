<?php

namespace Service\Cast;

class Show extends \Service\Base
{
    public function validate($params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $cast = \Model\Cast::findById($params['Id']);

        if (!$cast) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cast does not exists'
            ]);
        }

        return [
            'Status'    => 1,
            'Cast'      => $cast,
        ];
    }
}

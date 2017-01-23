<?php

namespace Service\Music;

use Model\Music;
use Service\Base;
use Service\Validator;
use Service\X;

class Show extends Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'    => ['required', 'positive_integer'],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $music = Music::selectOne(['Id' => $params['Id'], 'Locale' => $this->locale()]);

        if (!$music) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Music item does not exists'
            ]);
        }

        return [
            'Status'    => 1,
            'Music'     => $music,
        ];
    }
}

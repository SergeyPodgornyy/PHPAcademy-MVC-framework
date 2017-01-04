<?php

namespace Service\Music;

use Model\Music;
use Service\Base;
use Service\Validator;
use Service\X;

class Delete extends Base
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
        $movie = Music::findById($params['Id']);
        if (!$movie) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Music item does not exists'
            ]);
        }

        if (!Music::delete(['Id' => [$params['Id']]])) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Cannot delete a movie'
            ]);
        }

        return [
            'Status'    => 1,
        ];
    }
}

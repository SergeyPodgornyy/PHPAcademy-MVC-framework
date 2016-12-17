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
        $movie = \Model\Movie::findById($params['Id']);

        if (!$movie) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }

        return [
            'Status'    => 1,
            'Movie'     => $movie,
        ];
    }
}

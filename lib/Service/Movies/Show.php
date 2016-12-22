<?php

namespace Service\Movie;

use Model\Movie;
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
        $movie = Movie::selectOne(['Id' => $params['Id']]);

        if (!$movie) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }
        $movie['casts'] = array_map(function ($cast) {
            return $cast['name'] . ' ' . $cast['surname'];
        }, Movie::getMoviesCasts($movie['id']));
        $movie['cast_ids'] = array_map(function ($cast) {
            return $cast['id'];
        }, Movie::getMoviesCasts($movie['id']));

        return [
            'Status'    => 1,
            'Movie'     => $movie,
        ];
    }
}

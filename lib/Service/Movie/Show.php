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
        $movie = Movie::selectOne(['Id' => $params['Id'], 'Locale' => $this->locale()]);

        if (!$movie) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }

        $movieCasts = Movie::getMoviesCasts($movie['id']);
        $movie['casts'] = array_map(function ($cast) {
            return $cast['name'] . ' ' . $cast['surname'];
        }, $movieCasts);
        $movie['cast_ids'] = array_map(function ($cast) {
            return $cast['id'];
        }, $movieCasts);

        return [
            'Status'    => 1,
            'Movie'     => $movie,
        ];
    }
}

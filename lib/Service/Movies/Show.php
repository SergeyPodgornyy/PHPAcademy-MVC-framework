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
        $movie = \Model\Movie::selectOne(['Id' => $params['Id']]);

        if (!$movie) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }
        $movie['casts'] = array_map(function($cast) {
            return $cast['name'] . ' ' . $cast['surname'];
        }, \Model\Movie::getMoviesCasts($movie['id']));
        $movie['cast_ids'] = array_map(function($cast) {
            return $cast['id'];
        }, \Model\Movie::getMoviesCasts($movie['id']));

        return [
            'Status'    => 1,
            'Movie'     => $movie,
        ];
    }
}

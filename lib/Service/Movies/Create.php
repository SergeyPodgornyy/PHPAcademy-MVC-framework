<?php

namespace Service\Movie;

class Create extends \Service\Base
{
    public function validate(array $params)
    {
        $genreIds = array_map(function($genre) {
            return $genre['id'];
        }, \Model\Genre::index([]));
        $directorIds = array_map(function($director) {
            return $director['id'];
        }, \Model\Director::index([]));
        $castIds = array_map(function($cast) {
            return $cast['id'];
        }, \Model\Cast::index([]));

        $rules = [
            'Title'     => ['required', ['max_length' => 100]],
            'Year'      => ['required', 'positive_integer'],
            'Genre'     => ['required', ['one_of' => $genreIds]],
            'Director'  => ['required', ['one_of' => $directorIds]],
            'Format'    => ['not_empty', ['one_of' => ['DVD', 'Blu-Ray', 'VHS']]],
            'Stars'     => ['required', ['list_of' => ['one_of' => $castIds]]],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Title'     => '',
            'Year'      => null,
            'Format'    => '',
            'Genre'     => null,
            'Director'  => null,
            'Stars'     => [],
        ];

        $movieId = \Model\Movie::create($params);

        return [
            'Status'    => 1,
            'MovieId'   => $movieId,
        ];
    }
}

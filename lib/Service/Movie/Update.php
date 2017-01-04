<?php

namespace Service\Movie;

use Model\Cast;
use Model\Director;
use Model\Genre;
use Model\Movie;
use Model\Utils\Transaction;
use Service\Base;
use Service\Validator;
use Service\X;

class Update extends Base
{
    public function validate(array $params)
    {
        $genreIds = array_map(function ($genre) {
            return $genre['id'];
        }, Genre::index(['Type' => 'movie']));
        $directorIds = array_map(function ($director) {
            return $director['id'];
        }, Director::index([]));
        $castIds = array_map(function ($cast) {
            return $cast['id'];
        }, Cast::index([]));

        $rules = [
            'Id'        => ['required', 'positive_integer'],
            'Title'     => ['required', ['max_length' => 100]],
            'Year'      => ['required', 'positive_integer'],
            'Genre'     => ['required', ['one_of' => $genreIds]],
            'Director'  => ['required', ['one_of' => $directorIds]],
            'Format'    => ['not_empty', ['one_of' => ['DVD', 'Blu-Ray', 'Streaming', 'VHS']]],
            'Stars'     => ['required', ['list_of' => ['one_of' => $castIds]]],
            // TODO: upload images for movies via AJAX
        ];

        return Validator::validate($params, $rules);
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

        $movie = Movie::findById($params['Id']);
        if (!$movie) {
            throw new X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }

        try {
            Transaction::beginTransaction();

            // ============= Update Movie data ==========================
            $updatedMovie = array_merge(
                Movie::toCamelCase($movie),
                $params
            );
            Movie::update($params['Id'], $updatedMovie);
            Movie::removeStars($params['Id']);
            Movie::addStars($params['Id'], $params['Stars']);
            // =========== End Update Movie data ========================

            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'Movie'     => $updatedMovie,
        ];
    }
}

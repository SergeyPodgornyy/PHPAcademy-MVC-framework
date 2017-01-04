<?php

namespace Service\Movie;

use Model\Cast;
use Model\Director;
use Model\Genre;
use Model\Movie;
use Model\Utils\Transaction;
use Service\Base;
use Service\Validator;

class Create extends Base
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

        try {
            Transaction::beginTransaction();

            // ============= Create Movie data ==========================
            $movieId = Movie::create($params);
            Movie::addStars($movieId, $params['Stars']);
            // =========== End Create Movie data ========================

            Transaction::commitTransaction();
        } catch (\Exception $e) {
            Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'MovieId'   => $movieId,
        ];
    }
}

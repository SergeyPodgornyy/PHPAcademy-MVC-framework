<?php

namespace Service\Movie;

class Update extends \Service\Base
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
            'Id'        => ['required', 'positive_integer'],
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
        $movie = \Model\Movie::findById($params['Id']);
        if (!$movie) {
            throw new \Service\X([
                'Type'    => 'FORMAT_ERROR',
                'Fields'  => ['Id' => 'WRONG'],
                'Message' => 'Movie does not exists'
            ]);
        }

        try {
            \Model\Utils\Transaction::beginTransaction();

            // ============= Update Movie data ==========================
            $updatedMovie = array_merge(
                \Model\Movie::toCamelCase($movie),
                $params
            );
            \Model\Movie::update($params['Id'], $updatedMovie);
            \Model\Movie::removeStars($params['Id']);
            foreach ($params['Stars'] as $star) {
                \Model\Movie::addStar($params['Id'], $star);
            }
            // =========== End Update Movie data ========================

            \Model\Utils\Transaction::commitTransaction();
        } catch (\Exception $e) {
            \Model\Utils\Transaction::rollbackTransaction();
            throw $e;
        }

        return [
            'Status'    => 1,
            'Movie'     => $updatedMovie,
        ];
    }
}

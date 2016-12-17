<?php

namespace Service\Movie;

class Update extends \Service\Base
{
    public function validate(array $params)
    {
        $rules = [
            'Id'        => ['required', 'positive_integer'],
            'Title'     => ['not_empty', ['max_length' => 255]],
            'Year'      => ['not_empty', 'positive_integer'],
            'Format'    => ['not_empty', ['one_of' => ['DVD', 'Blu-Ray', 'VHS']]],
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

<?php

namespace Service\Genre;

class Index extends \Service\Base
{
    public function validate($params)
    {
        $rules = [
            'Search'    => ['trim', ['max_length' => 100]],

            'Limit'     => ['integer', ['min_number' => 0]],
            'Offset'    => ['integer', ['min_number' => 0]],

            'SortField' => ['one_of' => ['id', 'name']],
            'SortOrder' => ['one_of' => ['asc', 'desc']],
        ];

        return \Service\Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params += [
            'SortField' => 'id',
            'SortOrder' => 'asc',
        ];

        $total = $filteredRecords = \Model\Genre::count();

        if (isset($params['Search'])) {
            $filteredRecords = \Model\Genre::countFiltered($params);
            $genres = \Model\Genre::search($params);
        } else {
            $genres = \Model\Genre::index($params);
        }

        return [
            'Status'            => 1,
            'Genres'            => $genres,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

<?php

namespace Service\Genre;

use Model\Genre;
use Service\Base;
use Service\Validator;

class Index extends Base
{
    public function validate($params)
    {
        $rules = [
            'Type'      => ['not_empty', ['one_of' => ['movie', 'book', 'music']]],
            'Search'    => ['trim', ['max_length' => 100]],

            'Limit'     => ['integer', ['min_number' => 0]],
            'Offset'    => ['integer', ['min_number' => 0]],

            'SortField' => ['one_of' => ['id', 'name']],
            'SortOrder' => ['one_of' => ['asc', 'desc']],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params += [
            'SortField' => 'id',
            'SortOrder' => 'asc',
            'Locale'    => $this->locale(),
        ];

        $type = isset($params['Type']) ? $params['Type'] : null;
        $total = $filteredRecords = Genre::count($type);

        if (isset($params['Search'])) {
            $filteredRecords = Genre::countFiltered($params);
            $genres = Genre::search($params);
        } else {
            $genres = Genre::index($params);
        }

        return [
            'Status'            => 1,
            'Genres'            => $genres,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

<?php

namespace Service\Author;

use Model\Author;
use Service\Base;
use Service\Validator;

class Index extends Base
{
    public function validate($params)
    {
        $rules = [
            'Search'    => ['trim', ['max_length' => 100]],

            'Limit'     => ['integer', ['min_number' => 0]],
            'Offset'    => ['integer', ['min_number' => 0]],

            'SortField' => ['one_of' => ['id', 'surname']],
            'SortOrder' => ['one_of' => ['asc', 'desc']],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params += [
            'SortField' => 'id',
            'SortOrder' => 'asc',
        ];

        $total = $filteredRecords = Author::count();

        if (isset($params['Search'])) {
            $filteredRecords = Author::countFiltered($params);
            $authors = Author::search($params);
        } else {
            $authors = Author::index($params);
        }

        return [
            'Status'            => 1,
            'Authors'           => $authors,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

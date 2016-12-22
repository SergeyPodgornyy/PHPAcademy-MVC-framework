<?php

namespace Service\Cast;

use Model\Cast;
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

        $total = $filteredRecords = Cast::count();

        if (isset($params['Search'])) {
            $filteredRecords = Cast::countFiltered($params);
            $casts = Cast::search($params);
        } else {
            $casts = Cast::index($params);
        }

        return [
            'Status'            => 1,
            'Casts'             => $casts,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

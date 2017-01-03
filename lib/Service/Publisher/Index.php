<?php

namespace Service\Publisher;

use Model\Publisher;
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
        ];

        $total = $filteredRecords = Publisher::count();

        if (isset($params['Search'])) {
            $filteredRecords = Publisher::countFiltered($params);
            $publishers = Publisher::search($params);
        } else {
            $publishers = Publisher::index($params);
        }

        return [
            'Status'            => 1,
            'Publishers'        => $publishers,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

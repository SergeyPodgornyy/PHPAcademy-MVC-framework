<?php

namespace Service\Director;

use Model\Director;
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

        $total = $filteredRecords = Director::count();

        if (isset($params['Search'])) {
            $filteredRecords = Director::countFiltered($params);
            $directors = Director::search($params);
        } else {
            $directors = Director::index($params);
        }

        return [
            'Status'            => 1,
            'Directors'         => $directors,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

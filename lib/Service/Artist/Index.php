<?php

namespace Service\Artist;

use Model\Artist;
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

        $total = $filteredRecords = Artist::count();

        if (isset($params['Search'])) {
            $filteredRecords = Artist::countFiltered($params);
            $artists = Artist::search($params);
        } else {
            $artists = Artist::index($params);
        }

        return [
            'Status'            => 1,
            'Artists'           => $artists,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

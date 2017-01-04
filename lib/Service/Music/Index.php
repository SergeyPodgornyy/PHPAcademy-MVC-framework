<?php

namespace Service\Music;

use Model\Music;
use Service\Base;
use Service\Validator;

class Index extends Base
{
    public function validate($params = array())
    {
        $rules = [
            'Search'    => ['trim', ['max_length' => 100]],

            'Limit'     => ['integer', ['min_number' => 0]],
            'Offset'    => ['integer', ['min_number' => 0]],

            'SortField' => ['one_of' => ['id', 'title']],
            'SortOrder' => ['one_of' => ['asc', 'desc']],
        ];

        return Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Limit'     => 10,
            'Offset'    => 0,
            'SortField' => 'id',
            'SortOrder' => 'asc',
        ];

        $total = $filteredRecords = Music::count();

        if (isset($params['Search'])) {
            $filteredRecords = Music::countFiltered($params);
            $music = Music::search($params);
        } else {
            $music = Music::index($params);
        }

        return [
            'Status'            => 1,
            'Music'             => $music,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

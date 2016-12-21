<?php

namespace Service\Cast;

class Index extends \Service\Base
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

        return \Service\Validator::validate($params, $rules);
    }

    public function execute($params)
    {
        $params += [
            'SortField' => 'id',
            'SortOrder' => 'asc',
        ];

        $total = $filteredRecords = \Model\Cast::count();

        if (isset($params['Search'])) {
            $filteredRecords = \Model\Cast::countFiltered($params);
            $casts = \Model\Cast::search($params);
        } else {
            $casts = \Model\Cast::index($params);
        }

        return [
            'Status'            => 1,
            'Casts'             => $casts,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

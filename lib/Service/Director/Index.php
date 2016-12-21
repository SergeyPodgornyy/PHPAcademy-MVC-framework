<?php

namespace Service\Director;

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

        $total = $filteredRecords = \Model\Director::count();

        if (isset($params['Search'])) {
            $filteredRecords = \Model\Director::countFiltered($params);
            $directors = \Model\Director::search($params);
        } else {
            $directors = \Model\Director::index($params);
        }

        return [
            'Status'            => 1,
            'Directors'         => $directors,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords,
        ];
    }
}

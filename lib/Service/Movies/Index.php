<?php

namespace Service\Movie;

class Index extends \Service\Base
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

        return \Service\Validator::validate($params, $rules);
    }

    public function execute(array $params)
    {
        $params += [
            'Limit'     => 10,
            'Offset'    => 0,
            'SortField' => 'id',
            'SortOrder' => 'asc',
        ];

        $total = $filteredRecords = \Model\Movie::count();

        if (isset($params['Search'])) {
            $filteredRecords = \Model\Movie::countFiltered($params);
            $movies = \Model\Movie::search($params);
        } else {
            $movies = \Model\Movie::index($params);
        }

        return [
            'Status'            => 1,
            'Movies'            => $movies,
            'Total'             => $total,
            'FilteredRecords'   => $filteredRecords
        ];
    }
}

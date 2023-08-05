<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BaseService
{
    protected function paginate(Collection $collect, $limit, $page)
    {
        $offset = ($page * $limit) - $limit;
        $itemsForCurrentPage = $collect->slice($offset, $limit)->all();

        return new LengthAwarePaginator($itemsForCurrentPage, count($collect), $limit, $page);
    }
}

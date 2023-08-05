<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function paginate(Collection $collect, $limit, $page)
    {
        $offset = ($page * $limit) - $limit;
        $itemsForCurrentPage = $collect->slice($offset, $limit)->all();

        return new LengthAwarePaginator($itemsForCurrentPage, count($collect), $limit, $page);
    }
}

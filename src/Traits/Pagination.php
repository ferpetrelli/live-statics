<?php

namespace Petrelli\LiveStatics\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


trait Pagination
{


    /**
     *
     * Total number of pages to return
     *
     * The paginator will behave as expected until page number == `$totalPages`.
     * In that case that one will be the last one and our
     * `LengthAwarePaginator` will behave appropriately
     *
     */
    protected $totalPages = 3;


    /**
     *
     * Pagination helper.
     *
     *
     * Emulates Eloquent's paginator behavior
     *
     * These default values are usually ok, if you need more control,
     * read below how to use buildPaginator() to return more complex
     * results
     *
     */
    public function paginate($perPage = 8)
    {

        return $this->buildPaginator(static::$baseInterface, $perPage);

    }

    /**
     *
     * Pagination emulator builder
     *
     *
     * We have two ways of using it:
     *
     * 1 - We pass a class/interface to be instantiated, and the number of elements
     *     per page.
     *
     *     return $this->buildPaginator(VideoInterface::class, $perPage);
     *
     *
     * 2 - We pass null for the class/interface, the number of elements per page, and
     *     an array with all elements to be returned. This use case is not common but it
     *     can be useful when we need very tight control over the results.
     *
     *     return $this->buildPaginator(null, null, [
     *         app(VideoInterface::class),
     *         app(AudioInterface::class),
     *         app(VideoInterface::class)
     *     ]);
     *
     */
    protected function buildPaginator($klass, $perPage, $items = [])
    {

        if (empty($items)) {
            for($n = 1; $n <= $perPage ; $n ++) {
                array_push($items, app($klass));
            }
        }

        $total = $perPage * $this->totalPages;
        $currentPage = 1;

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            Paginator::resolveCurrentPage(),
            [
                'path' => Paginator::resolveCurrentPath()
            ]
        );

    }


}

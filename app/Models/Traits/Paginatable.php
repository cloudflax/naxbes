<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Trait Paginatable
 *
 * This trait provides functionality to paginate the results of an Eloquent query.
 * It uses the `paginateResults` method to paginate based on the specified parameters.
 *
 * @package App\Models\Traits
 */
trait Paginatable
{
    /**
     * Paginate the results.
     *
     * This method paginates the query results according to the provided `$perPage` 
     * and `$page` parameters.
     *
     * @param Builder $builder The query builder instance.
     * @param int $perPage The number of items per page.
     * @param int $page The page number.
     * @return LengthAwarePaginator The paginated results.
     */
    public static function paginateResults(Builder $builder, int $perPage, int $page): LengthAwarePaginator
    {
        return $builder->paginate($perPage, ['*'], 'page', $page);
    }
}

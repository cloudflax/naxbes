<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Sortable
 *
 * This trait provides functionality to apply sorting to an Eloquent query. 
 * It uses the `applySorting` method to sort results based on the specified criteria.
 *
 * @package App\Models\Traits
 */
trait Sortable
{
    /**
     * Apply sorting to the query.
     *
     * This method sorts the results based on the provided `sort` parameter. 
     * The default column is `created_at` and the default direction is `desc`.
     *
     * @param Builder $builder The query builder instance.
     * @param string $sort The sorting criteria, e.g., 'column:direction,column2:direction2'.
     * @return Builder The modified query builder instance.
     */
    public static function applySorting(Builder $builder, string $sort): Builder
    {
        $sorts = explode(',', $sort);

        foreach ($sorts as $sortCriteria) {
            [$column, $direction] = explode(':', $sortCriteria, 2) + ['created_at', 'desc'];
            $builder->orderBy($column, $direction);
        }

        return $builder;
    }
}

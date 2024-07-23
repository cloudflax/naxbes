<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Filterable
 *
 * This trait provides functionality to apply filters to an Eloquent query.
 * Any model using this trait can define custom filter methods or use default operators.
 *
 * @package App\Models\Traits
 */
trait Filterable
{
    # Define constants for operators
    const OPERATORS = [
        'eq'      => '=',
        'ne'      => '!=',
        'gt'      => '>',
        'gte'     => '>=',
        'lt'      => '<',
        'lte'     => '<=',
        'in'      => 'in',
        'nin'     => 'nin',
        'like'    => 'like',
        'between' => 'between',
    ];

    /**
     * Apply filters to the query.
     *
     * This method loops through the provided filters and applies them to the
     * query if a corresponding method exists in the model or uses default operators.
     *
     * @param Builder $builder The query builder instance.
     * @param array $filters The filters to apply. Each filter should be an array with field as key and conditions as value.
     * @return Builder The modified query builder instance.
     * @throws InvalidArgumentException if filters format is invalid
     */
    public static function applyFilters(Builder $builder, array $filters): Builder
    {
        foreach ($filters as $field => $conditions) {
            if (!is_array($conditions) && !is_scalar($conditions)) {
                throw new InvalidArgumentException('Filter conditions must be an array or scalar value.');
            }

            $method = 'filter' . Str::studly($field);

            if (method_exists(static::class, $method)) {
                $builder = static::$method($builder, $conditions);
            } else {
                $builder = static::applyConditions($builder, $field, $conditions);
            }
        }
        return $builder;
    }

    /**
     * Apply conditions to the query.
     *
     * This method applies a set of conditions to the query. It supports various operators.
     * If the conditions are not an array, it assumes a simple equality check.
     *
     * @param Builder $builder The query builder instance.
     * @param string $field The field to filter.
     * @param mixed $conditions The conditions to apply. Can be a simple value or an associative array with operators as keys.
     * @return Builder The modified query builder instance.
     * @throws InvalidArgumentException if operator is invalid
     */
    protected static function applyConditions(Builder $builder, string $field, $conditions): Builder
    {
        if (is_scalar($conditions)) {
            return $builder->where($field, '=', $conditions);
        }

        if (!is_array($conditions)) {
            throw new InvalidArgumentException('Filter conditions must be an array or scalar value.');
        }

        foreach ($conditions as $operator => $value) {
            if (!array_key_exists($operator, self::OPERATORS)) {
                throw new InvalidArgumentException("Invalid operator: $operator");
            }

            switch ($operator) {
                case 'eq':
                case 'ne':
                case 'gt':
                case 'gte':
                case 'lt':
                case 'lte':
                    $builder->where($field, self::OPERATORS[$operator], $value);
                    break;
                case 'in':
                    $builder->whereIn($field, (array) $value);
                    break;
                case 'nin':
                    $builder->whereNotIn($field, (array) $value);
                    break;
                case 'like':
                    $builder->where($field, 'like', "%$value%");
                    break;
                case 'between':
                    if (is_string($value)) {
                        $dates = explode(',', $value);
                        if (count($dates) == 2) {
                            $start = Carbon::parse($dates[0])->startOfDay();
                            $end   = Carbon::parse($dates[1])->endOfDay();
                            $builder->whereBetween($field, [$start, $end]);
                        } else {
                            throw new InvalidArgumentException('Invalid format for "between" operator. Expected "start_date,end_date".');
                        }
                    } else {
                        throw new InvalidArgumentException('Invalid format for "between" operator. Expected string.');
                    }
                    break;
            }
        }

        return $builder;
    }
}

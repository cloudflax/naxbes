<?php

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface IModel
 *
 * This interface defines a contract for Eloquent models to ensure
 * they implement a static query method that returns a Builder instance.
 *
 * @package App\Models\Interfaces
 */
interface IModel
{
    /**
     * Get a new query builder for the model's table.
     *
     * This method should return a new instance of the Eloquent query builder
     * which allows querying the model's associated database table.
     *
     * @return Builder
     */
    public static function newBuilder(): Builder;
}

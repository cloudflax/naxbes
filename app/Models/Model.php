<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\Sortable;
use App\Models\Traits\Filterable;
use App\Models\Traits\Paginatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as ModelEloquent;

/**
 * Abstract class Model
 *
 * This abstract class extends Laravel's base Eloquent model to include additional 
 * functionalities for filtering, sorting, and paginating query results. By using traits,
 * this class modularizes these features, making the code more maintainable and easier 
 * to extend.
 * 
 * Key features of this class:
 * - **UUID Primary Key**: Automatically assigns a UUID to the model's primary key if not set.
 * - **Filtering**: Provides methods to filter query results based on various criteria.
 * - **Sorting**: Includes functionality to sort query results by specified fields.
 * - **Pagination**: Adds support for paginating query results.
 * 
 * This class is intended to be extended by concrete model classes that require these
 * additional functionalities.
 * 
 * @package App\Models
 */
abstract class Model extends ModelEloquent
{
    use Filterable, Sortable, Paginatable;

    /**
     * Indicates whether the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The booting method of the model.
     *
     * This method is used to perform actions when the model is being initialized.
     * It assigns a UUID to the model's primary key if it is not already set.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Get a new query builder for the model's table.
     *
     * This method overrides the default query builder method to return a new instance
     * of the Eloquent query builder for the model. This allows for chaining additional
     * query constraints and operations.
     *
     * @return Builder
     */
    public static function newBuilder(): Builder
    {
        return parent::query();
    }
}

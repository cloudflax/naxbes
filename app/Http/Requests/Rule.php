<?php

namespace App\Http\Requests;

/**
 * Class Rule
 *
 * Provides static methods to retrieve validation rules for different filter operators.
 * Each method returns an array of validation rules specific to an operator used in filtering.
 *
 * @package App\Http\Requests
 */
class Rule
{
    /**
     * Get validation rules for the 'eq' (equal) operator.
     *
     * The 'eq' operator checks if the field is equal to a specified value.
     * This rule is nullable, allowing for optional filtering.
     *
     * @return array The validation rules for the 'eq' operator.
     */
    public static function eq(): array
    {
        return ['eq' => 'sometimes|nullable'];
    }

    /**
     * Get validation rules for the 'ne' (not equal) operator.
     *
     * The 'ne' operator checks if the field is not equal to a specified value.
     * This rule is nullable, allowing for optional filtering.
     *
     * @return array The validation rules for the 'ne' operator.
     */
    public static function ne(): array
    {
        return ['ne' => 'sometimes|nullable'];
    }

    /**
     * Get validation rules for the 'gt' (greater than) operator.
     *
     * The 'gt' operator checks if the field's value is greater than a specified value.
     * This rule requires the value to be numeric.
     *
     * @return array The validation rules for the 'gt' operator.
     */
    public static function gt(): array
    {
        return ['gt' => 'sometimes|numeric'];
    }

    /**
     * Get validation rules for the 'gte' (greater than or equal) operator.
     *
     * The 'gte' operator checks if the field's value is greater than or equal to a specified value.
     * This rule requires the value to be numeric.
     *
     * @return array The validation rules for the 'gte' operator.
     */
    public static function gte(): array
    {
        return ['gte' => 'sometimes|numeric'];
    }

    /**
     * Get validation rules for the 'lt' (less than) operator.
     *
     * The 'lt' operator checks if the field's value is less than a specified value.
     * This rule requires the value to be numeric.
     *
     * @return array The validation rules for the 'lt' operator.
     */
    public static function lt(): array
    {
        return ['lt' => 'sometimes|numeric'];
    }

    /**
     * Get validation rules for the 'lte' (less than or equal) operator.
     *
     * The 'lte' operator checks if the field's value is less than or equal to a specified value.
     * This rule requires the value to be numeric.
     *
     * @return array The validation rules for the 'lte' operator.
     */
    public static function lte(): array
    {
        return ['lte' => 'sometimes|numeric'];
    }

    /**
     * Get validation rules for the 'in' (in array) operator.
     *
     * The 'in' operator checks if the field's value is within a specified array of values.
     * This rule requires the value to be an array.
     *
     * @return array The validation rules for the 'in' operator.
     */
    public static function in(): array
    {
        return ['in' => 'sometimes|array'];
    }

    /**
     * Get validation rules for the 'nin' (not in array) operator.
     *
     * The 'nin' operator checks if the field's value is not within a specified array of values.
     * This rule requires the value to be an array.
     *
     * @return array The validation rules for the 'nin' operator.
     */
    public static function nin(): array
    {
        return ['nin' => 'sometimes|array'];
    }

    /**
     * Get validation rules for the 'like' (contains) operator.
     *
     * The 'like' operator checks if the field's value contains a specified substring.
     * This rule requires the value to be a string.
     *
     * @return array The validation rules for the 'like' operator.
     */
    public static function like(): array
    {
        return ['like' => 'sometimes|string'];
    }

    /**
     * Get validation rules for the 'between' operator.
     *
     * The 'between' operator checks if the field's value falls within a specified range of dates.
     * This rule requires the value to be a string in the format "start_date,end_date".
     * A custom validation function ensures the format and validity of the dates.
     *
     * @return array The validation rules for the 'between' operator.
     */
    public static function between(): array
    {
        return [
            'between' => [
                'sometimes',
                'string',
                function ($attribute, $value, $fail) {
                    $dates = explode(',', $value);
                    if (count($dates) !== 2 || !strtotime($dates[0]) || !strtotime($dates[1])) {
                        $fail($attribute . ' must be in the format "start_date,end_date".');
                    }
                },
            ],
        ];
    }

    /**
     * Merge multiple arrays into one.
     *
     * This method allows combining multiple arrays into a single array.
     * It is useful for combining validation rules from different methods.
     *
     * @param array ...$arrays Arrays to be merged.
     * @return array Merged array.
     */
    public static function merge(array ...$arrays): array
    {
        return array_merge(...$arrays);
    }
}

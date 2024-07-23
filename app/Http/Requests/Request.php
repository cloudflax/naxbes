<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 *
 * This abstract class extends FormRequest and provides a base structure for
 * requests that require filter validation. Child classes must implement
 * the abstract methods to define allowed fields and filter rules.
 *
 * @package App\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * Authorizes the request. 
     *
     * By default, always authorizes the request. Child classes may
     * override this method if authorization logic is needed.
     *
     * @return bool True to authorize the request, false otherwise.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Defines allowed fields for filters.
     *
     * Child classes must implement this method to specify which fields
     * can be used in the request filters.
     *
     * @return array An array of allowed field names for filters.
     */
    abstract public function allowedFields();

    /**
     * Defines allowed operators for filters by field.
     *
     * Child classes must implement this method to provide validation rules
     * for allowed operators for each field.
     *
     * @return array An associative array where the key is the field name and the value is another array
     *               containing 'rules' and 'search_operators'. 'rules' contains general rules for the field,
     *               and 'search_operators' contains specific rules for each operator.
     */
    abstract public function fieldRules();

    /**
     * Extracts the field name from the attribute key.
     *
     * This method is used to extract the field name from the attribute
     * key in the request. It assumes the format of the key is 'filters.field.operator'.
     *
     * @param string $attribute The attribute key in the request.
     * @return string The extracted field name.
     */
    protected function extractFieldFromAttribute($attribute)
    {
        $parts = explode('.', $attribute);
        return $parts[1] ?? '';
    }

    /**
     * Defines the validation rules for the request.
     *
     * This method dynamically builds the validation rules for filters based on
     * allowed fields and specific rules for each field and operator.
     *
     * @return array An array of validation rules.
     */
    public function rules()
    {
        $config = $this->fieldRules();
        $rules = ['filters' => 'sometimes|array'];

        foreach ($config as $field => $fieldConfig) {
            $rules["filters.$field"] = $fieldConfig['rules'];

            foreach ($fieldConfig['search_operators'] as $operator => $operatorRule) {
                $rules["filters.$field.$operator"] = $operatorRule;
            }
        }

        // Validate that only allowed operators are used for each field
        $rules['filters.*'] = ['array', function ($attribute, $value, $fail) use ($config) {
            $field = $this->extractFieldFromAttribute($attribute);

            if (!in_array($field, $this->allowedFields())) {
                $fail("The field '$field' is not allowed.");
                return;
            }

            if (!isset($config[$field])) {
                $fail("No configuration found for the field '$field'.");
                return;
            }

            $allowedOperators = array_keys($config[$field]['search_operators']);
            foreach ($value as $operator => $val) {
                if (!in_array($operator, $allowedOperators)) {
                    $fail("The operator '$operator' is not allowed for field '$field'.");
                }
            }
        }];

        return $rules;
    }

    /**
     * Defines custom error messages for validation.
     *
     * This method provides custom error messages for the validation rules
     * defined in the `rules` method. Child classes can override this method
     * to provide specific error messages for their validation rules.
     *
     * @return array An array of custom error messages.
     */
    public function messages()
    {
        $config = $this->fieldRules();
        $messages = [
            'filters.required' => 'Filters are required.',
            'filters.array' => 'Filters must be an array.',
        ];

        foreach ($config as $field => $fieldConfig) {
            foreach ($fieldConfig['search_operators'] as $operator => $operatorRule) {
                $messages["filters.$field.$operator"] = "The $operator filter for $field is invalid.";
            }
        }

        return $messages;
    }
}

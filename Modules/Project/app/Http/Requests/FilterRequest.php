<?php

namespace Modules\Project\Http\Requests;

use Cloudflax\Request\Rule;
use Cloudflax\Request\Request;

class FilterRequest extends Request
{
    /**
     * Define the allowed fields for filtering.
     *
     * This method returns an array of field names that are permitted to be used
     * in filters. Each field listed here will be checked against the filter rules
     * defined in the `fieldRules` method.
     *
     * @return array
     */
    public function allowedFields()
    {
        return [
            'name',
            'description',
            'status',
        ];
    }

    /**
     * Define the filtering rules for each field.
     *
     * This method returns an array where each key represents a field and its
     * associated value is an array containing:
     * - 'rules': Validation rules for the field itself.
     * - 'search_operators': Validation rules for the operators that can be used
     *   with this field.
     *
     * The `search_operators` is constructed using the `Rule::merge` method to
     * combine multiple rule sets for different operators.
     *
     * @return array
     */
    public function fieldRules()
    {
        return [
            'name' => [
                'rules' => 'sometimes|array',
                'search_operators' => Rule::merge(
                    Rule::eq(),
                    Rule::ne(),
                    Rule::in(),
                    Rule::nin(),
                    Rule::like(),
                ),
            ],
            'description' => [
                'rules' => 'sometimes|array',
                'search_operators' => Rule::merge(
                    Rule::eq(),
                    Rule::ne(),
                    Rule::in(),
                    Rule::nin(),
                    Rule::like(),
                ),
            ],
            'status' => [
                'rules' => 'sometimes|array',
                'search_operators' => Rule::merge(
                    Rule::eq(),
                    Rule::ne(),
                    Rule::in(),
                    Rule::nin(),
                    Rule::like(),
                ),
            ],
        ];
    }
}

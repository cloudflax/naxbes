<?php

namespace Modules\Project\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectRequest
 *
 * This class handles the validation and authorization of project-related HTTP requests.
 * It extends the base FormRequest provided by Laravel.
 *
 * @package Modules\Project\Http\Requests
 */
class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // Determine the action based on the HTTP method and request URI
        $rules = [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|string|in:active,inactive',
        ];

        if ($this->isMethod('post')) {
            // Validation rules for storing a new project
            return $rules;
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Validation rules for updating an existing project
            return array_merge($rules, [
                // Additional rules for update if necessary
            ]);
        }

        if ($this->isMethod('delete')) {
            // Validation rules for deleting a project (usually not needed)
            return [];
        }

        // Default return if method does not match known methods
        return [];
    }
}

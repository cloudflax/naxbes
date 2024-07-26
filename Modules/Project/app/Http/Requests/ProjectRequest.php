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
        $rules = [
            'name'        => 'required|string|max:255',
            'status'      => 'required|string|in:active,inactive',
            'owner_id'    => 'required|exists:users,id',
            'description' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            return $rules;
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return array_merge($rules, []);
        }
    }
}

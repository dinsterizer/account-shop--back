<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roleKeys' => 'nullable|array',
            'roleKeys.*' => 'string',
            'order' => 'nullable|integer',
            'name' => 'nullable|string',
            'description' => 'nullable|string',

            // Relationship rule
            'rule' => 'nullable|array',
            'rule.requiredRoles' => 'nullable|array',
            'rule.requiredRoles.*' => 'string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Helpers\ValidationHelper;
use App\Models\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountActionRequest extends FormRequest
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
        return array_merge(
            [
                'order' => 'nullable|integer',
                'name' => 'nullable|string',
                'description' => 'nullable|string',
                'videoPath' => 'nullable|string',

            ],
            ValidationHelper::parseRulesByArray('rule', Rule::getRequestRules())
        );
    }
}

<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'code' => [
                'string',
                Rule::unique('App\Models\Coupon', 'code')
                    ->ignore($this->route('coupon'))
            ],
            'name' => ['string'],
            'description' => ['nullable', 'string'],
            'amount' => ['nullable', 'integer', 'min:1'],

            'minimumValue' => ['nullable', 'integer', 'min:0'],
            'maximumValue' => ['nullable', 'integer', 'min:0', 'gte:minimumValue'],
            'minimumDiscount' => ['nullable', 'integer', 'min:0'],
            'maximumDiscount' => ['nullable', 'integer', 'min:0', 'gte:minimumDiscount'],
            'percentageDiscount' => ['integer', 'min:0', 'max:100'],
            'directDiscount' => ['integer', 'min:0'],
            'usableAt' => ['nullable', 'date'],
            'usableClosedAt' => ['nullable', 'date', 'after_or_equal:usableAt'],

            'price' => ['nullable', 'integer', 'min:0'],
            'offeredAt' => ['nullable', 'date'],
            'offerClosedAt' => ['nullable', 'date', 'after_or_equal:offeredAt'],
        ];
    }
}

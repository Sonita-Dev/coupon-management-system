<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->whereNull('deleted_at'),
            ],
            'type' => ['required', 'in:fixed,percent'],
            'value' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'min_order_amount' => ['nullable', 'numeric', 'gte:0'],
            'max_uses' => ['nullable', 'integer', 'gte:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // routes are protected by auth middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $couponId = $this->route('coupon')?->id ?? null;

        return [
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code,' . $couponId],
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


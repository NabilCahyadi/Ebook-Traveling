<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow authenticated users, role check will be done in controller if needed
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $promoId = $this->route('promo'); // For update validation

        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'nullable',
                'string',
                'max:50',
                'unique:promos,code,' . $promoId,
                'regex:/^[A-Z0-9_-]+$/', // uppercase, numbers, underscore, hyphen only
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'in:percentage,fixed_amount,free_trial'],
            'value' => ['required', 'numeric', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'max_usage' => ['nullable', 'integer', 'min:1'],
            'max_usage_per_user' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],

            // Conditions (optional array)
            'conditions' => ['nullable', 'array'],
            'conditions.*.condition_type' => [
                'required_with:conditions',
                'in:new_user,first_subscription,subscription_type,min_price'
            ],
            'conditions.*.condition_value' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Promo name is required',
            'code.unique' => 'This promo code is already taken',
            'code.regex' => 'Promo code must contain only uppercase letters, numbers, underscores, and hyphens',
            'type.required' => 'Promo type is required',
            'type.in' => 'Invalid promo type. Must be percentage, fixed_amount, or free_trial',
            'value.required' => 'Promo value is required',
            'value.numeric' => 'Promo value must be a number',
            'start_date.required' => 'Start date is required',
            'end_date.required' => 'End date is required',
            'end_date.after' => 'End date must be after start date',
            'max_usage_per_user.required' => 'Max usage per user is required',
            'max_usage_per_user.min' => 'Max usage per user must be at least 1',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation for value based on type
            $type = $this->input('type');
            $value = $this->input('value');

            if ($type === 'percentage' && $value > 100) {
                $validator->errors()->add('value', 'Percentage value cannot exceed 100');
            }

            if ($type === 'free_trial' && $value > 365) {
                $validator->errors()->add('value', 'Free trial days cannot exceed 365');
            }
        });
    }
}

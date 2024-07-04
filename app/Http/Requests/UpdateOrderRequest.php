<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payment_id' => 'required|integer|exists:payments,id',
            'order_status_id' => 'required|integer|exists:order_statuses,id',
            'products' => 'required|array',
            'products.*.product' => 'required|string|uuid|exists:products,uuid',
            'products.*.quantity' => 'required|integer|min:1',
            'address' => 'required|array',
            'address.billing' => 'required|string',
            'address.shipping' => 'sometimes|nullable|string',
        ];
    }
}

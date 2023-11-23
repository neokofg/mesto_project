<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingIndexRequest extends FormRequest
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
            'status' => 'nullable|in:pending,accepted,declined',
            'fromDate' => 'nullable|date',
            'toDate' => 'nullable|date'
        ];
    }
}

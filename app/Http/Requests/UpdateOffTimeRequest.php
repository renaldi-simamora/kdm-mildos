<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOffTimeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['sometimes', 'required', 'exists:employees,id'],
            'off_time_category_id' => ['sometimes', 'required', 'exists:off_time_types,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'recurrence_type' => ['sometimes', 'required', 'string', 'in:None,Daily,Weekly,Monthly,Yearly'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string'],
            'status' => ['sometimes', 'required', 'string', 'in:Draft,Pending,Approved,Rejected'],
        ];
    }
}

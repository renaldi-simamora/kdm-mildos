<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
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
            'employee_id' => ['nullable', 'exists:employees,id'],
            'employee_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'shift' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Present,Late,Absent,Excused,Off Day,Pending,On Time,on_time,late,absent,excused,off_day'],
            'clock_in' => ['nullable', 'date_format:H:i:s,Y-m-d H:i:s,Y-m-d\TH:i'],
            'clock_out' => ['nullable', 'date_format:H:i:s,Y-m-d H:i:s,Y-m-d\TH:i'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

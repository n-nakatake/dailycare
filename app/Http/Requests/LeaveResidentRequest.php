<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveResidentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'left_date' => 'required|date',
            'leaving_note' => 'required|max:2000',
        ];
    }
}

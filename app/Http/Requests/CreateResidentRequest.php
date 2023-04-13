<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateResidentRequest extends FormRequest
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
            'last_name' => 'required|string|max:20',
            'first_name' => 'required|string|max:20',
            'last_name_k' => 'required|string|max:20|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'first_name_k' => 'required|string|max:20|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
            'birthday' => 'required|date|before:today',
            'gender' => 'required|in:1,2',
            'key_person_name' => 'nullable|string|max:20',
            'key_person_relation' => 'nullable|string|max:10',
            'key_person_address' => 'nullable|string',
            'key_person_tel1' => 'nullable|string|min:10|max:13|regex:/^[0-9-]+$/',
            'key_person_tel2' => 'nullable|string|min:10|max:13|regex:/^[0-9-]+$/',
            'key_person_mail' => 'nullable|email',
            'note' => 'nullable|max:2000',
            'level' => 'required|in:1,2,3,4,5,6,7,8',
            'level_start_date' => 'required|date',
            'level_end_date' => 'required|date|after:level_start_date',
        ];
    }
}

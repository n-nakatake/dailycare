<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResidentRequest extends FormRequest
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
            'level' => 'nullable|in:1,2,3,4,5,6,7|required_with:level_start_date,level_end_date',
            'level_start_date' => 'nullable|date|required_with:level,level_end_date',
            'level_end_date' => 'nullable|date|after:level_start_date|required_with:level_start_date,level',
            'new_level' => 'nullable|in:1,2,3,4,5,6,7|required_with:new_level_start_date,new_level_end_date',
            'new_level_start_date' => 'nullable|date|after:level_end_date|required_with:new_level,new_level_end_date',
            'new_level_end_date' => 'nullable|date|after:new_level_start_date|required_with:new_level_start_date,new_level',
            'image' => 'nullable|file|mimes:jpeg,jpg,png|max:3000',
        ];
    }
}

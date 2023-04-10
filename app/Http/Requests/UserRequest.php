<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            // 'office_id' => 'required|exists:exists:offices,id', // 河野 修正 office_idはリクエストで送っていないため
            'last_name' => 'required',
            'first_name' => 'required',
            'qualification' => 'required|in:0,1,2,3,4,5,6,7',
            // 'user_code' => 'required|string,min:4, max:16,unique:users', // 河野 修正 user_codeはリクエストで送っていないため
            // 'password' => 'required|string,min:8,confirmed', // 河野 修正 passwordはリクエストで送っていないため
        ];
    }
}

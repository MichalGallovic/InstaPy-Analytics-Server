<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileActivityRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'likes' => 'required|numeric',
            'comments' => 'required|numeric',
            'follows' => 'required|numeric',
            'unfollows' => 'required|numeric',
            'server_calls' => 'required|numeric',
            'logged_at' => 'required|date_format:YYYY-mm-dd H:i:s'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileProgressRequest extends FormRequest
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
            'followers' => 'required|numeric',
            'following' => 'required|numeric',
            'total_posts' => 'required|numeric',
            'logged_at' => 'required|date_format:YYYY-mm-dd H:i:s'
        ];
    }
}

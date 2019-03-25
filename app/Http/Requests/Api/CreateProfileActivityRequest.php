<?php

namespace App\Http\Requests\Api;

class CreateProfileActivityRequest extends ApiRequest
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
            'data' => 'required',
            'data.*.profile_name' => 'required',
            'data.*.likes' => 'required|numeric',
            'data.*.comments' => 'required|numeric',
            'data.*.follows' => 'required|numeric',
            'data.*.unfollows' => 'required|numeric',
            'data.*.server_calls' => 'required|numeric',
            'data.*.logged_at' => 'required|date_format:"Y-m-d H:i:s"'
        ];
    }
}

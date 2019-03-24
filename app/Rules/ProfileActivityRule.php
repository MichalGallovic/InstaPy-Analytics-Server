<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Validator;

class ProfileActivityRule implements Rule
{
    /** @var string */
    private $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $rules = [
            'profile_name' => 'required',
            'likes' => 'required|numeric',
            'comments' => 'required|numeric',
            'follows' => 'required|numeric',
            'unfollows' => 'required|numeric',
            'server_calls' => 'required|numeric',
            'logged_at' => 'required|date_format:"Y-m-d H:i:s"'
        ];

        foreach ($value as $profileActivity) {
            $validator = Validator::make($profileActivity, $rules);
            if ($validator->fails()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '';
    }
}

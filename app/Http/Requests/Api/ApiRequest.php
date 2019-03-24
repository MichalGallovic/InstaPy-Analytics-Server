<?php

namespace App\Http\Requests\Api;

use App\Exceptions\ApiValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    /**
     * @param Validator $validator
     * @return void
     *
     * @throws ApiValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ApiValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}

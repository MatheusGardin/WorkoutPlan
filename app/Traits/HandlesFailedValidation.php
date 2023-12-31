<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

trait HandlesFailedValidation
{
	protected function failedValidation(Validator $validator): void
	{
		if ($this->expectsJson() || $this->is('api/*')) {
			throw new HttpResponseException(response()->json($validator->errors(), 419));
		}

		throw (new ValidationException($validator))
			->errorBag($this->errorBag)
			->redirectTo($this->getRedirectUrl());
	}
}
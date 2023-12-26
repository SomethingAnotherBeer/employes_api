<?php
namespace App\Helpers;
use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Validator;

trait ValidationHelper
{
    protected function validateParams(array $inner_params, array $expected_params):void
    {
        $validation = Validator::make($inner_params, $expected_params);

        if ($validation->fails()) {
            throw new ValidationException($validation->errors());
        }
    }
}
<?php

namespace App\Utilities\Validators;

use Illuminate\Validation\Validator;
use Illuminate\Support\MessageBag;

class RestValidator extends Validator
{
    protected function addError($attribute, $rule, $parameters)
    {
        $message = $this->getMessage($attribute, $rule);
        $message = $this->doReplacements($message, $attribute, $rule, $parameters);

        $customMessage = new MessageBag();
        $customMessage->merge(['code' => strtolower($rule.'_rule_error')]);
        $customMessage->merge(['message' => $message]);

        $this->messages->add($attribute, $customMessage);
    }
}
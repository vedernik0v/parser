<?php

namespace App\Rules;

use App\Helpers\ParserHelper;
use Illuminate\Contracts\Validation\Rule;

class HaveKeyValue implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ParserHelper $parserHelper)
    {
        $this->parserHelper = $parserHelper;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $_cssSelector = $this->parserHelper->getCssSelectorStringFromString($value);

        return (boolval(strlen($_cssSelector)));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.haveKeyValue');
    }
}

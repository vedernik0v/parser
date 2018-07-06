<?php

namespace App\Rules;

use App\Helpers\ParserHelper;
use Illuminate\Contracts\Validation\Rule;

class HaveUrl implements Rule
{
    protected $parserHelper;

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
        $_url = $this->parserHelper->getUrlFromString($value);
        // dd($_url);

        return (boolval(strlen($_url)));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.haveUrl');
    }
}

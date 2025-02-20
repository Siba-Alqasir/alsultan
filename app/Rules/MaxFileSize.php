<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxFileSize implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $maxSize;
    public function __construct($maxSize)
    {
        $this->maxSize=$maxSize;
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
        return $value->getSize() <= $this->maxSize * 1024 ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
//        return 'The :attribute must be a file of maximum 5 MB.';
        return 'The uploaded item must be a file of maximum 5 MB.';

    }
}

<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductPriceRule implements Rule
{
    private $formData;
    /**
     * Create a new rule instance.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->formData = $object;
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
        $originPrice = (int) $this->formData['value'];
        return $value <= 1.5 * $originPrice && $value >= 0.3 * $originPrice;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selling price must be between 0.3 and 1.5 times the original price';
    }
}

<?php

namespace App\Rules;

use App\Models\Attribute;
use Illuminate\Contracts\Validation\Rule;

class ModelProductAttributeStoreRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $attributeId = $value['attribute_id'];
        $attribute = Attribute::find($attributeId);

        if (!$attribute) {
            return false;
        }

        if ($attribute->type === 'select') {
            if (empty($value['temporary_values']) || !is_array($value['temporary_values'])) {
                return false;
            }
        }
        if ($attribute->type === 'string' && $attribute->static == 1) {
            if (!is_string($value['value']) || empty($value['value'])) {
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
        return 'The :attribute is invalid.';
    }
}

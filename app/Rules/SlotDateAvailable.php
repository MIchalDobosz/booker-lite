<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SlotDateAvailable implements Rule
{
    private array $availableSlots;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $availableSlots)
    {
        $this->availableSlots = $availableSlots;
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
        return isset($this->availableSlots[$value]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Selected slot is not available.';
    }
}

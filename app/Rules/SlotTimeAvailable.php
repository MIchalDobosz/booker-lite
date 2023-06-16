<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SlotTimeAvailable implements Rule
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
        $date = request('date');

        return isset($this->availableSlots[$date][$value]);
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

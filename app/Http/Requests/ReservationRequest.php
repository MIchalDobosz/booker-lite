<?php

namespace App\Http\Requests;

use App\Rules\SlotAvailable;
use App\Services\ReservationService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $availableSlots = (new ReservationService())->getAvailableSpots();

        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'date' => ['required', Rule::in(array_keys($availableSlots))],
            'time' => ['required', new SlotAvailable($availableSlots)]
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'imię',
            'last_name' => 'nazwisko',
            'starts_at' => 'data'
        ];
    }
}

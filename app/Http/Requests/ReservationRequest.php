<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Rules\SlotDateAvailable;
use App\Rules\SlotEmployeeAvailable;
use App\Rules\SlotTimeAvailable;
use App\Services\ReservationService;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $service = Service::with('employees')->findOrFail($this->route('serviceId'));
        $employee = $service->employees->firstWhere('id', $this->input('employee_id'));
        $availableSlots = (new ReservationService($service, $employee))->getAvailableSpots();

        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'date' => ['required', new SlotDateAvailable($availableSlots)],
            'time' => ['required', new SlotTimeAvailable($availableSlots)],
            'employee_id' => ['required', new SlotEmployeeAvailable($availableSlots)]
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'imię',
            'last_name' => 'nazwisko',
            'date' => 'data',
            'time' => 'czas'
        ];
    }
}

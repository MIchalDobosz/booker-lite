<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Service;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FrontController extends Controller
{
    public function index() : View
    {
        $services = Service::pluck('name', 'id');

        return view('front.index', compact('services'));
    }

    public function form(int $serviceId, ?int $employeeId = null) : View
    {
        $service = Service::with('employees')->findOrFail($serviceId);
        $employees = $service->employees->keyBy('id');
        $employee = $employees->get($employeeId);

        abort_if(!is_null($employeeId) && is_null($employee), 404);

        $reservationService = new ReservationService($service, $employee);
        $slots = $reservationService->getAvailableSpots();

        return view('front.form', compact('service', 'employees', 'slots'));
    }

    public function store(int $serviceId, ReservationRequest $request) : RedirectResponse
    {
        $service = Service::findOrFail($serviceId);
        $startsAt = Carbon::createFromFormat('d-m-Y H:i', implode(' ', $request->safe(['date', 'time'])));
        $endsAt = $startsAt->copy()->addMinutes($service->getDurationInMinutes());
        $reservationData = $request->safe(['first_name', 'last_name', 'email', 'employee_id']) + [
            'starts_at' => $startsAt,
            'ends_at' => $endsAt
        ];

        $service->reservations()->create($reservationData);

        return redirect()->refresh()->with('message', 'Twoja rezerwacja została zapisana.');
    }
}

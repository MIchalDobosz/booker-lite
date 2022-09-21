<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Service;
use App\Services\ReservationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FrontController extends Controller
{
    public function index() : View
    {
        $services = Service::pluck('name', 'id');

        return view('front.index', compact('services'));
    }

    public function form(int $service, ReservationService $reservationService)
    {
        $slots = $reservationService->getAvailableSpots();

        return view('front.form', compact('slots'));
    }

    public function store(int $service, ReservationRequest $request) : RedirectResponse
    {
        return redirect()->refresh()->with('message', 'Twoja rezerwacja została zapisana.');
    }
}

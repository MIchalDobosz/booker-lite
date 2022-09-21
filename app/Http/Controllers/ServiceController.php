<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index() : View
    {
        $services = Service::all();

        return view('dashboard.services.index', compact('services'));
    }

    public function create(ServiceService $serviceService) : View
    {
        $durationOptions = $serviceService->getDurationOptions();

        return view('dashboard.services.create', compact('durationOptions'));
    }

    public function store(ServiceRequest $request) : RedirectResponse
    {
        Service::create($request->validated());

        return redirect()->refresh()->with('message', 'Nowa usługa została utworzona.');
    }

    public function edit(ServiceService $serviceService, Service $service) : View
    {
        $durationOptions = $serviceService->getDurationOptions();

        return view('dashboard.services.edit', compact('service', 'durationOptions'));
    }

    public function update(ServiceRequest $request, Service $service) : RedirectResponse
    {
        $service->update($request->validated());

        return redirect()->refresh()->with('message', 'Usługa została zaktualizowana..');
    }
}

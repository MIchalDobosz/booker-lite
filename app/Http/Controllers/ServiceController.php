<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Employee;
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
        $employeeList = Employee::getList();

        return view('dashboard.services.create', compact('durationOptions', 'employeeList'));
    }

    public function store(ServiceRequest $request) : RedirectResponse
    {
        $service = Service::create($request->validated());
        $service->employees()->sync(array_keys($request->input('employee_list', [])));

        return redirect()->refresh()->with('message', 'Nowa usługa została utworzona.');
    }

    public function edit(ServiceService $serviceService, int $id) : View
    {
        $service = Service::with('employees')->findOrFail($id);
        $durationOptions = $serviceService->getDurationOptions();
        $employeeList = Employee::getList();

        return view('dashboard.services.edit', compact('service', 'durationOptions', 'employeeList'));
    }

    public function update(ServiceRequest $request, int $id) : RedirectResponse
    {
        $service = Service::with('employees')->findOrFail($id);
        $service->update($request->validated());
        $service->employees()->sync(array_keys($request->input('employee_list', [])));

        return redirect()->refresh()->with('message', 'Usługa została zaktualizowana..');
    }
}

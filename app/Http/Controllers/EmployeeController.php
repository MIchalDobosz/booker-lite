<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index() : View
    {
        $employees = Employee::all();

        return view('dashboard.employees.index', compact('employees'));
    }

    public function create() : View
    {
        $serviceList = Service::getList();

        return view('dashboard.employees.create', compact('serviceList'));
    }

    public function store(EmployeeRequest $request) : RedirectResponse
    {
        $employee = Employee::create($request->validated());
        $employee->services()->sync(array_keys($request->input('service_list', [])));

        return redirect()->refresh()->with('message', 'Nowy pracownik został utworzony.');
    }

    public function edit(int $id) : View
    {
        $employee = Employee::with(['services'])->findOrFail($id);
        $serviceList = Service::getList();

        return view('dashboard.employees.edit', compact('employee', 'serviceList'));
    }

    public function update(EmployeeRequest $request, int $id) : RedirectResponse
    {
        $employee = Employee::with(['services'])->findOrFail($id);
        $employee->update($request->validated());
        $employee->services()->sync(array_keys($request->input('service_list', [])));

        return redirect()->refresh()->with('message', 'Pracownik został zaktualizowany.');
    }
}

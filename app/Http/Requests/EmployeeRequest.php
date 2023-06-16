<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'service_list' => 'required|array'
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => 'imię',
            'last_name' => 'nazwisko'
        ];
    }
}

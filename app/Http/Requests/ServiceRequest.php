<?php

namespace App\Http\Requests;

use App\Services\ServiceService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $durationOptions = (new ServiceService())->getDurationOptions();

        return [
            'name' => 'required|max:255',
            'duration' => ['required', Rule::in($durationOptions)],
            'price' => 'required|numeric',
            'is_available' => 'sometimes|in:1'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nazwa',
            'duration' => 'czas trwania',
            'price' => 'cena',
            'is_available' => 'dostępny'
        ];
    }
}

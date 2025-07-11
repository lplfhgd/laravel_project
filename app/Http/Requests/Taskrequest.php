<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Taskrequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


       public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'long_description' => 'required',
        ];
    }
}

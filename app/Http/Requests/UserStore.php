<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dni' => 'required|string|min:8|max:8|unique:users',
            'apellido' => 'required|string|max:30',
            'nombre' => 'required|string|max:30',
            'email' => 'required|unique:users|email',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'clientName'       => 'required|max:255',
            'clientAddress'    => 'max:255',
            'contactTypeId'    => 'required',
            // 'businessPhone'    => 'unique:client',
            // 'mainEmail'        => 'unique:client',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'clientName.required' => 'Nombre y Apellido es Requerido',
            'contactTypeId.required' => 'Tipo de Contacto es Requerido, debe configurar esos registros,en la vista anterior.',
            'businessPhone.unique' => 'Este Telefono De Negocio ya ha sido registrado.',
            'mainEmail.unique' => 'Este Correo Principal ya ha sido registrado.',
        ];
    }
}

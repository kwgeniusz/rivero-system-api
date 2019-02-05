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
            'clientName' => 'required|max:255',
            'clientDescription' => 'required|max:255',
            'clientAddress' => 'required|max:255',
            'clientPhone' => 'required|min:11|numeric',
            'clientEmail' => 'required|max:255|email',
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
        'clientDescription.required' => 'Campo Descripcion es Requerido',
        'clientAddress.required' => 'Campo Direccion es Requerido',
        'clientPhone.required' => 'Campo Telefono es Requerido',
        'clientEmail.required' => 'Campo Correo es Requerido',

    ];
}
}

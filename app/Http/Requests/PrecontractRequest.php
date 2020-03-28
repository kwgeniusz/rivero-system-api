<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrecontractRequest extends FormRequest
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
            'precontractDate'        => 'required',
            'clientId'            => 'required',
            'propertyNumber'      => 'required',
            'streetName'      => 'required',
            'streetType'      => 'required',
            'city'      => 'required',
            'state'      => 'required',
            'zipCode'      => 'required',
            'buildingCodeId' => 'required',
            'projectUseId' => 'required',
            'projectDescriptionId' => 'required'
        ];
    }
}

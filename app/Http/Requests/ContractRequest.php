<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            'countryId'           => 'required',
            'officeId'            => 'required',
            'contractDate'        => 'required',
            'clientId'            => 'required',
            'siteAddress'         => 'required|max:100',
            'startDate'           => 'required|max:100',
            'scheduledFinishDate' => 'required|max:100',
            'actualFinishDate'    => 'required|max:100',
            'deliveryDate'        => 'required|max:100',
        ];
    }
}

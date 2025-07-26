<?php

namespace App\Http\Requests\inventories\MobileSim;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreMobileSimRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (Auth::user()->role_id == 1) {
            return [
                'serial_number' => 'required|string|max:50|unique:mobiles_sim_inventories',
                'mobileSimNumber' => 'required|numeric|digits:11|unique:mobiles_sim_inventories,mobile_number',
                'mobileSimIP' => 'required|ip',
                'mobileSimAssignTo' => 'required|numeric|exists:employees,id'
            ];
        }
    }

    public function messages()
    {
        return [
            'mobileSimNumber.required' => 'The field Mobile Number is required',
            'mobileSimAssignTo.required' => 'The field Assign To is required',

            'mobileSimNumber.numeric' => 'The field Mobile Number must be a number',
            'mobileSimAssignTo.numeric' => 'The field Assign To must be a number',

            'mobileAssignTo.exists' => 'The field Assign To is invalid',

            'mobileSimIP.ip' => 'The field IP must be ip'
        ];
    }

    public function phoneInEgypt()
    {
        $ops = ['010', '011', '012', '015'];
        $op = substr($this->mobileSimNumber, 0, 3);
        if (!in_array($op, $ops)) {
            return true;
        }
    }

    function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->phoneInEgypt()) {
                $validator->errors()->add('mobileSimNumber', 'Wrong Phone operator code');
            }
        });

    }
}

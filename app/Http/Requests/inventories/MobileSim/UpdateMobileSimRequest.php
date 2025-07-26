<?php

namespace App\Http\Requests\inventories\MobileSim;

use App\Http\Requests\inventories\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMobileSimRequest extends FormRequest
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
                'upMobileSimId'=> 'required|numeric|exists:mobiles_sim_inventories,id',
                'serial_number' => 'required|string|max:50|unique:mobiles_sim_inventories,serial_number,'. $this->upMobileSimId,
                'upMobileSimNumber' => 'required|numeric|digits:11|unique:mobiles_sim_inventories,mobile_number,'. $this->upMobileSimId,
                'upMobileSimIP' => 'ip',
                'upMobileSimAssignTo' => 'required|numeric|exists:employees,id'
            ];
        }
    }

    public function messages()
    {
        return [
            'upMobileSimNumber.required' => 'The field Mobile Number is required',
            'upMobileSimAssignTo.required' => 'The field Assign To is required',

            'upMobileSimNumber.numeric' => 'The field Mobile Number must be a number',
            'upMobileSimAssignTo.numeric' => 'The field Assign To must be a number',

            'upMobileSimAssignTo.exists' => 'The field Assign To is invalid',

            'upMobileSimIP.ip' => 'The field IP must be ip'
        ];
    }

    public function phoneInEgypt()
    {
        $ops = ['010', '011', '012', '015'];
        $op = substr($this->upMobileSimNumber, 0, 3);
        if (!in_array($op, $ops)) {
            return true;
        }
    }

    function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->phoneInEgypt()) {
                $validator->errors()->add('upMobileSimNumber', 'Wrong Phone operator code');
            }
        });

    }
}

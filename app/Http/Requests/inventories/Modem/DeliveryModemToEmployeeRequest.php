<?php

namespace App\Http\Requests\inventories\Modem;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\ModemInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeliveryModemToEmployeeRequest extends FormRequest
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

            $modemSiteActivityId = ModemInventory::select('employee_id')->where('id', '=', $this->modemDeliveryId)->first();

            return [

                'modemDeliveryId' => 'required|numeric|exists:modems_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:'. $modemSiteActivityId->employee_id .'|exists:employees,id'

            ];

    }

}

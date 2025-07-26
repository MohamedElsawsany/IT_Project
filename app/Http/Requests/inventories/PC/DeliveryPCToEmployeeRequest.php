<?php

namespace App\Http\Requests\inventories\PC;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\PCInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class deliveryPCToEmployeeRequest extends FormRequest
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
            $pcSiteActivityId = PCInventory::select('site_activity_id', 'employee_id')->where('id', '=', $this->PCDeliveryId)->first();

            return [

                'PCDeliveryId' => 'required|numeric|exists:pc_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:' . $pcSiteActivityId->employee_id .'|exists:employees,id'

            ];
    }

}

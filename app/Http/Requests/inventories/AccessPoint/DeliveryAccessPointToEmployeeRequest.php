<?php

namespace App\Http\Requests\inventories\AccessPoint;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\AccessPointInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeliveryAccessPointToEmployeeRequest extends FormRequest
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
            $accessPointSiteActivityId = AccessPointInventory::select('employee_id')->where('id', '=', $this->accessPointDeliveryId)->first();

            return [

                'accessPointDeliveryId' => 'required|numeric|exists:access_points_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:'. $accessPointSiteActivityId->employee_id .'|exists:employees,id'

            ];
    }
}

<?php

namespace App\Http\Requests\inventories\Screen;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\ScreenInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class deliveryScreenToEmployeeRequest extends FormRequest
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

            $screenSiteActivityId = ScreenInventory::select('site_activity_id','employee_id')->where('id', '=', $this->screenDeliveryId)->first();

            return [

                'screenDeliveryId' => 'required|numeric|exists:screens_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:'. $screenSiteActivityId->employee_id .'|exists:employees,id'

            ];

    }

}

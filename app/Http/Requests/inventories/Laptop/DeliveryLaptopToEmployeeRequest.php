<?php

namespace App\Http\Requests\inventories\Laptop;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\LaptopInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class deliveryLaptopToEmployeeRequest extends FormRequest
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
        $laptopSiteActivityId = LaptopInventory::select('employee_id')->where('id', '=', $this->laptopDeliveryId)->first();

        if (Auth::user()->role_id == 1) {

            return [

                'laptopDeliveryId' => 'required|numeric|exists:laptops_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:' . $laptopSiteActivityId->employee_id . '|exists:employees,id'

            ];

        } else {
            $updateIDs = LaptopInventory::select('laptops_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'laptops_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }


            return [

                'laptopDeliveryId' => 'required|numeric|in:' . implode(',', $validUpdateID),
                'employeeNumberDelivery' => 'required|numeric|not_in:' . $laptopSiteActivityId->employee_id . '|exists:employees,id'

            ];

        }

    }

}

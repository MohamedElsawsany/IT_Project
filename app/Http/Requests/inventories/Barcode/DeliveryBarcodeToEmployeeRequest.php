<?php

namespace App\Http\Requests\inventories\Barcode;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\BarcodeInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeliveryBarcodeToEmployeeRequest extends FormRequest
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
            $barcodeSiteActivityId = BarcodeInventory::select('employee_id')->where('id', '=', $this->barcodeDeliveryId)->first();

            return [

                'barcodeDeliveryId' => 'required|numeric|exists:barcodes_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:'. $barcodeSiteActivityId->employee_id .'|exists:employees,id'

            ];
    }

}

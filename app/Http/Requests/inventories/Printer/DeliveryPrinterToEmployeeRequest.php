<?php

namespace App\Http\Requests\inventories\Printer;

use App\Models\EmployeesData\Employee;
use App\Models\Inventories\PrinterInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Util\Printer;

class deliveryPrinterToEmployeeRequest extends FormRequest
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

            $printerSiteActivityId = PrinterInventory::select('site_activity_id','employee_id')->where('id', '=', $this->printerDeliveryId)->first();

            return [

                'printerDeliveryId' => 'required|numeric|exists:printers_inventory,id',
                'employeeNumberDelivery' => 'required|numeric|not_in:'. $printerSiteActivityId->employee_id .'|exists:employees,id'

            ];

    }

}

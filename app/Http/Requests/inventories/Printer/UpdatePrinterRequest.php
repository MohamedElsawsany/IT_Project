<?php

namespace App\Http\Requests\inventories\Printer;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\PrinterInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePrinterRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'printer')->get();
        $printerModels = [];
        foreach ($models as $model) {
            $printerModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            $deliveredPrinters = PrinterInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredPrinters = [] ;
            foreach ($deliveredPrinters as $deliveredPrinter) {
                $allDeliveredPrinters [] = $deliveredPrinter->id;
            }

            return [
                'upPrinterId' => 'required|numeric|exists:printers_inventory,id|not_in:' . implode(',', $allDeliveredPrinters),
                'serial_number' => 'required|string|max:50|unique:printers_inventory,serial_number,' . $this->upPrinterId,
                'upPrinterModel' => 'required|numeric|in:' . implode(',', $printerModels),
                'upPrinterFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upPrinterLocation' => 'required|numeric|exists:sites_activities,id',
                'upPrinterCategory' => 'required|numeric|exists:printers_category,id'
            ];

        } else {
            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = PrinterInventory::select('printers_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'printers_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }

            $deliveredPrinters = PrinterInventory::select('printers_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'printers_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredPrinters = [] ;

            foreach ($deliveredPrinters as $deliveredPrinter) {
                $allDeliveredPrinters [] = $deliveredPrinter->id;
            }

            return [
                'upPrinterId' => 'required|numeric|in:' . implode(',', $validUpdateID) . '|not_in:' . implode(',', $allDeliveredPrinters),
                'serial_number' => 'required|string|max:50|unique:printers_inventory,serial_number,' . $this->upPrinterId,
                'upPrinterModel' => 'required|numeric|in:' . implode(',', $printerModels),
                'upPrinterFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upPrinterLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'upPrinterCategory' => 'required|numeric|exists:printers_category,id'
            ];
        }

    }

    public function messages()
    {
        return [
            'upPrinterModel.required' => 'The field Model is required',
            'upPrinterFlag.required' => 'The field Flag is required',
            'upPrinterLocation.required' => 'The field Location is required',
            'upPrinterCategory.required' => 'The field Category is required',

            'upPrinterModel.numeric' => 'The field Model must be a number',
            'upPrinterFlag.numeric' => 'The field Flag must be a number',
            'upPrinterLocation.numeric' => 'The field Location must be a number',
            'upPrinterCategory.numeric' => 'The field Category must be a number',

            'upPrinterModel.in' => 'The field Model is invalid',
            'upPrinterLocation.in' => 'The field Location is invalid',

            'upPrinterFlag.not_in' => 'The field Flag is invalid',
            'upPrinterId.not_in' => 'This Printer delivered to employee u can not update it',


            'upPrinterFlag.exists' => 'The field Flag is invalid',
            'upPrinterCategory.exists' => 'The field Printer Category is invalid',
            'upPrinterLocation.exists' => 'The field Location is invalid',
        ];
    }
}

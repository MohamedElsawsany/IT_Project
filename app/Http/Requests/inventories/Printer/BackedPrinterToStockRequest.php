<?php

namespace App\Http\Requests\inventories\Printer;

use App\Models\Inventories\DeliveredPrinterInventory;
use App\Models\Inventories\PrinterInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedPrinterToStockRequest extends FormRequest
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
        if (Auth::user()->role_id == 1){


            return [

                'printerId' => 'required|numeric|exists:printers_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_printers_inventory,id'

            ];


        }else{

            $printersIDs = PrinterInventory::select('printers_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'printers_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validPrintersID = [];
            foreach ($printersIDs as $printersID) {
                $validPrintersID [] = $printersID->id;
            }

            $DeliveredPrintersIDs = DeliveredPrinterInventory::select('delivered_printers_inventory.id')
                ->join('printers_inventory','printers_inventory.id','=','delivered_printers_inventory.printer_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'printers_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredPrintersID = [];
            foreach ($DeliveredPrintersIDs as $DeliveredPrintersID) {
                $validDeliveredPrintersID [] = $DeliveredPrintersID->id;
            }

            return [

                'printerId' => 'required|numeric|in:' . implode(',', $validPrintersID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredPrintersID)

            ];

        }
    }
}

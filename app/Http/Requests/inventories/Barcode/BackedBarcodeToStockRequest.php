<?php

namespace App\Http\Requests\inventories\Barcode;

use App\Models\Inventories\BarcodeInventory;
use App\Models\Inventories\DeliveredBarcodeInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedBarcodeToStockRequest extends FormRequest
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

                'barcodeId' => 'required|numeric|exists:barcodes_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_barcodes_inventory,id'

            ];


        }else{

            $barcodesIDs = BarcodeInventory::select('barcodes_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'barcodes_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validBarcodesID = [];
            foreach ($barcodesIDs as $barcodesID) {
                $validBarcodesID [] = $barcodesID->id;
            }

            $DeliveredBarcodesIDs = DeliveredBarcodeInventory::select('delivered_barcodes_inventory.id')
                ->join('barcodes_inventory','barcodes_inventory.id','=','delivered_barcodes_inventory.barcode_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'barcodes_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredBarcodesID = [];
            foreach ($DeliveredBarcodesIDs as $DeliveredBarcodesID) {
                $validDeliveredBarcodesID [] = $DeliveredBarcodesID->id;
            }

            return [

                'barcodeId' => 'required|numeric|in:' . implode(',', $validBarcodesID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredBarcodesID)

            ];

        }
    }
}

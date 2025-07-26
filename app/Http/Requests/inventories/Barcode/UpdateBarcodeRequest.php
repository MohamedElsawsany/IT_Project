<?php

namespace App\Http\Requests\inventories\Barcode;

use App\Models\Inventories\BarcodeInventory;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBarcodeRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'barcode')->get();
        $barcodeModels = [];
        foreach ($models as $model) {
            $barcodeModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {
            $deliveredBarcodes = BarcodeInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredBarcodes = [] ;
            foreach ($deliveredBarcodes as $deliveredBarcode) {
                $allDeliveredBarcodes [] = $deliveredBarcode->id;
            }
            return [
                'upBarcodeId' => 'required|numeric|exists:barcodes_inventory,id|not_in:' . implode(',', $allDeliveredBarcodes),
                'serial_number' => 'required|string|max:50|unique:barcodes_inventory,serial_number,' . $this->upBarcodeId,
                'upBarcodeModel' => 'required|numeric|in:' . implode(',', $barcodeModels),
                'upBarcodeFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upBarcodeLocation' => 'required|numeric|exists:sites_activities,id'
            ];

        } else {

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = BarcodeInventory::select('barcodes_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'barcodes_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }

            $deliveredBarcodes = BarcodeInventory::select('barcodes_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'barcodes_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredBarcodes = [] ;

            foreach ($deliveredBarcodes as $deliveredBarcode) {
                $allDeliveredBarcodes [] = $deliveredBarcode->id;
            }

            return [
                'upBarcodeId' => 'required|numeric|in:' . implode(',', $validUpdateID) . '|not_in:' . implode(',', $allDeliveredBarcodes),
                'serial_number' => 'required|string|max:50|unique:barcodes_inventory,serial_number,' . $this->upBarcodeId,
                'upBarcodeModel' => 'required|numeric|in:' . implode(',', $barcodeModels),
                'upBarcodeFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upBarcodeLocation' => 'required|numeric|in:' . implode(',', $validLocations)
            ];

        }

    }

    public function messages()
    {
        return [
            'upBarcodeModel.required' => 'The field Model is required',
            'upBarcodeFlag.required' => 'The field Flag is required',
            'upBarcodeLocation.required' => 'The field Location is required',

            'upBarcodeModel.numeric' => 'The field Model must be a number',
            'upBarcodeFlag.numeric' => 'The field Flag must be a number',
            'upBarcodeLocation.numeric' => 'The field Location must be a number',

            'upBarcodeModel.in' => 'The field Model is invalid',
            'upBarcodeLocation.in' => 'The field Location is invalid',

            'upBarcodeFlag.not_in' => 'The field Flag is invalid',
            'upBarcodeId.not_in' => 'This Barcode delivered to employee u can not update it',

            'upBarcodeFlag.exists' => 'The field Flag is invalid',
            'upBarcodeLocation.exists' => 'The field Location is invalid'
        ];
    }
}

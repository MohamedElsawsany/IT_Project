<?php

namespace App\Http\Requests\inventories\Barcode;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreBarcodeRequest extends FormRequest
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

            return [
                'serial_number' => 'required|string|max:50|unique:barcodes_inventory',
                'barcodeModel' => 'required|numeric|in:' . implode(',', $barcodeModels),
                'barcodeLocation' => 'required|numeric|exists:sites_activities,id',
                'barcodeFlag' => 'required|numeric|exists:flags,id|not_in:2'
            ];

        } else {
            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            return [
                'serial_number' => 'required|string|max:50|unique:barcodes_inventory',
                'barcodeModel' => 'required|numeric|in:' . implode(',', $barcodeModels),
                'barcodeLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'barcodeFlag' => 'required|numeric|exists:flags,id|not_in:2'
            ];
        }

    }

    public function messages()
    {
        return [
            'barcodeModel.required' => 'The field Model is required',
            'barcodeFlag.required' => 'The field Flag is required',
            'barcodeLocation.required' => 'The field Location is required',


            'barcodeModel.numeric' => 'The field Model must be a number',
            'barcodeFlag.numeric' => 'The field Flag must be a number',
            'barcodeLocation.numeric' => 'The field Location must be a number',

            'barcodeModel.in' => 'The field Model is invalid',
            'barcodeLocation.in' => 'The field Location is invalid',

            'barcodeFlag.not_in' => 'The field Flag is invalid',

            'barcodeFlag.exists' => 'The field Flag is invalid',
            'barcodeLocation.exists' => 'The field Location is invalid'
        ];
    }
}

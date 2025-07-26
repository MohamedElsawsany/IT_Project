<?php

namespace App\Http\Requests\inventories\Modem;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreModemRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'modem')->get();
        $modemModels = [];
        foreach ($models as $model) {
            $modemModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            return [
                'serial_number' => 'required|string|max:50|unique:modems_inventory',
                'modemModel' => 'required|numeric|in:' . implode(',', $modemModels),
                'modemType' => 'required|numeric|exists:modems_types,id',
                'modemLocation' => 'required|numeric|exists:sites_activities,id',
                'modemFlag' => 'required|numeric|exists:flags,id'
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
                'serial_number' => 'required|string|max:50|unique:modems_inventory',
                'modemModel' => 'required|numeric|in:' . implode(',', $modemModels),
                'modemType' => 'required|numeric|exists:modems_types,id',
                'modemLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'modemFlag' => 'required|numeric|exists:flags,id'
            ];

        }

    }

    public function messages()
    {
        return [
            'modemModel.required' => 'The field Model is required',
            'modemType.required' => 'The field Modem Type is required',
            'modemFlag.required' => 'The field Flag is required',
            'modemLocation.required' => 'The field Location is required',

            'modemModel.numeric' => 'The field Model must be a number',
            'modemType.numeric' => 'The field Modem Type must be a number',
            'modemFlag.numeric' => 'The field Flag must be a number',
            'modemLocation.numeric' => 'The field Location must be a number',

            'modemModel.in' => 'The field Model is invalid',
            'modemLocation.in' => 'The field Location is invalid',

            'modemFlag.exists' => 'The field Flag is invalid',
            'modemType.exists' => 'The field Modem Type is invalid',
            'modemLocation.exists' => 'The field Location is invalid'
        ];
    }
}

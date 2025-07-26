<?php

namespace App\Http\Requests\inventories\Modem;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\ModemInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateModemRequest extends FormRequest
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
            $deliveredModems = ModemInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredModems = [] ;
            foreach ($deliveredModems as $deliveredModem) {
                $allDeliveredModems [] = $deliveredModem->id;
            }
            return [
                'upModemId' => 'required|numeric|exists:modems_inventory,id|not_in:' . implode(',', $allDeliveredModems),
                'serial_number' => 'required|string|max:50|unique:modems_inventory,serial_number,' . $this->upModemId,
                'upModemModel' => 'required|numeric|in:' . implode(',', $modemModels),
                'upModemType' => 'required|numeric|exists:modems_types,id',
                'upModemFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upModemLocation' => 'required|numeric|exists:sites_activities,id'
            ];

        } else {

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = ModemInventory::select('modems_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'modems_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }


            $deliveredModems = ModemInventory::select('modems_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'modems_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredModems = [] ;

            foreach ($deliveredModems as $deliveredModem) {
                $allDeliveredModems [] = $deliveredModem->id;
            }

            return [
                'upModemId' => 'required|numeric|in:' . implode(',', $validUpdateID) . '|not_in:' . implode(',', $allDeliveredModems),
                'serial_number' => 'required|string|max:50|unique:modems_inventory,serial_number,' . $this->upModemId,
                'upModemModel' => 'required|numeric|in:' . implode(',', $modemModels),
                'upModemType' => 'required|numeric|exists:modems_types,id',
                'upModemFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upModemLocation' => 'required|numeric|in:' . implode(',', $validLocations)
            ];

        }

    }

    public function messages()
    {
        return [
            'upModemModel.required' => 'The field Model is required',
            'upModemType.required' => 'The field Modem Type is required',
            'upModemFlag.required' => 'The field Flag is required',
            'upModemLocation.required' => 'The field Location is required',


            'upModemModel.numeric' => 'The field Model must be a number',
            'upModemType.numeric' => 'The field Modem Type must be a number',
            'upModemFlag.numeric' => 'The field Flag must be a number',
            'upModemLocation.numeric' => 'The field Location must be a number',

            'upModemModel.in' => 'The field Model is invalid',
            'upModemLocation.in' => 'The field Location is invalid',

            'upModemId.not_in' => 'This Modem delivered to employee u can not update it',


            'upModemFlag.exists' => 'The field Flag is invalid',
            'upModemType.exists' => 'The field Modem Type is invalid',
            'upModemLocation.exists' => 'The field Location is invalid'
        ];
    }
}

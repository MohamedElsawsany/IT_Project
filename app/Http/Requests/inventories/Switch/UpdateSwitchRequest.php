<?php

namespace App\Http\Requests\inventories\Switch;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\SwitchInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSwitchRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name','=','switch')->get();
        $switchModels = [];
        foreach ($models as $model){
            $switchModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            return [
                'upSwitchId' => 'required|numeric|exists:switches_inventory,id',
                'serial_number' => 'required|string|max:50|unique:switches_inventory,serial_number,'. $this->upSwitchId,
                'upSwitchModel' => 'required|numeric|in:' .implode(',',$switchModels),
                'upSwitchPorts' => 'required|numeric|min:1|max:2147483647',
                'upSwitchFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upSwitchLocation' => 'required|numeric|exists:sites_activities,id'
            ];

        }else{

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location){
                $validLocations [] = $location->id;
            }

            $updateIDs = SwitchInventory::select('switches_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'switches_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID){
                $validUpdateID [] = $updateID->id;
            }

            return [
                'upSwitchId' => 'required|numeric|in:' .implode(',',$validUpdateID),
                'serial_number' => 'required|string|max:50|unique:switches_inventory,serial_number,'. $this->upSwitchId,
                'upSwitchModel' => 'required|numeric|in:' .implode(',',$switchModels),
                'upSwitchPorts' => 'required|numeric|min:1|max:2147483647',
                'upSwitchFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upSwitchLocation' => 'required|numeric|in:' .implode(',',$validLocations)
            ];

        }

    }

    public function messages()
    {
        return [
            'upSwitchModel.required' => 'The field Model is required',
            'upSwitchPorts.required' => 'The field Ports.No is required',
            'upSwitchFlag.required' => 'The field Flag is required',
            'upSwitchLocation.required' => 'The field Location is required',

            'upSwitchModel.numeric' => 'The field Model must be a number',
            'upSwitchPorts.numeric' => 'The field Ports.No must be a number',
            'upSwitchFlag.numeric' => 'The field Flag must be a number',
            'upSwitchLocation.numeric' => 'The field Location must be a number',

            'upSwitchPorts.max' => 'The field Ports Can not be greater than 2147483647',

            'upSwitchModel.in' => 'The field Model is invalid',
            'upSwitchLocation.in' => 'The field Location is invalid',

            'upSwitchPorts.min' => 'The field Ports.No must not be less than 1',

            'upSwitchFlag.exists' => 'The field Flag is invalid',
            'upSwitchLocation.exists' => 'The field Location is invalid',
        ];
    }
}

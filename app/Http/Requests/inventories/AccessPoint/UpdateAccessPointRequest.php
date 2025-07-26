<?php

namespace App\Http\Requests\inventories\AccessPoint;

use App\Models\Inventories\AccessPointInventory;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAccessPointRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'access_point')->get();
        $accessPointsModels = [];
        foreach ($models as $model) {
            $accessPointsModels [] = $model->id;
        }


        if (Auth::user()->role_id == 1) {
            $deliveredAccessPoints = AccessPointInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredAccessPoints = [] ;
            foreach ($deliveredAccessPoints as $deliveredAccessPoint) {
                $allDeliveredAccessPoints [] = $deliveredAccessPoint->id;
            }
            return [
                'upAccessPointId' => 'required|numeric|exists:access_points_inventory,id|not_in:' . implode(',', $allDeliveredAccessPoints),
                'serial_number' => 'required|string|max:50|unique:access_points_inventory,serial_number,' . $this->upAccessPointId,
                'upAccessPointModel' => 'required|numeric|in:' . implode(',', $accessPointsModels),
                'upAccessPointFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upAccessPointLocation' => 'required|numeric|exists:sites_activities,id',
            ];

        } else {
            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = AccessPointInventory::select('access_points_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'access_points_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }

            $deliveredAccessPoints = AccessPointInventory::select('access_points_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'access_points_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredAccessPoints = [] ;

            foreach ($deliveredAccessPoints as $deliveredAccessPoint) {
                $allDeliveredAccessPoints [] = $deliveredAccessPoint->id;
            }

            return [
                'upAccessPointId' => 'required|numeric|in:' . implode(',', $validUpdateID) . '|not_in:' . implode(',', $allDeliveredAccessPoints),
                'serial_number' => 'required|string|max:50|unique:access_points_inventory,serial_number,' . $this->upAccessPointId,
                'upAccessPointModel' => 'required|numeric|in:' . implode(',', $accessPointsModels),
                'upAccessPointFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upAccessPointLocation' => 'required|numeric|in:' . implode(',', $validLocations),
            ];
        }
    }

    public function messages()
    {
        return [
            'upAccessPointModel.required' => 'The field Model is required',
            'upAccessPointFlag.required' => 'The field Flag is required',
            'upAccessPointLocation.required' => 'The field Location is required',

            'upAccessPointModel.numeric' => 'The field Model must be a number',
            'upAccessPointFlag.numeric' => 'The field Flag must be a number',
            'upAccessPointLocation.numeric' => 'The field Location must be a number',

            'upAccessPointModel.in' => 'The field Model is invalid',
            'upAccessPointLocation.in' => 'The field Location is invalid',

            'upAccessPointFlag.not_in' => 'The field Flag is invalid',
            'upAccessPointId.not_in' => 'This Access point delivered to employee u can not update it',

            'upAccessPointFlag.exists' => 'The field Flag is invalid',
            'upAccessPointLocation.exists' => 'The field Location is invalid'
        ];
    }
}

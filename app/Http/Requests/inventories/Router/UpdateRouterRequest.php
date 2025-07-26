<?php

namespace App\Http\Requests\inventories\Router;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\RouterInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRouterRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name','=','router')->get();
        $routerModels = [];
        foreach ($models as $model){
            $routerModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            return [
                'upRouterId' => 'required|numeric|exists:routers_inventory,id',
                'serial_number' => 'required|string|max:50|unique:routers_inventory,serial_number,'. $this->upRouterId,
                'upRouterModel' => 'required|numeric|in:' .implode(',',$routerModels),
                'upRouterPorts' => 'required|numeric|min:1|max:2147483647',
                'upRouterFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upRouterLocation' => 'required|numeric|exists:sites_activities,id'
            ];

        }else{

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location){
                $validLocations [] = $location->id;
            }

            $updateIDs = RouterInventory::select('routers_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'routers_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID){
                $validUpdateID [] = $updateID->id;
            }

            return [
                'upRouterId' => 'required|numeric|in:' .implode(',',$validUpdateID),
                'serial_number' => 'required|string|max:50|unique:routers_inventory,serial_number,'. $this->upRouterId,
                'upRouterModel' => 'required|numeric|in:' .implode(',',$routerModels),
                'upRouterPorts' => 'required|numeric|min:1|max:2147483647',
                'upRouterFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upRouterLocation' => 'required|numeric|in:' .implode(',',$validLocations)
            ];

        }

    }


    public function messages()
    {
        return [
            'upRouterModel.required' => 'The field Model is required',
            'upRouterPorts.required' => 'The field Ports.No is required',
            'upRouterFlag.required' => 'The field Flag is required',
            'upRouterLocation.required' => 'The field Location is required',

            'upRouterModel.numeric' => 'The field Model must be a number',
            'upRouterPorts.numeric' => 'The field Ports.No must be a number',
            'upRouterFlag.numeric' => 'The field Flag must be a number',
            'upRouterLocation.numeric' => 'The field Location must be a number',

            'upRouterPorts.max' => 'The field Ports Can not be greater than 2147483647',

            'upRouterPorts.min' => 'The field Ports.No must not be less than 1',

            'upRouterModel.in' => 'The field Model is invalid',
            'upRouterLocation.in' => 'The field Location is invalid',

            'upRouterFlag.exists' => 'The field Flag is invalid',
            'upRouterLocation.exists' => 'The field Location is invalid'
        ];
    }
}

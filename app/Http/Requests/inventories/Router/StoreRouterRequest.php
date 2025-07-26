<?php

namespace App\Http\Requests\inventories\Router;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRouterRequest extends FormRequest
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
                'serial_number' => 'required|string|max:50|unique:routers_inventory',
                'routerModel' => 'required|numeric|in:' .implode(',',$routerModels),
                'routerPorts' => 'required|numeric|min:1|max:2147483647',
                'routerLocation' => 'required|numeric|exists:sites_activities,id',
                'routerFlag' => 'required|numeric|exists:flags,id|not_in:2'
            ];

        }else{

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location){
                $validLocations [] = $location->id;
            }

            return [
                'serial_number' => 'required|string|max:50|unique:routers_inventory',
                'routerModel' => 'required|numeric|in:' .implode(',',$routerModels),
                'routerPorts' => 'required|numeric|min:1|max:2147483647',
                'routerLocation' => 'required|numeric|in:' .implode(',',$validLocations),
                'routerFlag' => 'required|numeric|exists:flags,id|not_in:2'
            ];

        }

    }

    public function messages()
    {
        return [
            'routerModel.required' => 'The field Model is required',
            'routerPorts.required' => 'The field Ports.No is required',
            'routerFlag.required' => 'The field Flag is required',
            'routerLocation.required' => 'The field Location is required',

            'routerModel.numeric' => 'The field Model must be a number',
            'routerPorts.numeric' => 'The field Ports.No must be a number',
            'routerFlag.numeric' => 'The field Flag must be a number',
            'routerLocation.numeric' => 'The field Location must be a number',

            'routerPorts.max' => 'The field Ports Can not be greater than 2147483647',

            'routerModel.in' => 'The field Model is invalid',
            'routerLocation.in' => 'The field Location is invalid',

            'routerPorts.min' => 'The field Ports.No must not be less than 1',

            'routerFlag.exists' => 'The field Flag is invalid',
            'routerLocation.exists' => 'The field Location is invalid'
        ];
    }
}

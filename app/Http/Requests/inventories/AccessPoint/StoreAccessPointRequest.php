<?php

namespace App\Http\Requests\inventories\AccessPoint;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAccessPointRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name','=','access_point')->get();

        $accessPointsModels = [];

        foreach ($models as $model){
            $accessPointsModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1){
            return [
                'serial_number' => 'required|string|max:50|unique:access_points_inventory',
                'accessPointModel' => 'required|numeric|in:' .implode(',',$accessPointsModels),
                'accessPointLocation' => 'required|numeric|exists:sites_activities,id',
                'accessPointFlag' => 'required|numeric|exists:flags,id|not_in:2'
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
                'serial_number' => 'required|string|max:50|unique:access_points_inventory',
                'accessPointModel' => 'required|numeric|in:' .implode(',',$accessPointsModels),
                'accessPointLocation' => 'required|numeric|in:' .implode(',',$validLocations),
                'accessPointFlag' => 'required|numeric|exists:flags,id|not_in:2'
            ];
        }

    }

    public function messages()
    {
        return [
            'accessPointModel.required' => 'The field Model is required',
            'accessPointFlag.required' => 'The field Flag is required',
            'accessPointLocation.required' => 'The field Location is required',

            'accessPointModel.numeric' => 'The field Model must be a number',
            'accessPointFlag.numeric' => 'The field Flag must be a number',
            'accessPointLocation.numeric' => 'The field Location must be a number',

            'accessPointModel.in' => 'The field Model is invalid',
            'accessPointLocation.in' => 'The field Location is invalid',

            'accessPointFlag.not_in' => 'The field Flag is invalid',

            'accessPointFlag.exists' => 'The field Flag is invalid',

            'accessPointLocation.exists' => 'The field Location is invalid',
        ];
    }
}

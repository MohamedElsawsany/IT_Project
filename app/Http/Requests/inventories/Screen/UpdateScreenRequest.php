<?php

namespace App\Http\Requests\inventories\Screen;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\ScreenInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateScreenRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'screen')->get();
        $screenModels = [];
        foreach ($models as $model) {
            $screenModels [] = $model->id;
        }
        if (Auth::user()->role_id == 1) {

            $deliveredScreens = ScreenInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredScreens = [] ;
            foreach ($deliveredScreens as $deliveredScreen) {
                $allDeliveredScreens [] = $deliveredScreen->id;
            }

            return [
                'upScreenId' => 'required|numeric|exists:screens_inventory,id|not_in:' . implode(',', $allDeliveredScreens),
                'serial_number' => 'required|string|max:50|unique:screens_inventory,serial_number,' . $this->upScreenId,
                'upScreenModel' => 'required|numeric|in:' . implode(',', $screenModels),
                'upScreenFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upScreenLocation' => 'required|numeric|exists:sites_activities,id',
                'upScreenInch' => 'required|numeric|min:0'
            ];

        } else {

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = ScreenInventory::select('screens_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'screens_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }


            $deliveredScreens = ScreenInventory::select('screens_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'screens_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredScreens = [] ;

            foreach ($deliveredScreens as $deliveredScreen) {
                $allDeliveredScreens [] = $deliveredScreen->id;
            }

            return [
                'upScreenId' => 'required|numeric|in:' . implode(',', $validUpdateID) . '|not_in:' . implode(',', $allDeliveredScreens),
                'serial_number' => 'required|string|max:50|unique:screens_inventory,serial_number,' . $this->upScreenId,
                'upScreenModel' => 'required|numeric|in:' . implode(',', $screenModels),
                'upScreenFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upScreenLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'upScreenInch' => 'required|numeric|min:0'
            ];

        }

    }

    public function messages()
    {
        return [
            'upScreenModel.required' => 'The field Model is required',
            'upScreenFlag.required' => 'The field Flag is required',
            'upScreenLocation.required' => 'The field Location is required',
            'upScreenInch.required' => 'The field Screen Inch is required',

            'upScreenModel.numeric' => 'The field Model must be a number',
            'upScreenFlag.numeric' => 'The field Flag must be a number',
            'upScreenLocation.numeric' => 'The field Location must be a number',
            'upScreenInch.numeric' => 'The field Screen Inch must be a number',

            'upScreenModel.in' => 'The field Model is invalid',
            'upScreenLocation.in' => 'The field Location is invalid',

            'upScreenFlag.not_in' => 'The field Flag is invalid',
            'upScreenId.not_in' => 'This Screen delivered to employee u can not update it',

            'upScreenInch.min' => 'The field Screen Inch must not be less than 1',

            'upScreenFlag.exists' => 'The field Flag is invalid',
            'upScreenLocation.exists' => 'The field Location is invalid'
        ];
    }
}

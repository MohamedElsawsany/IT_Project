<?php

namespace App\Http\Requests\inventories\Switch;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSwitchRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'switch')->get();
        $switchModels = [];
        foreach ($models as $model) {
            $switchModels [] = $model->id;
        }
        if (Auth::user()->role_id == 1) {

            return [
                'serial_number' => 'required|string|max:50|unique:switches_inventory',
                'switchModel' => 'required|numeric|in:' . implode(',', $switchModels),
                'switchPorts' => 'required|numeric|min:1|max:2147483647',
                'switchLocation' => 'required|numeric|exists:sites_activities,id',
                'switchFlag' => 'required|numeric|exists:flags,id|not_in:2'
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
                'serial_number' => 'required|string|max:50|unique:switches_inventory',
                'switchModel' => 'required|numeric|in:' . implode(',', $switchModels),
                'switchPorts' => 'required|numeric|min:1|max:2147483647',
                'switchLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'switchFlag' => 'required|numeric|exists:flags,id|not_in:2'
            ];

        }

    }

    public function messages()
    {
        return [
            'switchModel.required' => 'The field Model is required',
            'switchPorts.required' => 'The field Ports.No is required',
            'switchFlag.required' => 'The field Flag is required',
            'switchLocation.required' => 'The field Location is required',

            'switchModel.numeric' => 'The field Model must be a number',
            'switchPorts.numeric' => 'The field Ports.No must be a number',
            'switchFlag.numeric' => 'The field Flag must be a number',
            'switchLocation.numeric' => 'The field Location must be a number',

            'switchPorts.max' => 'The field Ports Can not be greater than 2147483647',

            'switchModel.in' => 'The field Model is invalid',
            'switchLocation.in' => 'The field Location is invalid',

            'switchPorts.min' => 'The field Ports.No must not be less than 1',

            'switchFlag.exists' => 'The field Flag is invalid',
            'switchLocation.exists' => 'The field Location is invalid'
        ];
    }
}

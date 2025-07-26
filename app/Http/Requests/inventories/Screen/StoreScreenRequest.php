<?php

namespace App\Http\Requests\inventories\Screen;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreScreenRequest extends FormRequest
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

            return [
                'serial_number' => 'required|string|max:50|unique:screens_inventory',
                'screenModel' => 'required|numeric|in:' . implode(',', $screenModels),
                'screenLocation' => 'required|numeric|exists:sites_activities,id',
                'screenFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'screenInch' => 'required|numeric|min:0'
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
                'serial_number' => 'required|string|max:50|unique:screens_inventory',
                'screenModel' => 'required|numeric|in:' . implode(',', $screenModels),
                'screenLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'screenFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'screenInch' => 'required|numeric|min:0'
            ];
        }

    }


    public function messages()
    {
        return [
            'screenModel.required' => 'The field Model is required',
            'screenFlag.required' => 'The field Flag is required',
            'screenLocation.required' => 'The field Location is required',
            'screenInch.required' => 'The field Screen Inch is required',

            'screenModel.numeric' => 'The field Model must be a number',
            'screenFlag.numeric' => 'The field Flag must be a number',
            'screenLocation.numeric' => 'The field Location must be a number',
            'screenInch.numeric' => 'The field Screen Inch must be a number',

            'screenModel.in' => 'The field Model is invalid',
            'screenLocation.in' => 'The field Location is invalid',

            'screenFlag.not_in' => 'The field Flag is invalid',

            'screenInch.min' => 'The field Screen Inch must not be less than 0',

            'screenFlag.exists' => 'The field Flag is invalid',
            'screenLocation.exists' => 'The field Location is invalid'
        ];
    }
}

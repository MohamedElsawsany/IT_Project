<?php

namespace App\Http\Requests\inventories\Printer;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePrinterRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name','=','printer')->get();
        $printerModels = [];
        foreach ($models as $model){
            $printerModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            return [
                'serial_number' => 'required|string|max:50|unique:printers_inventory',
                'printerModel' => 'required|numeric|in:' .implode(',',$printerModels),
                'printerLocation' => 'required|numeric|exists:sites_activities,id',
                'printerFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'printerCategory' => 'required|numeric|exists:printers_category,id'
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
                'serial_number' => 'required|string|max:50|unique:printers_inventory',
                'printerModel' => 'required|numeric|in:' .implode(',',$printerModels),
                'printerLocation' => 'required|numeric|in:' .implode(',',$validLocations),
                'printerFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'printerCategory' => 'required|numeric|exists:printers_category,id'
            ];

        }

    }

    public function messages()
    {
        return [
            'printerModel.required' => 'The field Model is required',
            'printerFlag.required' => 'The field Flag is required',
            'printerLocation.required' => 'The field Location is required',
            'printerCategory.required' => 'The field Category is required',

            'printerModel.numeric' => 'The field Model must be a number',
            'printerFlag.numeric' => 'The field Flag must be a number',
            'printerLocation.numeric' => 'The field Location must be a number',
            'printerCategory.numeric' => 'The field Category must be a number',

            'printerModel.in' => 'The field Model is invalid',
            'printerLocation.in' => 'The field Location is invalid',

            'printerFlag.not_in' => 'The field Flag is invalid',

            'printerFlag.exists' => 'The field Flag is invalid',
            'printerCategory.exists' => 'The field Printer Category is invalid',
            'printerLocation.exists' => 'The field Location is invalid'
        ];
    }
}

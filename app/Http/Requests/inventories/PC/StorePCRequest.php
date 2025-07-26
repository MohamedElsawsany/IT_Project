<?php

namespace App\Http\Requests\inventories\PC;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePCRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'pc')->get();
        $pcModels = [];
        foreach ($models as $model) {
            $pcModels [] = $model->id;
        }
        if (Auth::user()->role_id == 1) {
            return [
                'serial_number' => 'required|string|max:50|unique:pc_inventory',
                'PC_model' => 'required|numeric|in:' . implode(',', $pcModels),
                'PC_CPU' => 'required|numeric|exists:cpu_tb,id',
                'PC_flag' => 'required|numeric|exists:flags,id|not_in:2',
                'PC_GPU1' => 'required|numeric|exists:gpu_tb,id',
                'PC_GPU2' => 'required|numeric|exists:gpu_tb,id',
                'PC_HDD' => 'required|numeric|min:0|max:2147483647',
                'PC_SSD' => 'required|numeric|min:0|max:2147483647',
                'PC_OS' => 'required|numeric|exists:operating_systems,id',
                'PC_ram' => 'required|string|max:50',
                'PC_location' => 'required|numeric|exists:sites_activities,id'
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
                'serial_number' => 'required|string|max:50|unique:pc_inventory',
                'PC_model' => 'required|numeric|in:' . implode(',', $pcModels),
                'PC_CPU' => 'required|numeric|exists:cpu_tb,id',
                'PC_flag' => 'required|numeric|exists:flags,id|not_in:2',
                'PC_GPU1' => 'required|numeric|exists:gpu_tb,id',
                'PC_GPU2' => 'required|numeric|exists:gpu_tb,id',
                'PC_HDD' => 'required|numeric|min:0|max:2147483647',
                'PC_SSD' => 'required|numeric|min:0|max:2147483647',
                'PC_OS' => 'required|numeric|exists:operating_systems,id',
                'PC_ram' => 'required|string|max:50',
                'PC_location' => 'required|numeric|in:' . implode(',', $validLocations),
            ];
        }
    }

    public function messages()
    {
        return [
            'PC_model.required' => 'The field Model is required',
            'PC_CPU.required' => 'The field CPU is required',
            'PC_flag.required' => 'The field Flag is required',
            'PC_GPU1.required' => 'The field Primary GPU is required',
            'PC_GPU2.required' => 'The field Secondary GPU is required',
            'PC_HDD.required' => 'The field HDD is required',
            'PC_SSD.required' => 'The field SSD is required',
            'PC_OS.required' => 'The field Operating System is required',
            'PC_ram.required' => 'The field Ram is required',
            'PC_location.required' => 'The field Location is required',


            'PC_model.numeric' => 'The field Model must be a number',
            'PC_CPU.numeric' => 'The field CPU must be a number',
            'PC_flag.numeric' => 'The field Flag must be a number',
            'PC_GPU1.numeric' => 'The field Primary GPU must be a number',
            'PC_GPU2.numeric' => 'The field Secondary GPU must be a number',
            'PC_SSD.numeric' => 'The field SSD must be a number',
            'PC_OS.numeric' => 'The field Operating System must be a number',
            'PC_HDD.numeric' => 'The field HDD must be a number',
            'PC_location.numeric' => 'The field Location must be a number',


            'PC_ram.string' => 'The field Ram must be string',

            'PC_model.in' => 'The field Model is invalid',
            'PC_location.in' => 'The field Location is invalid',

            'PC_flag.not_in' => 'The field Flag is invalid',

            'PC_ram.max' => 'The field Ram must not be greater than 50 characters',
            'PC_HDD.max' => 'The field HDD Storage Can not be greater than 2147483647',
            'PC_SSD.max' => 'The field SSD Storage Can not be greater than 2147483647',

            'PC_HDD.min' => 'The field HDD Storage must not be less than 0',
            'PC_SSD.min' => 'The field SSD Storage must not be less than 0',

            'PC_CPU.exists' => 'The field CPU is invalid',
            'PC_GPU1.exists' => 'The field Primary GPU is invalid',
            'PC_GPU2.exists' => 'The field Secondary GPU is invalid',
            'PC_flag.exists' => 'The field Flag is invalid',
            'PC_OS.exists' => 'The field Operating System is invalid',
            'PC_location.exists' => 'The field Location is invalid',
        ];
    }
}

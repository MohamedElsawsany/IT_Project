<?php

namespace App\Http\Requests\inventories\Laptop;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreLaptopRequest extends FormRequest
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
        $models = InvnetoryModelsModel::select('id')->where('category_name', '=', 'laptop')->get();

        $laptopModels = [];

        foreach ($models as $model) {
            $laptopModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            return [
                'serial_number' => 'required|string|max:50|unique:laptops_inventory',
                'LaptopModel' => 'required|numeric|in:' . implode(',', $laptopModels),
                'LaptopCPU' => 'required|numeric|exists:cpu_tb,id',
                'LaptopFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'LaptopGPU1' => 'required|numeric|exists:gpu_tb,id',
                'LaptopGPU2' => 'required|numeric|exists:gpu_tb,id',
                'LaptopHDD' => 'required|numeric|min:0|max:2147483647',
                'LaptopSSD' => 'required|numeric|min:0|max:2147483647',
                'LaptopOS' => 'required|numeric|exists:operating_systems,id',
                'LaptopRam' => 'required|string|max:50',
                'LaptopLocation' => 'required|numeric|exists:sites_activities,id',
                'LaptopScreen' => 'required|numeric|min:0',
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
                'serial_number' => 'required|string|max:50|unique:laptops_inventory',
                'LaptopModel' => 'required|numeric|in:' . implode(',', $laptopModels),
                'LaptopCPU' => 'required|numeric|exists:cpu_tb,id',
                'LaptopFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'LaptopGPU1' => 'required|numeric|exists:gpu_tb,id',
                'LaptopGPU2' => 'required|numeric|exists:gpu_tb,id',
                'LaptopHDD' => 'required|numeric|min:0|max:2147483647',
                'LaptopSSD' => 'required|numeric|min:0|max:2147483647',
                'LaptopOS' => 'required|numeric|exists:operating_systems,id',
                'LaptopRam' => 'required|string|max:50',
                'LaptopLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'LaptopScreen' => 'required|numeric|min:0',
            ];

        }

    }

    public function messages()
    {
        return [
            'LaptopModel.required' => 'The field Model is required',
            'LaptopCPU.required' => 'The field CPU is required',
            'LaptopFlag.required' => 'The field Flag is required',
            'LaptopGPU1.required' => 'The field Primary GPU is required',
            'LaptopGPU2.required' => 'The field Secondary GPU is required',
            'LaptopHDD.required' => 'The field HDD is required',
            'LaptopOS.required' => 'The field Operating Systems is required',
            'LaptopSSD.required' => 'The field SSD is required',
            'LaptopRam.required' => 'The field Ram is required',
            'LaptopLocation.required' => 'The field Location is required',
            'LaptopScreen.required' => 'The field Screen Inch is required',


            'LaptopModel.numeric' => 'The field Model must be a number',
            'LaptopCPU.numeric' => 'The field CPU must be a number',
            'LaptopFlag.numeric' => 'The field Flag must be a number',
            'LaptopGPU1.numeric' => 'The field Primary GPU must be a number',
            'LaptopGPU2.numeric' => 'The field Secondary GPU must be a number',
            'LaptopSSD.numeric' => 'The field SSD must be a number',
            'LaptopHDD.numeric' => 'The field HDD must be a number',
            'LaptopOS.numeric' => 'The field Operating Systems must be a number',
            'LaptopScreen.numeric' => 'The field Screen Inch must be a number',
            'LaptopLocation.numeric' => 'The field Location must be a number',

            'LaptopRam.string' => 'The field Ram must be string',

            'LaptopModel.in' => 'The field Model is invalid',
            'LaptopLocation.in' => 'The field Location is invalid',

            'LaptopFlag.not_in' => 'The field Flag is invalid',

            'LaptopRam.max' => 'The field Ram must not be greater than 50 characters',
            'LaptopHDD.max' => 'The field HDD Storage Can not be greater than 2147483647',
            'LaptopSSD.max' => 'The field SSD Storage Can not be greater than 2147483647',

            'LaptopHDD.min' => 'The field HDD Storage must not be less than 0',
            'LaptopSSD.min' => 'The field SSD Storage must not be less than 0',
            'LaptopScreen.min' => 'The field Screen Inch must not be less than 0',

            'LaptopCPU.exists' => 'The field CPU is invalid',
            'LaptopGPU1.exists' => 'The field Primary GPU is invalid',
            'LaptopGPU2.exists' => 'The field Secondary GPU is invalid',
            'LaptopFlag.exists' => 'The field Flag is invalid',
            'LaptopOS.exists' => 'The field Operating System is invalid',
            'LaptopLocation.exists' => 'The field Location is invalid'
        ];
    }
}

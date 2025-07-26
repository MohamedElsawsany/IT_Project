<?php

namespace App\Http\Requests\inventories\Server;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreServerRequest extends FormRequest
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
        $serverModels = [];
        foreach ($models as $model) {
            $serverModels [] = $model->id;
        }

        if (Auth::user()->role_id == 1) {

            return [
                'serial_number' => 'required|string|max:50|unique:servers_inventory',
                'serverModel' => 'required|numeric|in:' . implode(',', $serverModels),
                'serverCPU' => 'required|numeric|exists:cpu_tb,id',
                'serverGPU1' => 'required|numeric|exists:gpu_tb,id',
                'serverGPU2' => 'required|numeric|exists:gpu_tb,id',
                'serverHDDStorage' => 'required|numeric|min:0|max:2147483647',
                'serverSSDStorage' => 'required|numeric|min:0|max:2147483647',
                'serverLocation' => 'required|numeric|exists:sites_activities,id',
                'serverRam' => 'required|string|max:50',
                'serverFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'serverOS' => 'required|numeric|exists:operating_systems,id'
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
                'serial_number' => 'required|string|max:50|unique:servers_inventory',
                'serverModel' => 'required|numeric|in:' . implode(',', $serverModels),
                'serverCPU' => 'required|numeric|exists:cpu_tb,id',
                'serverGPU1' => 'required|numeric|exists:gpu_tb,id',
                'serverGPU2' => 'required|numeric|exists:gpu_tb,id',
                'serverHDDStorage' => 'required|numeric|min:0|max:2147483647',
                'serverSSDStorage' => 'required|numeric|min:0|max:2147483647',
                'serverLocation' => 'required|numeric|in:' . implode(',', $validLocations),
                'serverRam' => 'required|string|max:50',
                'serverFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'serverOS' => 'required|numeric|exists:operating_systems,id'
            ];

        }

    }

    public function messages()
    {
        return [
            'serverModel.required' => 'The field Model is required',
            'serverCPU.required' => 'The field CPU is required',
            'serverFlag.required' => 'The field Flag is required',
            'serverGPU1.required' => 'The field Primary GPU is required',
            'serverGPU2.required' => 'The field Secondary GPU is required',
            'serverHDDStorage.required' => 'The field HDD is required',
            'serverSSDStorage.required' => 'The field SSD is required',
            'serverOS.required' => 'The field Operating System is required',
            'serverRam.required' => 'The field Ram is required',
            'serverLocation.required' => 'The field Location is required',

            'serverModel.numeric' => 'The field Model must be a number',
            'serverCPU.numeric' => 'The field CPU must be a number',
            'serverFlag.numeric' => 'The field Flag must be a number',
            'serverGPU1.numeric' => 'The field Primary GPU must be a number',
            'serverGPU2.numeric' => 'The field Secondary GPU must be a number',
            'serverSSDStorage.numeric' => 'The field SSD must be a number',
            'serverOS.numeric' => 'The field Operating System must be a number',
            'serverHDDStorage.numeric' => 'The field HDD must be a number',
            'serverLocation.numeric' => 'The field Location must be a number',

            'serverRam.string' => 'The field Ram must be string',

            'serverModel.in' => 'The field Model is invalid',
            'serverLocation.in' => 'The field Location is invalid',

            'serverRam.max' => 'The field Ram must not be greater than 50 characters',
            'serverHDDStorage.max' => 'The field HDD Storage Can not be greater than 2147483647',
            'serverSSDStorage.max' => 'The field SSD Storage Can not be greater than 2147483647',

            'serverHDDStorage.min' => 'The field HDD Storage must not be less than 0',
            'serverSSDStorage.min' => 'The field SSD Storage must not be less than 0',

            'serverCPU.exists' => 'The field CPU is invalid',
            'serverGPU1.exists' => 'The field Primary GPU is invalid',
            'serverGPU2.exists' => 'The field Secondary GPU is invalid',
            'serverFlag.exists' => 'The field Flag is invalid',
            'serverOS.exists' => 'The field Operating System is invalid',
            'serverLocation.exists' => 'The field Location is invalid'
        ];
    }
}

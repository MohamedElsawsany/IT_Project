<?php

namespace App\Http\Requests\inventories\Server;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\ServerInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateServerRequest extends FormRequest
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
                'upServerId' => 'required|numeric|exists:servers_inventory,id',
                'serial_number' => 'required|string|max:50|unique:servers_inventory,serial_number,' . $this->upServerId,
                'upServerModel' => 'required|numeric|in:' . implode(',', $serverModels),
                'upServerCPU' => 'required|numeric|exists:cpu_tb,id',
                'upServerGPU1' => 'required|numeric|exists:gpu_tb,id',
                'upServerGPU2' => 'required|numeric|exists:gpu_tb,id',
                'upServerOS' => 'required|numeric|exists:operating_systems,id',
                'upServerHDDStorage' => 'required|numeric|min:0|max:2147483647',
                'upServerSSDStorage' => 'required|numeric|min:0|max:2147483647',
                'upServerFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upServerRam' => 'required|string|max:50',
                'upServerLocation' => 'required|numeric|exists:sites_activities,id'
            ];

        } else {

            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = ServerInventory::select('servers_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'servers_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }

            return [
                'upServerId' => 'required|numeric|in:' . implode(',', $validUpdateID),
                'serial_number' => 'required|string|max:50|unique:servers_inventory,serial_number,' . $this->upServerId,
                'upServerModel' => 'required|numeric|in:' . implode(',', $serverModels),
                'upServerCPU' => 'required|numeric|exists:cpu_tb,id',
                'upServerGPU1' => 'required|numeric|exists:gpu_tb,id',
                'upServerGPU2' => 'required|numeric|exists:gpu_tb,id',
                'upServerOS' => 'required|numeric|exists:operating_systems,id',
                'upServerHDDStorage' => 'required|numeric|min:0|max:2147483647',
                'upServerSSDStorage' => 'required|numeric|min:0|max:2147483647',
                'upServerFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upServerRam' => 'required|string|max:50',
                'upServerLocation' => 'required|numeric|in:' . implode(',', $validLocations)
            ];

        }

    }

    public function messages()
    {
        return [
            'upServerModel.required' => 'The field Model is required',
            'upServerCPU.required' => 'The field CPU is required',
            'upServerOS.required' => 'The field Operating System is required',
            'upServerFlag.required' => 'The field Flag is required',
            'upServerGPU1.required' => 'The field Primary GPU is required',
            'upServerGPU2.required' => 'The field Secondary GPU is required',
            'upServerHDDStorage.required' => 'The field HDD is required',
            'upServerSSDStorage.required' => 'The field SSD is required',
            'upServerRam.required' => 'The field Ram is required',
            'upServerLocation.required' => 'The field Location is required',


            'upServerModel.numeric' => 'The field Model must be a number',
            'upServerCPU.numeric' => 'The field CPU must be a number',
            'upServerFlag.numeric' => 'The field Flag must be a number',
            'upServerGPU1.numeric' => 'The field Primary GPU must be a number',
            'upServerGPU2.numeric' => 'The field Secondary GPU must be a number',
            'upServerOS.numeric' => 'The field Operating System must be a number',
            'upServerHDDStorage.numeric' => 'The field HDD must be a number',
            'upServerSSDStorage.numeric' => 'The field SSD must be a number',
            'upServerLocation.numeric' => 'The field Location must be a number',

            'upServerRam.string' => 'The field Ram must be string',

            'upServerModel.in' => 'The field Model is invalid',
            'upServerLocation.in' => 'The field Location is invalid',

            'upServerRam.max' => 'The field Ram must not be greater than 50 characters',
            'upServerHDDStorage.max' => 'The field HDD Storage Can not be greater than 2147483647',
            'upServerSSDStorage.max' => 'The field SSD Storage Can not be greater than 2147483647',

            'upServerHDDStorage.min' => 'The field HDD Storage must not be less than 0',
            'upServerSSDStorage.min' => 'The field SSD Storage must not be less than 0',

            'upServerCPU.exists' => 'The field CPU is invalid',
            'upServerGPU1.exists' => 'The field Primary GPU is invalid',
            'upServerGPU2.exists' => 'The field Secondary GPU is invalid',
            'upServerFlag.exists' => 'The field Flag is invalid',
            'upServerOS.exists' => 'The field Operating System is invalid',
            'upServerLocation.exists' => 'The field Location is invalid'
        ];
    }
}

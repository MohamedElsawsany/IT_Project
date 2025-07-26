<?php

namespace App\Http\Requests\inventories\Laptop;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\LaptopInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateLaptopRequest extends FormRequest
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

            $deliveredLaptops = LaptopInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredLaptops = [] ;
                foreach ($deliveredLaptops as $deliveredLaptop) {
                    $allDeliveredLaptops [] = $deliveredLaptop->id;
                }

            return [
                'up_id' => 'required|numeric|exists:laptops_inventory,id|not_in:' . implode(',', $allDeliveredLaptops),
                'serial_number' => 'required|string|max:50|unique:laptops_inventory,serial_number,' . $this->up_id,
                'upLaptopModel' => 'required|numeric|in:' . implode(',', $laptopModels),
                'upLaptopCPU' => 'required|numeric|exists:cpu_tb,id',
                'upLaptopHDD' => 'required|numeric|min:0|max:2147483647',
                'upLaptopSSD' => 'required|numeric|min:0|max:2147483647',
                'upLaptopOS' => 'required|numeric|exists:operating_systems,id',
                'upLaptopGPU1' => 'required|numeric|exists:gpu_tb,id',
                'upLaptopGPU2' => 'required|numeric|exists:gpu_tb,id',
                'upLaptopFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upLaptopRam' => 'required|string|max:50',
                'upLaptopScreen' => 'required|numeric|min:0',
                'upLaptopLocation' => 'required|numeric|exists:sites_activities,id'
            ];
        } else {
            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location) {
                $validLocations [] = $location->id;
            }

            $updateIDs = LaptopInventory::select('laptops_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'laptops_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID) {
                $validUpdateID [] = $updateID->id;
            }


            $deliveredLaptops = LaptopInventory::select('laptops_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'laptops_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredLaptops = [] ;

            foreach ($deliveredLaptops as $deliveredLaptop) {
                $allDeliveredLaptops [] = $deliveredLaptop->id;
            }


            return [
                'up_id' => 'required|numeric|in:' . implode(',', $validUpdateID) . '|not_in:' . implode(',', $allDeliveredLaptops),
                'serial_number' => 'required|string|max:50|unique:laptops_inventory,serial_number,' . $this->up_id,
                'upLaptopModel' => 'required|numeric|in:' . implode(',', $laptopModels),
                'upLaptopCPU' => 'required|numeric|exists:cpu_tb,id',
                'upLaptopHDD' => 'required|numeric|min:0|max:2147483647',
                'upLaptopSSD' => 'required|numeric|min:0|max:2147483647',
                'upLaptopOS' => 'required|numeric|exists:operating_systems,id',
                'upLaptopGPU1' => 'required|numeric|exists:gpu_tb,id',
                'upLaptopGPU2' => 'required|numeric|exists:gpu_tb,id',
                'upLaptopFlag' => 'required|numeric|exists:flags,id|not_in:2',
                'upLaptopRam' => 'required|string|max:50',
                'upLaptopScreen' => 'required|numeric|min:0',
                'upLaptopLocation' => 'required|numeric|in:' . implode(',', $validLocations)
            ];
        }

    }

    public function messages()
    {
        return [
            'upLaptopModel.required' => 'The field Model is required',
            'upLaptopCPU.required' => 'The field CPU is required',
            'upLaptopFlag.required' => 'The field Flag is required',
            'upLaptopGPU1.required' => 'The field Primary GPU is required',
            'upLaptopGPU2.required' => 'The field Secondary GPU is required',
            'upLaptopHDD.required' => 'The field HDD is required',
            'upLaptopSSD.required' => 'The field SSD is required',
            'upLaptopOS.required' => 'The field Operating System is required',
            'upLaptopRam.required' => 'The field Ram is required',
            'upLaptopLocation.required' => 'The field Location is required',
            'upLaptopScreen.required' => 'The field Screen Inch is required',

            'upLaptopModel.numeric' => 'The field Model must be a number',
            'upLaptopCPU.numeric' => 'The field CPU must be a number',
            'upLaptopFlag.numeric' => 'The field Flag must be a number',
            'upLaptopGPU1.numeric' => 'The field Primary GPU must be a number',
            'upLaptopGPU2.numeric' => 'The field Secondary GPU must be a number',
            'upLaptopSSD.numeric' => 'The field SSD must be a number',
            'upLaptopOS.numeric' => 'The field Operating System must be a number',
            'upLaptopHDD.numeric' => 'The field HDD must be a number',
            'upLaptopScreen.numeric' => 'The field Screen Inch must be a number',
            'upLaptopLocation.numeric' => 'The field Location must be a number',

            'upLaptopRam.string' => 'The field Ram must be string',

            'upLaptopModel.in' => 'The field Model is invalid',
            'upLaptopLocation.in' => 'The field Location is invalid',

            'upLaptopFlag.not_in' => 'The field Flag is invalid',
            'up_id.not_in' => 'This laptop delivered to employee u can not update it',

            'upLaptopRam.max' => 'The field Ram must not be greater than 50 characters',
            'upLaptopHDD.max' => 'The field HDD Storage Can not be greater than 2147483647',
            'upLaptopSSD.max' => 'The field SSD Storage Can not be greater than 2147483647',

            'upLaptopHDD.min' => 'The field HDD Storage must not be less than 0',
            'upLaptopSSD.min' => 'The field SSD Storage must not be less than 0',
            'upLaptopScreen.min' => 'The field Screen Inch must not be less than 0',

            'upLaptopCPU.exists' => 'The field CPU is invalid',
            'upLaptopGPU1.exists' => 'The field Primary GPU is invalid',
            'upLaptopGPU2.exists' => 'The field Secondary GPU is invalid',
            'upLaptopFlag.exists' => 'The field Flag is invalid',
            'upLaptopOS.exists' => 'The field Operating System is invalid',
            'upLaptopLocation.exists' => 'The field Location is invalid'
        ];
    }
}

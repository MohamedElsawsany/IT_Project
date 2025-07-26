<?php

namespace App\Http\Requests\inventories\PC;

use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\PCInventory;
use App\Models\Places\SiteActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePCRequest extends FormRequest
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

        $models = InvnetoryModelsModel::select('id')->where('category_name','=','pc')->get();
        $pcModels = [];
        foreach ($models as $model){
            $pcModels [] = $model->id;
        }
        if (Auth::user()->role_id == 1){

            $deliveredPCs = PCInventory::select('id')->where('flag_id','=',2)->get();

            $allDeliveredPCs = [] ;
            foreach ($deliveredPCs as $deliveredPC) {
                $allDeliveredPCs [] = $deliveredPC->id;
            }

            return [
                'up_id' => 'required|numeric|exists:pc_inventory,id|not_in:' . implode(',', $allDeliveredPCs),
                'serial_number' => 'required|string|max:50|unique:pc_inventory,serial_number,'. $this->up_id,
                'pc_model' => 'required|numeric|in:' .implode(',',$pcModels),
                'pc_cpu' => 'required|numeric|exists:cpu_tb,id',
                'pc_gpu1' => 'required|numeric|exists:gpu_tb,id',
                'pc_gpu2' => 'required|numeric|exists:gpu_tb,id',
                'pc_os' => 'required|numeric|exists:operating_systems,id',
                'pc_hdd' => 'required|numeric|min:0|max:2147483647',
                'pc_ssd' => 'required|numeric|min:0|max:2147483647',
                'pc_flag' => 'required|numeric|exists:flags,id|not_in:2',
                'pc_ram' => 'required|string|max:50',
                'pc_location' => 'required|numeric|exists:sites_activities,id'
            ];
        }else{
            $locations = SiteActivity::select('id')
                ->where('site_id', '=', Auth::user()->site_id)
                ->get();

            $validLocations = [];
            foreach ($locations as $location){
                $validLocations [] = $location->id;
            }

            $updateIDs = PCInventory::select('pc_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'pc_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validUpdateID = [];
            foreach ($updateIDs as $updateID){
                $validUpdateID [] = $updateID->id;
            }


            $deliveredPCs = PCInventory::select('pc_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'pc_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->where('flag_id','=',2)
                ->get();

            $allDeliveredPCs = [] ;
            foreach ($deliveredPCs as $deliveredPC) {
                $allDeliveredPCs [] = $deliveredPC->id;
            }


            return [
                'up_id' => 'required|numeric|in:' .implode(',',$validUpdateID). '|not_in:' . implode(',', $allDeliveredPCs),
                'serial_number' => 'required|string|max:50|unique:pc_inventory,serial_number,'. $this->up_id,
                'pc_model' => 'required|numeric|in:' .implode(',',$pcModels),
                'pc_cpu' => 'required|numeric|exists:cpu_tb,id',
                'pc_gpu1' => 'required|numeric|exists:gpu_tb,id',
                'pc_gpu2' => 'required|numeric|exists:gpu_tb,id',
                'pc_os' => 'required|numeric|exists:operating_systems,id',
                'pc_hdd' => 'required|numeric|min:0|max:2147483647',
                'pc_ssd' => 'required|numeric|min:0|max:2147483647',
                'pc_flag' => 'required|numeric|exists:flags,id|not_in:2',
                'pc_ram' => 'required|string|max:50',
                'pc_location' => 'required|numeric|in:' .implode(',',$validLocations)
            ];
        }
    }
    public function messages()
    {
        return [
            'pc_model.required' => 'The field Model is required',
            'pc_cpu.required' => 'The field CPU is required',
            'pc_os.required' => 'The field Operating System is required',
            'pc_flag.required' => 'The field Flag is required',
            'pc_gpu1.required' => 'The field Primary GPU is required',
            'pc_gpu2.required' => 'The field Secondary GPU is required',
            'pc_hdd.required' => 'The field HDD is required',
            'pc_ssd.required' => 'The field SSD is required',
            'pc_ram.required' => 'The field Ram is required',
            'pc_location.required' => 'The field Location is required',

            'pc_model.numeric' => 'The field Model must be a number',
            'pc_cpu.numeric' => 'The field CPU must be a number',
            'pc_flag.numeric' => 'The field Flag must be a number',
            'pc_gpu1.numeric' => 'The field Primary GPU must be a number',
            'pc_gpu2.numeric' => 'The field Secondary GPU must be a number',
            'pc_os.numeric' => 'The field Operating System must be a number',
            'pc_hdd.numeric' => 'The field HDD must be a number',
            'pc_ssd.numeric' => 'The field SSD must be a number',
            'pc_location.numeric' => 'The field Location must be a number',

            'pc_ram.string' => 'The field Ram must be string',

            'pc_model.in' => 'The field Model is invalid',
            'pc_location.in' => 'The field Location is invalid',

            'pc_flag.not_in' => 'The field Flag is invalid',
            'up_id.not_in' => 'This PC delivered to employee u can not update it',

            'pc_ram.max' => 'The field Ram must not be greater than 50 characters',
            'pc_hdd.max' => 'The field HDD Storage Can not be greater than 2147483647',
            'pc_ssd.max' => 'The field SSD Storage Can not be greater than 2147483647',

            'pc_hdd.min' => 'The field HDD Storage must not be less than 0',
            'pc_ssd.min' => 'The field SSD Storage must not be less than 0',

            'pc_cpu.exists' => 'The field CPU is invalid',
            'pc_gpu1.exists' => 'The field Primary GPU is invalid',
            'pc_gpu2.exists' => 'The field Secondary GPU is invalid',
            'pc_flag.exists' => 'The field Flag is invalid',
            'pc_os.exists' => 'The field Operating System is invalid',
            'pc_location.exists' => 'The field Location is invalid'
        ];
    }
}

<?php

namespace App\Http\Requests\inventories\PC;

use App\Models\Inventories\DeliveredPCInventory;
use App\Models\Inventories\PCInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedPCToStockRequest extends FormRequest
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
        if (Auth::user()->role_id == 1){


            return [

                'pcId' => 'required|numeric|exists:pc_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_pc_inventory,id'

            ];


        }else{

            $pcsIDs = PCInventory::select('pc_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'pc_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validPCsID = [];
            foreach ($pcsIDs as $pcsID) {
                $validPCsID [] = $pcsID->id;
            }

            $DeliveredPCsIDs = DeliveredPCInventory::select('delivered_pc_inventory.id')
                ->join('pc_inventory','pc_inventory.id','=','delivered_pc_inventory.pc_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'pc_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredPCsID = [];
            foreach ($DeliveredPCsIDs as $DeliveredPCsID) {
                $validDeliveredPCsID [] = $DeliveredPCsID->id;
            }

            return [

                'pcId' => 'required|numeric|in:' . implode(',', $validPCsID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredPCsID)

            ];

        }
    }
}

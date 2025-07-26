<?php

namespace App\Http\Requests\inventories\Modem;

use App\Models\Inventories\DeliveredModemInventory;
use App\Models\Inventories\ModemInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedModemToStockRequest extends FormRequest
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

                'modemId' => 'required|numeric|exists:modems_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_modems_inventory,id'

            ];


        }else{

            $modemsIDs = ModemInventory::select('modems_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'modems_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validModemsID = [];
            foreach ($modemsIDs as $modemsID) {
                $validModemsID [] = $modemsID->id;
            }

            $DeliveredModemsIDs = DeliveredModemInventory::select('delivered_modems_inventory.id')
                ->join('modems_inventory','modems_inventory.id','=','delivered_modems_inventory.modem_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'modems_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredModemsID = [];
            foreach ($DeliveredModemsIDs as $DeliveredModemsID) {
                $validDeliveredModemsID [] = $DeliveredModemsID->id;
            }

            return [

                'modemId' => 'required|numeric|in:' . implode(',', $validModemsID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredModemsID)

            ];

        }
    }
}

<?php

namespace App\Http\Requests\inventories\AccessPoint;

use App\Models\Inventories\AccessPointInventory;
use App\Models\Inventories\DeliveredAccessPointInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedAccessPointToStockRequest extends FormRequest
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

                'accessPointId' => 'required|numeric|exists:access_points_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_access_points_inventory,id'

            ];


        }else{

            $accessPointsIDs = AccessPointInventory::select('access_points_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'access_points_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validAccessPointsID = [];
            foreach ($accessPointsIDs as $accessPointsID) {
                $validAccessPointsID [] = $accessPointsID->id;
            }

            $DeliveredAccessPointsIDs = DeliveredAccessPointInventory::select('delivered_access_points_inventory.id')
                ->join('access_points_inventory','access_points_inventory.id','=','delivered_access_points_inventory.access_point_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'access_points_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredAccessPointsID = [];
            foreach ($DeliveredAccessPointsIDs as $DeliveredAccessPointsID) {
                $validDeliveredAccessPointsID [] = $DeliveredAccessPointsID->id;
            }

            return [

                'accessPointId' => 'required|numeric|in:' . implode(',', $validAccessPointsID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredAccessPointsID)

            ];

        }
    }
}

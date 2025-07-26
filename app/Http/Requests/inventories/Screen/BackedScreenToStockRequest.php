<?php

namespace App\Http\Requests\inventories\Screen;

use App\Models\Inventories\DeliveredScreenInventory;
use App\Models\Inventories\ScreenInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedScreenToStockRequest extends FormRequest
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

                'screenId' => 'required|numeric|exists:screens_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_screens_inventory,id'

            ];


        }else{

            $screensIDs = ScreenInventory::select('screens_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'screens_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validScreensID = [];
            foreach ($screensIDs as $screensID) {
                $validScreensID [] = $screensID->id;
            }

            $DeliveredScreensIDs = DeliveredScreenInventory::select('delivered_screens_inventory.id')
                ->join('screens_inventory','screens_inventory.id','=','delivered_screens_inventory.screen_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'screens_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredScreensID = [];
            foreach ($DeliveredScreensIDs as $DeliveredScreensID) {
                $validDeliveredScreensID [] = $DeliveredScreensID->id;
            }

            return [

                'screenId' => 'required|numeric|in:' . implode(',', $validScreensID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredScreensID)

            ];

        }
    }
}

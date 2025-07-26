<?php

namespace App\Http\Requests\inventories\Laptop;

use App\Models\Inventories\DeliveredLaptopInventory;
use App\Models\Inventories\LaptopInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BackedLaptopToStockRequest extends FormRequest
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

                'laptopId' => 'required|numeric|exists:laptops_inventory,id',
                'deliveredId' => 'required|numeric|exists:delivered_laptops_inventory,id'

            ];


        }else{

            $laptopsIDs = LaptopInventory::select('laptops_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'laptops_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validLaptopsID = [];
            foreach ($laptopsIDs as $laptopsID) {
                $validLaptopsID [] = $laptopsID->id;
            }

            $DeliveredLaptopsIDs = DeliveredLaptopInventory::select('delivered_laptops_inventory.id')
                ->join('laptops_inventory','laptops_inventory.id','=','delivered_laptops_inventory.laptop_id')
                ->join('sites_activities', 'sites_activities.id', '=', 'laptops_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeliveredLaptopsID = [];
            foreach ($DeliveredLaptopsIDs as $DeliveredLaptopID) {
                $validDeliveredLaptopsID [] = $DeliveredLaptopID->id;
            }

            return [

                'laptopId' => 'required|numeric|in:' . implode(',', $validLaptopsID),
                'deliveredId' => 'required|numeric|in:' . implode(',', $validDeliveredLaptopsID)

            ];

        }

    }
}

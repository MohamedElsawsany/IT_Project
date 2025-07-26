<?php

namespace App\Http\Requests\inventories\AccessPoint;

use App\Models\Inventories\AccessPointInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SoftDeleteAccessPointRequest extends FormRequest
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
        if (Auth::user()->role_id == 1) {

            return [
                'id' => 'required|numeric|exists:access_points_inventory,id'
            ];

        } else {

            $validIDS = AccessPointInventory::select('access_points_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'access_points_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validDeleteIDs = [];
            foreach ($validIDS as $validID) {
                $validDeleteIDs [] = $validID->id;
            }

            return [
                'id' => 'required|numeric|in:' . implode(',', $validDeleteIDs)
            ];
        }

    }
}

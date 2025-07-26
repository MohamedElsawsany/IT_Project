<?php

namespace App\Http\Requests\inventories\Screen;

use App\Models\Inventories\ScreenInventory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SoftDeleteScreenRequest extends FormRequest
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
                'id' => 'required|numeric|exists:screens_inventory,id',
            ];

        }else{

            $ids = ScreenInventory::select('screens_inventory.id')
                ->join('sites_activities', 'sites_activities.id', '=', 'screens_inventory.site_activity_id')
                ->where('sites_activities.site_id', '=', Auth::user()->site_id)
                ->get();

            $validID = [];
            foreach ($ids as $id){
                $validID [] = $id->id;
            }

            return [
                'id' => 'required|numeric|in:' .implode(',',$validID),
            ];

        }

    }

}

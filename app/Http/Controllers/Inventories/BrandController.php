<?php

namespace App\Http\Controllers\Inventories;
use App\Http\Controllers\Controller;
use App\Models\Inventories\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
           'brand_name' => 'required|string|max:50|unique:brands'
        ]);
        try {
            Brand::create([
                'brand_name'=> $request->brand_name,
                'created_by' => Auth::user()->id,
            ]);

            return response()->json([
               'status' => 'success'
            ]);
        }catch(\Exception $e){
            return response()->json(
                [
                    'error'=> 'Maybe server error or error data please try again :)',
                ]
            );
        }
    }

    public function getAllBrands(){

        $brands = Brand::select('id','brand_name')->get();
        $selection = '<option disabled value="0" selected>Select Brand</option>';
        foreach ($brands as $brand){
            $selection .= '<option value=' . $brand->id . '>' . $brand->brand_name . '</option>';
        }

        return $selection;
    }
}

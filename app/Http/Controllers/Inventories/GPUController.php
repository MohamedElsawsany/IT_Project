<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Models\Inventories\GPU;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GPUController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'gpu_name' => 'required|string|max:50|unique:gpu_tb'
        ]);
        try {
            GPU::create([
                'gpu_name'=> $request->gpu_name,
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

    public function getAllGPU(){

        $gpus = GPU::select('id','gpu_name')->get();
        $selection = '<option disabled value="0" selected>Select GPU</option>';
        foreach ($gpus as $gpu){
            $selection .= '<option value=' . $gpu->id . '>' . $gpu->gpu_name . '</option>';
        }

        return $selection;
    }
}

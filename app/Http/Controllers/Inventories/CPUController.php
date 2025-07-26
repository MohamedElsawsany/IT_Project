<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Models\Inventories\CPU;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CPUController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'cpu_name' => 'required|string|max:50|unique:cpu_tb'
        ]);
        try {
            CPU::create([
                'cpu_name'=> $request->cpu_name,
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

    public function getAllCPU(){

        $cpus = CPU::select('id','cpu_name')->get();
        $selection = '<option disabled value="0" selected>Select CPU</option>';
        foreach ($cpus as $cpu){
            $selection .= '<option value=' . $cpu->id . '>' . $cpu->cpu_name . '</option>';
        }

        return $selection;
    }
}

<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Models\Inventories\OS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OSController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'os_name' => 'required|string|max:50|unique:operating_systems'
        ]);
        try {
            OS::create([
                'os_name'=> $request->os_name,
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

    public function getAllOperatingSystems(){

        $operating_systems = OS::select('id','os_name')->get();
        $selection = '<option disabled value="0" selected>Select Operating Systems</option>';
        foreach ($operating_systems as $operating_system){
            $selection .= '<option value=' . $operating_system->id . '>' . $operating_system->os_name . '</option>';
        }
        return $selection;
    }
}

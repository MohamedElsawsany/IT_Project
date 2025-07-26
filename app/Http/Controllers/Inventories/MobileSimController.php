<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\MobileSim\StoreMobileSimRequest;
use App\Http\Requests\inventories\MobileSim\UpdateMobileSimRequest;
use App\Models\EmployeesData\Employee;
use App\Models\Inventories\MobileSim;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MobileSimController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $employees = Employee::select('id', 'emp_name')->get();
            return view('inventories.mobiles_sims_inventories.index', compact('employees'));
        }

    }

    public function store(StoreMobileSimRequest $request)
    {

        if (Auth::user()->role_id == 1) {
            try {
                MobileSim::create([
                    'serial_number' => $request->serial_number,
                    'mobile_number' => $request->mobileSimNumber,
                    'ip' => $request->mobileSimIP,
                    'assigned_to' => $request->mobileSimAssignTo,
                    'created_by' => Auth::user()->id
                ]);

                return response()->json([
                    'status' => 'success'
                ]);
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'error' => $e->getMessage(),
                    ]
                );
            }
        }

    }

    public function getAllMobiles(Request $request)
    {

        if (Auth::user()->role_id == 1) {
            $mobilesSim = DB::table('mobiles_sim_inventories as t1')
                ->join('employees as t2', 't1.assigned_to', '=', 't2.id')
                ->join('users as t3', 't1.created_by', '=', 't3.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't1.ip as ip', 't1.mobile_number as mobile_number', 't3.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.id as emp_id', 't2.emp_name as emp_name')
                ->whereNull('t1.deleted_at');

            if ($request->ajax()) {
                $allData = DataTables::of($mobilesSim)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" id="editMobileSimLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editMobileSimModal"
                    data-mobile_sim_id="' . $row->id . '"
                    data-mobile_sim_serial_number="' . $row->serial_number . '"
                    data-mobile_sim_number="' . $row->mobile_number . '"
                    data-mobile_sim_ip="' . $row->ip . '"
                    data-mobile_sim_emp_name="' . $row->emp_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteMobileSimLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteMobileSimModal" data-mobile_sim_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->setRowData(['align' => 'center'])
                    ->toJson();
                return $allData;
            }
        }

    }


    public function update(UpdateMobileSimRequest $request)
    {

        if (Auth::user()->role_id == 1) {
            try {
                MobileSim::where('id', $request->upMobileSimId)->update(
                    [
                        'serial_number' => $request->serial_number,
                        'mobile_number' => $request->upMobileSimNumber,
                        'ip' => $request->upMobileSimIP,
                        'assigned_to' => $request->upMobileSimAssignTo,
                        'created_by' => Auth::user()->id
                    ]
                );
                return response()->json(
                    [
                        'status' => 'success'
                    ]
                );
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'error' => 'Server error please contact your administrator',
                    ]
                );

            }
        }

    }

    public function softDelete(Request $request)
    {

        if (Auth::user()->role_id == 1) {
            $request->validate([
                'id' => 'required|numeric|exists:mobiles_sim_inventories,id'
            ]);
            try {
                MobileSim::where('id', $request->id)->update(
                    [
                        'created_by' => Auth::user()->id,
                    ]
                );
                MobileSim::destroy($request->id);
                return response()->json(
                    [
                        'status' => 'success'
                    ]
                );
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'error' => 'Server error please contact your administrator',
                    ]
                );

            }
        }

    }

}

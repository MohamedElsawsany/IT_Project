<?php

namespace App\Http\Controllers\EmployeesData;

use App\Http\Controllers\Controller;
use App\Models\EmployeesData\Department;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EmployeeDepartmentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return view('employees_data.employees_departments.index');
        } else {
            return redirect('logout');
        }
    }

    public function getAllEmployeesDepartments(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $departments = DB::table('employees_departments as t1')
                ->join('users as t2', 't1.created_by', '=', 't2.id')
                ->select('t1.id as id', 't2.name as creator', 't1.department_name as department_name', 't1.created_at as created_at', 't1.updated_at as updated_at')
                ->whereNull('t1.deleted_at');

            if ($request->ajax()) {
                $allData = DataTables::of($departments)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" id="editEmployeeDepartmentLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editEmployeeDepartmentModal"
                           data-id="' . $row->id . '"
                           data-departmentname="' . $row->department_name . '"
                            ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteEmployeeDepartmentLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteEmployeeDepartmentModal" data-id="' . $row->id . '" data-departmentname="' . $row->department_name . '"><i class="fa fa-trash"></i> Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->toJson();
                return $allData;
            }
        } else {
            return redirect('logout');
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $request->validate([
                'department_name' => 'required|string|max:50|unique:employees_departments',
            ]);
            try {
                Department::create([
                    'department_name' => $request->department_name,
                    'created_by' => Auth::user()->id
                ]);

                return response()->json([
                    'status' => 'success'
                ]);
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'error' => 'Server error please contact your administrator',
                    ]
                );
            }
        } else {
            return redirect('logout');
        }

    }

    public function softDelete(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $request->validate([
                    'id' => 'required|numeric|exists:employees_departments,id',
                ]
            );

            try {
                Department::where('id', $request->id)->update(
                    [
                        'created_by' => Auth::user()->id,
                    ]
                );
                Department::destroy($request->id);
                return response()->json(
                    [
                        'status' => 'success'
                    ]
                );
            } catch (\Exception $e) {
                $errorCode = $e->getCode();

                if ($errorCode === '23000') {
                    $errorMessage = "This department has a relationship with another table. You can't delete it.";
                } else {
                    $errorMessage = 'Server error please contact your administrator';
                }
                return response()->json(
                    [
                        'error' => $errorMessage,
                    ]
                );

            }
        } else {
            return redirect('logout');
        }
    }

//
    public function update(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $request->validate([
                    'department_name' => 'required|string|max:50|unique:employees_departments,department_name,' . $request->id,
                    'id' => 'required|numeric|exists:employees_departments,id',
                ]
            );

            try {
                Department::where('id', $request->id)->update(
                    [
                        'department_name' => $request->department_name,
                        'created_by' => Auth::user()->id,
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
        } else {
            return redirect('logout');
        }
    }

//    public function viewDeletedIndex()
//    {
//        if (Auth::user()->role_id == 1) {
//
//            return view('employees_data.employees_departments.viewDeletedEmployeesDepartments');
//        } else {
//            return redirect('logout');
//        }
//    }

//
//    public function viewDeletedEmployeesDepartments(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            if ($request->ajax()) {
//                $departments = DB::table('employees_departments as t1')
//                    ->join('users as t2', 't1.created_by', '=', 't2.id')
//                    ->select('t1.id as id', 't2.name as creator', 't1.department_name as department_name', 't1.created_at as created_at', 't1.updated_at as updated_at', 't1.deleted_at as deleted_at')
//                    ->whereNotNull('t1.deleted_at');
//
//                $allData = DataTables::of($departments)
//                    ->addColumn('action', function ($row) {
//                        $btn = ' <a href="javascript:void(0)" id="forceDeleteEmployeeDepartmentLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forceDeleteEmployeeDepartmentModal" data-id="' . $row->id . '" data-departmentname="' . $row->department_name . '"><i class="fa fa-trash"></i> Delete Forever</a>';
//                        $btn .= ' <a href="javascript:void(0)" id="restoreDeltedEmployeeDepartmentLink" class="btn btn-outline-dark btn-sm" data-id="' . $row->id . '"><i class="fas fa-trash-restore"></i> Restore</a>';
//                        return $btn;
//                    })
//                    ->rawColumns(['action'])
//                    ->toJson();
//                return $allData;
//            }
//        } else {
//            return redirect('logout');
//        }
//    }

//
//    public function forceDelete(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $request->validate([
//                    'id' => 'required|numeric|exists:employees_departments,id',
//                ]
//            );
//
//            try {
//                Department::withTrashed()->where('id', $request->id)->forceDelete();
//                return response()->json(
//                    [
//                        'status' => 'success'
//                    ]
//                );
//            } catch (\Exception $e) {
//                return response()->json(
//                    [
//                        'error' => 'Server error please contact your administrator',
//                    ]
//                );
//
//            }
//        } else {
//            return redirect('logout');
//        }
//    }

//
//    public function restoreDeletedEmployeesDepartments(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $request->validate([
//                    'id' => 'required|numeric|exists:employees_departments,id',
//                ]
//            );
//
//            try {
//
//                Department::onlyTrashed()->where('id', $request->id)->restore();
//                Department::where('id', $request->id)->update([
//                    'created_by' => Auth::user()->id,
//                ]);
//                return response()->json(
//                    [
//                        'status' => 'success'
//                    ]
//                );
//            } catch (\Exception $e) {
//                return response()->json(
//                    [
//                        'error' => 'Server error please contact your administrator',
//                    ]
//                );
//
//            }
//        } else {
//            return redirect('logout');
//        }
//    }
}

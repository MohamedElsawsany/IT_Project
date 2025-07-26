<?php

namespace App\Http\Controllers\EmployeesData;

use App\Http\Controllers\Controller;
use App\Models\EmployeesData\Department;
use App\Models\EmployeesData\Employee;
use App\Models\Places\SiteActivity;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function index()
    {
        $departments = Department::select('id','department_name')->get();
        return view('employees_data.employees.index',compact('departments'));
    }

    public function getAllEmployees(Request $request)
    {

            $employees = DB::table('employees as t1')
                ->join('users as t2', 't1.created_by', '=', 't2.id')
                ->leftJoin('employees_departments as t3', 't1.department_id', '=', 't3.id')
                ->select('t1.id as id', 't1.emp_name as emp_name','t3.department_name as department_name', 't2.name as creator',
                    't1.updated_at as updated_at','t1.created_at as created_at','t1.department_id')
                ->whereNull('t1.deleted_at');


        if ($request->ajax()) {
            $allData = DataTables::of($employees)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="editEmployeeLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editEmployeeModal"
                           data-id="' . $row->id . '"
                           data-emp_name="' . $row->emp_name . '"
                           data-emp_department="' . $row->department_id . '"
                            ><i class="fa fa-edit"></i> Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" id="deleteEmployeeLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteEmployeeModal" data-id="' . $row->id . '" data-empname="' . $row->emp_name . '"><i class="fa fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $allData;
        }
    }

    public function store(Request $request)
    {

            $request->validate([
                'employee_name' => 'required|string|max:100',
                'departmentName' => 'required|integer|min:1'
            ]);


        try {
            Employee::create([
                'emp_name' => $request->employee_name,
                'department_id' => $request->departmentName,
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

    }

    public function softDelete(Request $request)
    {

            $request->validate([
                    'id' => 'required|numeric|exists:employees,id'
                ]
            );

        try {
            Employee::where('id', $request->id)->update(
                [
                    'created_by' => Auth::user()->id,
                ]
            );
            Employee::destroy($request->id);
            return response()->json(
                [
                    'status' => 'success'
                ]
            );
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            if ($errorCode === '23000') {
                $errorMessage = "This employee has a relationship with another table. You can't delete it.";
            } else {
                $errorMessage = 'Server error please contact your administrator';
            }
            return response()->json(
                [
                    'error' => $errorMessage,
                ]
            );

        }

    }

    public function update(Request $request)
    {

            $request->validate([
                    'emp_name' => 'required|string|max:100',
                    'upDepartmentName' => 'required|integer|min:1',
                    'id' => 'required|numeric|min:1|exists:employees,id'
                ]
            );

        try {
            Employee::where('id', $request->id)->update(
                [
                    'emp_name' => $request->emp_name,
                    'department_id' => $request->upDepartmentName,
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

//    public function viewDeletedIndex()
//    {
//        return view('employees_data.employees.viewDeletedEmployees');
//    }

//    public function viewDeletedEmployees(Request $request)
//    {
//        if ($request->ajax()) {
//
//                $employees = DB::table('employees as t1')
//                    ->join('users as t2', 't1.created_by', '=', 't2.id')
//                    ->leftJoin('employees_departments as t3', 't1.department_id', '=', 't3.id')
//                    ->select('t1.id as id', 't1.emp_name as emp_name', 't3.department_name as department_name',
//                        't1.created_at as created_at', 't1.updated_at as updated_at',
//                        't1.deleted_at as deleted_at', 't2.name as creator')
//                    ->whereNotNull('t1.deleted_at');
//
//            $allData = DataTables::of($employees)
//                ->addColumn('action', function ($row) {
//                    $btn = ' <a href="javascript:void(0)" id="forceDeleteEmployeeLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forceDeleteEmployeeModal" data-id="' . $row->id . '" data-empname="' . $row->emp_name . '"><i class="fa fa-trash"></i> Delete Forever</a>';
//                    $btn .= ' <a href="javascript:void(0)" id="restoreDeltedEmployeeLink" class="btn btn-outline-dark btn-sm" data-id="' . $row->id . '"><i class="fas fa-trash-restore"></i> Restore</a>';
//                    return $btn;
//                })
//                ->rawColumns(['action'])
//                ->toJson();
//            return $allData;
//        }
//    }

//    public function forceDelete(Request $request)
//    {
//            $request->validate([
//                    'id' => 'required|numeric|exists:employees,id',
//                ]
//            );
//
//
//        try {
//            Employee::withTrashed()->where('id', $request->id)->forceDelete();
//            return response()->json(
//                [
//                    'status' => 'success'
//                ]
//            );
//        } catch (\Exception $e) {
//            return response()->json(
//                [
//                    'error' => 'Server error please contact your administrator',
//                ]
//            );
//
//        }
//
//    }

//    public function restoreDeletedEmployees(Request $request)
//    {
//
//            $request->validate([
//                    'id' => 'required|numeric|exists:employees,id',
//                ]
//            );
//
//
//        try {
//
//            Employee::onlyTrashed()->where('id', $request->id)->restore();
//            Employee::where('id', $request->id)->update([
//                'created_by' => Auth::user()->id,
//            ]);
//            return response()->json(
//                [
//                    'status' => 'success'
//                ]
//            );
//        } catch (\Exception $e) {
//            return response()->json(
//                [
//                    'error' => 'Server error please contact your administrator',
//                ]
//            );
//
//        }
//
//    }

    public function getAllEmployeesJson(Request $request)
    {

        if ($request->ajax()) {
            $term = trim($request->term);
            $employees = DB::table('employees as t1')
                ->leftJoin('employees_departments as t2', 't1.department_id', '=', 't2.id')
                ->select('t1.id as id', DB::raw('CONCAT("(", t1.emp_name, ")", " - ", "(", IFNULL(t2.department_name, "N/A"), ")") AS text'))
                ->where(function ($query) use ($term) {
                    $query->where('t1.emp_name', 'LIKE', '%' . $term . '%')
                        ->orWhere('t2.department_name', 'LIKE', '%' . $term . '%');
                })
                ->orderBy('t1.id', 'asc')
                ->simplePaginate(10);

            $morePages = true;
            $pagination_obj = json_encode($employees);
            if (empty($employees->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $employees->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return \Response::json($results);
        }

    }
}

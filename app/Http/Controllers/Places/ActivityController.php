<?php

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Models\Places\Activity;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ActivityController extends Controller
{

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return view('places.activities.index');
        } else {
            return redirect('logout');
        }
    }

    public function getAllActivities(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $activities = DB::table('activities as t1')
                ->join('users as t2', 't1.created_by', '=', 't2.id')
                ->select('t1.activity_name as name', 't1.id as id', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.name as creator')
                ->whereNull('t1.deleted_at');

            if ($request->ajax()) {
                $allData = DataTables::of($activities)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" id="editActivityLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editActivityModal"
                           data-id="' . $row->id . '"
                           data-activityname="' . $row->name . '"
                        ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteActivityLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteActivityModal" data-id="' . $row->id . '" data-activityname="' . $row->name . '"><i class="fa fa-trash"></i> Delete</a>';

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
                'activity_name' => 'required|string|max:50|unique:activities',
            ]);
            try {
                Activity::create([
                    'activity_name' => $request->activity_name,
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

//
    public function softDelete(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $request->validate([
                    'id' => 'required|numeric|exists:activities,id',
                ]
            );

            try {
                Activity::where('id', $request->id)->update(
                    [
                        'created_by' => Auth::user()->id,
                    ]
                );
                Activity::destroy($request->id);
                return response()->json(
                    [
                        'status' => 'success'
                    ]
                );
            } catch (\Exception $e) {
                $errorCode = $e->getCode();

                if ($errorCode === '23000') {
                    $errorMessage = "This activity has a relationship with another table. You can't delete it.";
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
                    'activity_name' => 'required|string|max:50|unique:activities,activity_name,' . $request->id,
                    'id' => 'required|numeric|exists:activities,id',
                ]
            );

            try {
                Activity::where('id', $request->id)->update(
                    [
                        'activity_name' => $request->activity_name,
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
//            return view('places.activities.viewDeletedActivity');
//        } else {
//            return redirect('logout');
//        }
//    }

//    public function viewDeletedActivites(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $activities = DB::table('activities as t1')
//                ->join('users as t2', 't1.created_by', '=', 't2.id')
//                ->select('t1.activity_name as name', 't1.id as id', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.name as creator', 't1.deleted_at as deleted_at')
//                ->whereNotNull('t1.deleted_at');
//
//            $allData = DataTables::of($activities)
//                ->addColumn('action', function ($row) {
//                    $btn = ' <a href="javascript:void(0)" id="forceDeleteActivityLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forceDeleteActivityModal" data-id="' . $row->id . '" data-Activityname="' . $row->name . '"><i class="fa fa-trash"></i> Delete Forever</a>';
//                    $btn .= ' <a href="javascript:void(0)" id="restoreDeltedActivityLink" class="btn btn-outline-dark btn-sm" data-id="' . $row->id . '"><i class="fas fa-trash-restore"></i> Restore</a>';
//                    return $btn;
//                })
//                ->rawColumns(['action'])
//                ->toJson();
//            return $allData;
//        } else {
//            return redirect('logout');
//        }
//    }


//    public function forceDelete(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $request->validate([
//                    'id' => 'required|numeric|exists:activities,id',
//                ]
//            );
//
//            try {
//                Activity::withTrashed()->where('id', $request->id)->forceDelete();
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

//    public function restoreDeletedActivities(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $request->validate([
//                    'id' => 'required|numeric|exists:activities,id',
//                ]
//            );
//
//            try {
//
//                Activity::onlyTrashed()->where('id', $request->id)->restore();
//                Activity::where('id', $request->id)->update([
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
//
//    }


}

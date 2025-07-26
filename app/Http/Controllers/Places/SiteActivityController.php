<?php

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Models\Places\Activity;
use App\Models\Places\Site;
use App\Models\Places\SiteActivity;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SiteActivityController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {

            $sites = Site::get();
            $activities = Activity::get();
            return view('places.sites_activities.index', compact('sites', 'activities'));
        } else {
            return redirect('logout');
        }
    }

    public function getAllSitesActivities(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $activities = DB::table('sites_activities as t1')
                ->join('users as t2', 't1.created_by', '=', 't2.id')
                ->join('sites as t3', 't1.site_id', '=', 't3.id')
                ->join('activities as t4', 't1.activity_id', '=', 't4.id')
                ->join('governorates as t5', 't3.governorate_id', '=', 't5.id')
                ->select('t1.activity_id as activity_id', 't1.site_id as site_id', 't1.id as id', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.name as creator', 't3.site_name as site_name', 't4.activity_name as activity_name', 't5.governorate_name as governorate_name')
                ->whereNull('t1.deleted_at')
                ->orderBy('t3.site_name');


            if ($request->ajax()) {
                $allData = DataTables::of($activities)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" id="editSiteActivityLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editSiteActivityModal"
                           data-id="' . $row->id . '"
                           data-activityid="' . $row->activity_id . '"
                           data-siteid="' . $row->site_id . '"
                        ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteSiteActivityLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteSiteActivityModal" data-id="' . $row->id . '" data-siteactivityname="' . $row->site_name . "&#92;" . $row->activity_name . '"><i class="fa fa-trash"></i> Delete</a>';

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
                'site_name' => 'required|numeric|exists:sites,id',
                'activity_name' => 'required|numeric|exists:activities,id',
            ]);
            try {
                SiteActivity::create([
                    'site_id' => $request->site_name,
                    'activity_id' => $request->activity_name,
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
                    'id' => 'required|numeric|exists:sites_activities,id',
                ]
            );

            try {
                SiteActivity::where('id', $request->id)->update(
                    [
                        'created_by' => Auth::user()->id,
                    ]
                );
                SiteActivity::destroy($request->id);
                return response()->json(
                    [
                        'status' => 'success'
                    ]
                );
            } catch (\Exception $e) {
                $errorCode = $e->getCode();

                if ($errorCode === '23000') {
                    $errorMessage = "This site activity has a relationship with another table. You can't delete it.";
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
                    'activity_name' => 'required|numeric|exists:activities,id',
                    'site_name' => 'required|numeric|exists:sites,id',
                    'id' => 'required|numeric|exists:sites_activities,id',
                ]
            );

            try {
                SiteActivity::where('id', $request->id)->update(
                    [
                        'activity_id' => $request->activity_name,
                        'site_id' => $request->site_name,
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
//            return view('places.sites_activities.viewDeletedSiteActivity');
//        } else {
//            return redirect('logout');
//        }
//    }

//    public function viewDeletedSitesActivites(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//
//            $activities = DB::table('sites_activities as t1')
//                ->join('users as t2', 't1.created_by', '=', 't2.id')
//                ->join('sites as t3', 't1.site_id', '=', 't3.id')
//                ->join('activities as t4', 't1.activity_id', '=', 't4.id')
//                ->join('governorates as t5', 't3.governorate_id', '=', 't5.id')
//                ->select('t1.activity_id as activity_id', 't1.deleted_at as deleted_at', 't1.site_id as site_id', 't1.id as id', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.name as creator', 't3.site_name as site_name', 't4.activity_name as activity_name', 't5.governorate_name as governorate_name')
//                ->whereNotNull('t1.deleted_at');
//
//            $allData = DataTables::of($activities)
//                ->addColumn('action', function ($row) {
//                    $btn = ' <a href="javascript:void(0)" id="forceDeleteSiteActivityLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forceDeleteSiteActivityModal" data-id="' . $row->id . '" data-siteactivityname="' . $row->site_name . "&#92;" . $row->activity_name . '"><i class="fa fa-trash"></i> Delete Forever</a>';
//                    $btn .= ' <a href="javascript:void(0)" id="restoreDeltedSiteActivityLink" class="btn btn-outline-dark btn-sm" data-id="' . $row->id . '"><i class="fas fa-trash-restore"></i> Restore</a>';
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
//
//            $request->validate([
//                    'id' => 'required|numeric|exists:sites_activities,id',
//                ]
//            );
//
//            try {
//                SiteActivity::withTrashed()->where('id', $request->id)->forceDelete();
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

//    public function restoreDeletedSiteActivities(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//
//            $request->validate([
//                    'id' => 'required|numeric|exists:sites_activities,id',
//                ]
//            );
//
//            try {
//
//                SiteActivity::onlyTrashed()->where('id', $request->id)->restore();
//                SiteActivity::where('id', $request->id)->update([
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

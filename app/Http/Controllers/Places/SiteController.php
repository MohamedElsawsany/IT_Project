<?php

namespace App\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use App\Models\Places\Governorate;
use App\Models\Places\Site;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SiteController extends Controller
{

    public function index()
    {
        if (Auth::user()->role_id == 1) {

            $governorates = Governorate::get();
            return view('places.sites.index', compact('governorates'));
        } else {
            return redirect('logout');
        }
    }

    public function getAllSites(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $sites = DB::table('sites as t1')
                ->join('users as t2', 't1.created_by', '=', 't2.id')
                ->join('governorates as t3', 't1.governorate_id', '=', 't3.id')
                ->select('t1.site_name as name', 't1.id as id', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.name as creator', 't3.governorate_name', 't1.governorate_id')
                ->whereNull('t1.deleted_at');

            if ($request->ajax()) {
                $allData = DataTables::of($sites)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" id="editSiteLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editSiteModal"
                           data-id="' . $row->id . '"
                           data-site="' . $row->name . '"
                           data-governorate="' . $row->governorate_id . '"
                        ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteSiteLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteSiteModal" data-id="' . $row->id . '" data-sitename="' . $row->name . '"><i class="fa fa-trash"></i> Delete</a>';

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
                'site_name' => 'required|string|max:50|unique:sites',
                'governorate' => 'required|numeric|exists:governorates,id'
            ]);
            try {
                Site::create([
                    'site_name' => $request->site_name,
                    'governorate_id' => $request->governorate,
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
                    'id' => 'required|numeric|exists:sites,id',
                ]
            );

            try {
                Site::where('id', $request->id)->update(
                    [
                        'created_by' => Auth::user()->id,
                    ]
                );
                Site::destroy($request->id);
                return response()->json(
                    [
                        'status' => 'success'
                    ]
                );
            } catch (\Exception $e) {
                $errorCode = $e->getCode();

                if ($errorCode === '23000') {
                    $errorMessage = "This site has a relationship with another table. You can't delete it.";
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

    public function update(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $request->validate([
                    'site_name' => 'required|string|max:50|unique:sites,site_name,' . $request->id,
                    'governorate' => 'required|numeric|exists:governorates,id',
                    'id' => 'required|numeric|exists:sites,id',
                ]
            );

            try {
                Site::where('id', $request->id)->update(
                    [
                        'site_name' => $request->site_name,
                        'governorate_id' => $request->governorate,
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
//            return view('places.sites.viewDeletedSites');
//        } else {
//            return redirect('logout');
//        }
//    }

//    public function viewDeletedSites(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            if ($request->ajax()) {
//                $sites = DB::table('sites as t1')
//                    ->join('users as t2', 't1.created_by', '=', 't2.id')
//                    ->join('governorates as t3', 't1.governorate_id', '=', 't3.id')
//                    ->select('t1.site_name as name', 't1.id as id', 't1.created_at as created_at', 't1.updated_at as updated_at', 't2.name as creator', 't3.governorate_name', 't1.governorate_id', 't1.deleted_at as deleted_at')
//                    ->whereNotNull('t1.deleted_at');
//
//                $allData = DataTables::of($sites)
//                    ->addColumn('action', function ($row) {
//                        $btn = ' <a href="javascript:void(0)" id="forceDeleteSiteLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forceDeleteSiteModal" data-id="' . $row->id . '" data-sitename="' . $row->name . '"><i class="fa fa-trash"></i> Delete Forever</a>';
//                        $btn .= ' <a href="javascript:void(0)" id="restoreDeltedSiteLink" class="btn btn-outline-dark btn-sm" data-id="' . $row->id . '"><i class="fas fa-trash-restore"></i> Restore</a>';
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


//    public function forceDelete(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $request->validate([
//                    'id' => 'required|numeric|exists:sites,id',
//                ]
//            );
//
//            try {
//                Site::withTrashed()->where('id', $request->id)->forceDelete();
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


//    public function restoreDeletedSites(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//            $request->validate([
//                    'id' => 'required|numeric|exists:sites,id',
//                ]
//            );
//
//            try {
//
//                Site::onlyTrashed()->where('id', $request->id)->restore();
//                Site::where('id', $request->id)->update([
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

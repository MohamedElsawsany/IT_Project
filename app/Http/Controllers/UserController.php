<?php

namespace App\Http\Controllers;

use App\Models\Places\Site;
use App\Models\Role;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()->role_id == 1) {

            $sites = Site::get();
            $roles = Role::get();

            return view('users.index', compact('sites', 'roles'));
        } else {
            return redirect('logout');
        }
    }

    public function getAllUsers(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $users = DB::table('users as t1')
                ->join('sites as t3', 't1.site_id', '=', 't3.id')
                ->join('roles as t4', 't1.role_id', '=', 't4.id')
                ->join('users as t2', 't2.id', '=', 't1.created_by')
                ->select('t1.name as name', 't1.id as id', 't1.email as email', 't1.created_at as created_at', 't1.updated_at as updated_at', 't1.role_id as role_id', 't1.site_id as site_id', 't3.site_name as site_name', 't4.role_name as role_name', 't2.name as creator')
                ->whereNull('t1.deleted_at');

            if ($request->ajax()) {
                $allData = DataTables::of($users)
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="javascript:void(0)" id="editUserLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editUserModal"
                           data-id="' . $row->id . '"
                           data-username="' . $row->name . '"
                           data-email="' . $row->email . '"
                           data-role="' . $row->role_id . '"
                           data-site="' . $row->site_id . '"
                        ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteUserLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal" data-id="' . $row->id . '" data-username="' . $row->name . '"><i class="fa fa-trash"></i> Delete</a>';
                        $btn .= ' <a href="javascript:void(0)" id="resetUserPasswordLink" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#resetUserPasswordModal" data-id="' . $row->id . '"><i class="fa fa-refresh"></i> Reset Passaword</a>';
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
                    'username' => 'required|string|max:50',
                    'email' => 'required|string|email|max:50|unique:users',
                    'password' => 'required|max:50|string',
                    'user_role' => 'required|numeric|exists:roles,id',
                    'user_site' => 'required|numeric|exists:sites,id',
                ]
            );
            try {
                User::create(
                    [
                        'name' => $request->username,
                        'email' => strtolower($request->email),
                        'password' => Hash::make($request->password),
                        'role_id' => $request->user_role,
                        'site_id' => $request->user_site,
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


    public function update(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $request->validate([
                    'id' => 'required|numeric|exists:users,id',
                    'username' => 'required|string|max:50',
                    'email' => 'required|string|email|max:50|unique:users,email,' . $request->id,
                    'role' => 'required|numeric|min:1|exists:roles,id',
                    'site' => 'required|numeric|min:1|exists:sites,id'
                ]
            );

            if (Auth::user()->id == $request->id) {

                try {
                    $res = User::where('id', $request->id)->update(
                        [
                            'name' => $request->username,
                            'email' => strtolower($request->email),
                            'role_id' => $request->role,
                            'site_id' => $request->site,
                            'created_by' => Auth::user()->id,
                        ]
                    );
                    Auth::guard('web')->logout();

                    $request->session()->invalidate();

                    $request->session()->regenerateToken();

                    return response()->json(
                        [
                            'redirection' => 'true'
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
                try {
                    $res = User::where('id', $request->id)->update(
                        [
                            'name' => strtolower($request->username),
                            'email' => strtolower($request->email),
                            'role_id' => $request->role,
                            'site_id' => $request->site,
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
            }
        } else {
            return redirect('logout');
        }

    }


    public function softDelete(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $request->validate([
                    'id' => 'required|numeric|exists:users,id',
                ]
            );

            if (Auth::user()->id == $request->id) {
                return response()->json(
                    [
                        'delete_self_error' => 'true'
                    ]
                );
            } else {
                try {
                    User::where('id', $request->id)->update(
                        [
                            'created_by' => Auth::user()->id,
                        ]
                    );
                    User::destroy($request->id);
                    return response()->json(
                        [
                            'status' => 'success'
                        ]
                    );

                } catch (\Exception $e) {
                    $errorCode = $e->getCode();

                    if ($errorCode === '23000') {
                        $errorMessage = "This user has a relationship with another table. You can't delete it.";
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
        } else {
            return redirect('logout');
        }

    }


    public function resetUserPassword(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $request->validate([
                    'id' => 'required|numeric|exists:users,id',
                    'password' => 'required|max:50|string',
                ]
            );
            if (Auth::user()->id == $request->id) {

                try {
                    $res = User::where('id', $request->id)->update(
                        [
                            'password' => Hash::make($request->password),
                            'created_by' => Auth::user()->id,
                        ]
                    );

                    Auth::guard('web')->logout();

                    $request->session()->invalidate();

                    $request->session()->regenerateToken();

                    return response()->json(
                        [
                            'redirection' => 'true'
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

                try {
                    $res = User::where('id', $request->id)->update(
                        [
                            'password' => Hash::make($request->password),
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

            }
        } else {
            return redirect('logout');
        }

    }

//    public function viewDeletedIndex()
//    {
//        if (Auth::user()->role_id == 1) {
//            return view('users.view_deleted_users');
//        } else {
//            return redirect('logout');
//        }
//    }

//    public function viewDeletedUsers(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//
//            if ($request->ajax()) {
//                $users = DB::table('users as t1')
//                    ->join('sites as t3', 't1.site_id', '=', 't3.id')
//                    ->join('roles as t4', 't1.role_id', '=', 't4.id')
//                    ->join('users as t2', 't2.id', '=', 't1.created_by')
//                    ->select('t1.name as name', 't1.id as id', 't1.email as email', 't1.created_at as created_at', 't1.updated_at as updated_at', 't1.role_id as role_id', 't1.site_id as site_id', 't3.site_name as site_name', 't4.role_name as role_name', 't2.name as creator', 't1.deleted_at as deleted_at')
//                    ->whereNotNull('t1.deleted_at');
//
//                $allData = DataTables::of($users)
//                    ->addColumn('action', function ($row) {
//                        $btn = ' <a href="javascript:void(0)" id="forceDeleteUserLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forceDeleteUserModal" data-id="' . $row->id . '" data-username="' . $row->name . '"><i class="fa fa-trash"></i> Delete Forever</a>';
//                        $btn .= ' <a href="javascript:void(0)" id="restoreDeltedUserLink" class="btn btn-outline-dark btn-sm" data-id="' . $row->id . '"><i class="fas fa-trash-restore"></i> Restore</a>';
//                        return $btn;
//                    })
//                    ->rawColumns(['action'])
//                    ->toJson();
//                return $allData;
//            }
//        } else {
//            return redirect('logout');
//        }
//
//    }

//    public function forceDelete(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//
//
//            $request->validate([
//                    'id' => 'required|numeric|exists:users,id',
//                ]
//            );
//
//            try {
//                $res = User::withTrashed()->where('id', $request->id)->forceDelete();
//                return response()->json(
//                    [
//                        'status' => 'success'
//                    ]
//                );
//            } catch (\Exception $e) {
//                return response()->json(
//                    [
//                        'error' => $e->getMessage(),
//                    ]
//                );
//
//            }
//        } else {
//            return redirect('logout');
//        }
//
//    }

//    public function restoreDeletedUsers(Request $request)
//    {
//        if (Auth::user()->role_id == 1) {
//
//            $request->validate([
//                    'id' => 'required|numeric|exists:users,id',
//                ]
//            );
//
//            try {
//
//                $res = User::onlyTrashed()->where('id', $request->id)->restore();
//                $res2 = User::where('id', $request->id)->update([
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
//                        'error' => $e->getMessage(),
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

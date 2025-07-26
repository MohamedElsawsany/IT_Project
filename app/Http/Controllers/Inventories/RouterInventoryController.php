<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\Router\StoreRouterRequest;
use App\Http\Requests\inventories\Router\SoftDeleteRouterRequest;
use App\Http\Requests\inventories\Router\UpdateRouterRequest;
use App\Models\Inventories\Brand;
use App\Models\Inventories\Flag;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\RouterInventory;
use App\Models\Places\SiteActivity;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RouterInventoryController extends Controller
{
    public function index()
    {
        $flags = Flag::select('id','flag_name')->get();
        $brands = Brand::select('id','brand_name')->get();

        if (Auth::user()->role_id == 1) {
            $locations = SiteActivity::join('sites as t2', 'sites_activities.site_id', '=', 't2.id')
                ->join('activities as t3', 'sites_activities.activity_id', '=', 't3.id')
                ->join('governorates as t4', 't2.governorate_id', '=', 't4.id')
                ->select('sites_activities.id', DB::raw('concat(t4.governorate_name," - ",t2.site_name," - ",t3.activity_name) as activity'))
                ->get();
        } else {
            $locations = SiteActivity::join('sites as t2', 'sites_activities.site_id', '=', 't2.id')
                ->join('activities as t3', 'sites_activities.activity_id', '=', 't3.id')
                ->join('governorates as t4', 't2.governorate_id', '=', 't4.id')
                ->select('sites_activities.id', DB::raw('concat(t4.governorate_name," - ",t2.site_name," - ",t3.activity_name) as activity'))
                ->where('t2.id','=',Auth::user()->site_id)
                ->get();
        }

        return view('inventories.routers_inventories.index', compact('locations', 'brands', 'flags'));
    }

    public function store(StoreRouterRequest $request)
    {
        try {
            RouterInventory::create([
                'serial_number' => $request->serial_number,
                'model_id' => $request->routerModel,
                'ports' => $request->routerPorts,
                'flag_id' => $request->routerFlag,
                'site_activity_id' => $request->routerLocation,
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

    public function getAllRouters(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $routers = DB::table('routers_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('flags as t9', 't1.flag_id', '=', 't9.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't9.flag_name as flag_name', 't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.ports as ports'
                )
                ->whereNull('t1.deleted_at');
        }else{
            $routers = DB::table('routers_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('flags as t9', 't1.flag_id', '=', 't9.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't9.flag_name as flag_name', 't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.ports as ports'
                )
                ->where('t6.id','=',Auth::user()->site_id)
                ->whereNull('t1.deleted_at');
        }


        if ($request->ajax()) {
            $allData = DataTables::of($routers)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="editRouterLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editRouterModal"
                    data-router_id="' . $row->id . '"
                    data-router_serial="' . $row->serial_number . '"
                    data-router_brand="' . $row->brand_id . '"
                    data-router_brand_name="' . $row->brand_name . '"
                    data-router_model="' . $row->model_id . '"
                    data-router_model_name="' . $row->model_name . '"
                    data-router_ports="' . $row->ports . '"
                    data-router_location="' . $row->location_id . '"
                    data-router_flag="' . $row->flag_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" id="deleteRouterLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteRouterModal" data-router_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $allData;
        }
    }


    public function update(UpdateRouterRequest $request)
    {
        try {
            RouterInventory::where('id', $request->upRouterId)->update(
                [
                    'serial_number' => $request->serial_number,
                    'model_id' => $request->upRouterModel,
                    'ports' => $request->upRouterPorts,
                    'flag_id' => $request->upRouterFlag,
                    'site_activity_id' => $request->upRouterLocation,
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

    public function softDelete(SoftDeleteRouterRequest $request)
    {

        try {
            RouterInventory::where('id', $request->id)->update(
                [
                    'created_by' => Auth::user()->id,
                ]
            );
            RouterInventory::destroy($request->id);
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

    public function storeModels(Request $request)
    {
        $request->validate([
                'model_name' => 'required|string|max:50|unique:inventory_models,model_name',
                'brand_id' => 'required|numeric|min:1|exists:brands,id',
            ]
        );

        try {
            InvnetoryModelsModel::create([
                'category_name' => 'router',
                'brand_id' => $request->brand_id,
                'model_name' => $request->model_name,
                'created_by' => Auth::user()->id
            ]);
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

    public function getModels(Request $request)
    {

        $request->validate([
            'brand_id' => 'required|numeric|min:1|exists:brands,id'
        ]);
        $models = InvnetoryModelsModel::select('id', 'model_name')->where([
            ['brand_id', '=', $request->brand_id],
            ['category_name', '=', 'router']
        ])->get();

        $data = '<option value="0" disabled selected>Select Model</option>';
        foreach ($models as $model) {
            $data .= '<option value="' . $model->id . '">' . $model->model_name . '</option>';
        }
        return $data;
    }
}

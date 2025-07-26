<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\Server\SoftDeleteServerRequest;
use App\Http\Requests\inventories\Server\StoreServerRequest;
use App\Http\Requests\inventories\Server\UpdateServerRequest;
use App\Models\Inventories\Brand;
use App\Models\Inventories\CPU;
use App\Models\Inventories\Flag;
use App\Models\Inventories\GPU;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\OS;
use App\Models\Inventories\ServerInventory;
use App\Models\Places\SiteActivity;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServerController extends Controller
{
    public function index()
    {

        $cpus = CPU::select('id','cpu_name')->get();
        $flags = Flag::select('id','flag_name')->get();
        $gpus = GPU::select('id','gpu_name')->get();
        $brands = Brand::select('id','brand_name')->get();
        $operating_systems = OS::select('id','os_name')->get();

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
                ->where('t2.id', '=', Auth::user()->site_id)
                ->get();
        }

        return view('inventories.servers_inventories.index', compact('locations', 'brands', 'cpus', 'gpus', 'flags', 'operating_systems'));
    }

    public function store(StoreServerRequest $request)
    {
        try {
            ServerInventory::create([
                'serial_number' => $request->serial_number,
                'model_id' => $request->serverModel,
                'cpu_id' => $request->serverCPU,
                'flag_id' => $request->serverFlag,
                'gpu1_id' => $request->serverGPU1,
                'gpu2_id' => $request->serverGPU2,
                'os_id' => $request->serverOS,
                'hdd_storage' => $request->serverHDDStorage,
                'ssd_storage' => $request->serverSSDStorage,
                'ram' => $request->serverRam,
                'site_activity_id' => $request->serverLocation,
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

    public function getAllServers(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $servers = DB::table('servers_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('cpu_tb as t4', 't1.cpu_id', '=', 't4.id')
                ->leftJoin('gpu_tb as t5', 't1.gpu1_id', '=', 't5.id')
                ->leftJoin('gpu_tb as t6', 't1.gpu2_id', '=', 't6.id')
                ->join('flags as t7', 't1.flag_id', '=', 't7.id')
                ->join('users as t8', 't1.created_by', '=', 't8.id')
                ->join('sites_activities as t9', 't1.site_activity_id', '=', 't9.id')
                ->join('sites as t10', 't9.site_id', '=', 't10.id')
                ->join('activities as t11', 't9.activity_id', '=', 't11.id')
                ->join('governorates as t12', 't10.governorate_id', '=', 't12.id')
                ->join('operating_systems as t13', 't1.os_id', '=', 't13.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                    't3.model_name as model_name', 't4.cpu_name as cpu_name', 't5.gpu_name as gpu1_name',
                    't6.gpu_name as gpu2_name', 't1.hdd_storage as hdd_storage', 't1.ssd_storage as ssd_storage',
                    't1.ram as ram', 't12.governorate_name as governorate_name', 't10.site_name as site_name', 't11.activity_name as activity_name',
                    't7.flag_name as flag_name', 't8.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.cpu_id as cpu_id', 't1.gpu1_id as gpu1_id', 't1.gpu2_id as gpu2_id',
                    't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.os_id as os_id', 't13.os_name as os_name'
                )
                ->whereNull('t1.deleted_at');
        } else {

            $servers = DB::table('servers_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('cpu_tb as t4', 't1.cpu_id', '=', 't4.id')
                ->leftJoin('gpu_tb as t5', 't1.gpu1_id', '=', 't5.id')
                ->leftJoin('gpu_tb as t6', 't1.gpu2_id', '=', 't6.id')
                ->join('flags as t7', 't1.flag_id', '=', 't7.id')
                ->join('users as t8', 't1.created_by', '=', 't8.id')
                ->join('sites_activities as t9', 't1.site_activity_id', '=', 't9.id')
                ->join('sites as t10', 't9.site_id', '=', 't10.id')
                ->join('activities as t11', 't9.activity_id', '=', 't11.id')
                ->join('governorates as t12', 't10.governorate_id', '=', 't12.id')
                ->join('operating_systems as t13', 't1.os_id', '=', 't13.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                    't3.model_name as model_name', 't4.cpu_name as cpu_name', 't5.gpu_name as gpu1_name',
                    't6.gpu_name as gpu2_name', 't1.hdd_storage as hdd_storage', 't1.ssd_storage as ssd_storage',
                    't1.ram as ram', 't12.governorate_name as governorate_name', 't10.site_name as site_name', 't11.activity_name as activity_name',
                    't7.flag_name as flag_name', 't8.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.cpu_id as cpu_id', 't1.gpu1_id as gpu1_id', 't1.gpu2_id as gpu2_id',
                    't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.os_id as os_id', 't13.os_name as os_name'
                )
                ->where('t10.id', '=', Auth::user()->site_id)
                ->whereNull('t1.deleted_at');

        }

        if ($request->ajax()) {
            $allData = DataTables::of($servers)
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" id="editServerLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editServerModal"
                    data-server_id="' . $row->id . '"
                    data-server_serial="' . $row->serial_number . '"
                    data-server_brand="' . $row->brand_id . '"
                    data-server_brand_name="' . $row->brand_name . '"
                    data-server_model="' . $row->model_id . '"
                    data-server_model_name="' . $row->model_name . '"
                    data-server_cpu="' . $row->cpu_id . '"
                    data-server_gpu1="' . $row->gpu1_id . '"
                    data-server_gpu2="' . $row->gpu2_id . '"
                    data-server_hdd="' . $row->hdd_storage . '"
                    data-server_ssd="' . $row->ssd_storage . '"
                    data-server_os="' . $row->os_id . '"
                    data-server_ram="' . $row->ram . '"
                    data-server_location="' . $row->location_id . '"
                    data-server_flag="' . $row->flag_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" id="deleteServerLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteServerModal" data-server_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->setRowData(['align' => 'center'])
                ->toJson();
            return $allData;
        }
    }


    public function update(UpdateServerRequest $request)
    {
        try {
            ServerInventory::where('id', $request->upServerId)->update(
                [
                    'serial_number' => $request->serial_number,
                    'model_id' => $request->upServerModel,
                    'cpu_id' => $request->upServerCPU,
                    'flag_id' => $request->upServerFlag,
                    'gpu1_id' => $request->upServerGPU1,
                    'gpu2_id' => $request->upServerGPU2,
                    'os_id' => $request->upServerOS,
                    'hdd_storage' => $request->upServerHDDStorage,
                    'ssd_storage' => $request->upServerSSDStorage,
                    'ram' => $request->upServerRam,
                    'site_activity_id' => $request->upServerLocation,
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

    public function softDelete(SoftDeleteServerRequest $request)
    {

        try {
            ServerInventory::where('id', $request->id)->update(
                [
                    'created_by' => Auth::user()->id,
                ]
            );
            ServerInventory::destroy($request->id);
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
                'category_name' => 'PC',
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
            ['category_name', '=', 'pc']
        ])->get();

        $data = '<option value="0" disabled selected>Select Model</option>';
        foreach ($models as $model) {
            $data .= '<option value="' . $model->id . '">' . $model->model_name . '</option>';
        }
        return $data;
    }
}

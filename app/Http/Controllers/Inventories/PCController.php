<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\PC\BackedPCToStockRequest;
use App\Http\Requests\inventories\PC\DeliveryPCToEmployeeRequest;
use App\Http\Requests\inventories\PC\SoftDeletePCRequest;
use App\Http\Requests\inventories\PC\StorePCRequest;
use App\Http\Requests\inventories\PC\UpdatePCRequest;
use App\Models\EmployeesData\Department;
use App\Models\EmployeesData\Employee;
use App\Models\Inventories\Brand;
use App\Models\Inventories\CPU;
use App\Models\Inventories\Flag;
use App\Models\Inventories\GPU;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\DeliveredPCInventory;
use App\Models\Inventories\OS;
use App\Models\Inventories\PCInventory;
use App\Models\Places\SiteActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PCController extends Controller
{
    public function index()
    {
        $cpus = CPU::select('id', 'cpu_name')->get();
        $flags = Flag::select('id', 'flag_name')->get();
        $gpus = GPU::select('id', 'gpu_name')->get();
        $brands = Brand::select('id', 'brand_name')->get();
        $operating_systems = OS::select('id', 'os_name')->get();
        $departments = Department::select('id', 'department_name')->get();
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
        return view('inventories.PCs_inventories.index', compact('locations', 'brands', 'cpus', 'gpus', 'flags', 'operating_systems', 'departments'));
    }

    public function store(StorePCRequest $request)
    {
        try {
            PCInventory::create([
                'serial_number' => $request->serial_number,
                'model_id' => $request->PC_model,
                'cpu_id' => $request->PC_CPU,
                'flag_id' => $request->PC_flag,
                'gpu1_id' => $request->PC_GPU1,
                'gpu2_id' => $request->PC_GPU2,
                'os_id' => $request->PC_OS,
                'hdd_storage' => $request->PC_HDD,
                'ssd_storage' => $request->PC_SSD,
                'ram' => $request->PC_ram,
                'site_activity_id' => $request->PC_location,
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

    public function getAllPCs(Request $request)
    {
        $PCs = DB::table('pc_inventory as t1')
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
                't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.os_id as os_id', 't13.os_name as os_name', 't1.employee_id as employee_id')
            ->whereNull('t1.deleted_at');

        if (Auth::user()->role_id != 1) {
            $PCs->where('t10.id', '=', Auth::user()->site_id);
        }

        if ($request->ajax()) {
            $allData = DataTables::of($PCs)
                ->addColumn('action', function ($row) {
                    if ($row->employee_id == NULL && $row->flag_id == 1) {
                        $btn = '<a href="javascript:void(0)" id="editPCLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editPCModal"
                    data-pc_id="' . $row->id . '"
                    data-pc_serial="' . $row->serial_number . '"
                    data-pc_brand="' . $row->brand_id . '"
                    data-pc_brand_name="' . $row->brand_name . '"
                    data-pc_model="' . $row->model_id . '"
                    data-pc_model_name="' . $row->model_name . '"
                    data-pc_cpu="' . $row->cpu_id . '"
                    data-pc_gpu1="' . $row->gpu1_id . '"
                    data-pc_gpu2="' . $row->gpu2_id . '"
                    data-pc_hdd="' . $row->hdd_storage . '"
                    data-pc_ssd="' . $row->ssd_storage . '"
                    data-pc_os="' . $row->os_id . '"
                    data-pc_ram="' . $row->ram . '"
                    data-pc_location="' . $row->location_id . '"
                    data-pc_flag="' . $row->flag_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deletePCLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deletePCModal" data-pc_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deliveryToEmployeeLink" class="btn btn-outline-primary btn-sm" data-toggle="modal"  data-target="#deliveryToEmployeeModal" data-pc_id="' . $row->id . '"><i class="fa fa-arrow-up"></i> Assign To</a>';
                    } elseif ($row->employee_id == NULL && $row->flag_id == 3) {
                        $btn = '<a href="javascript:void(0)" id="editPCLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editPCModal"
                    data-pc_id="' . $row->id . '"
                    data-pc_serial="' . $row->serial_number . '"
                    data-pc_brand="' . $row->brand_id . '"
                    data-pc_brand_name="' . $row->brand_name . '"
                    data-pc_model="' . $row->model_id . '"
                    data-pc_model_name="' . $row->model_name . '"
                    data-pc_cpu="' . $row->cpu_id . '"
                    data-pc_gpu1="' . $row->gpu1_id . '"
                    data-pc_gpu2="' . $row->gpu2_id . '"
                    data-pc_hdd="' . $row->hdd_storage . '"
                    data-pc_ssd="' . $row->ssd_storage . '"
                    data-pc_os="' . $row->os_id . '"
                    data-pc_ram="' . $row->ram . '"
                    data-pc_location="' . $row->location_id . '"
                    data-pc_flag="' . $row->flag_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deletePCLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deletePCModal" data-pc_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';
                    } else {
                        $btn = '<span class="mr-2 pt-1 pr-4 pb-2 pl-4 bg-warning text-white rounded-pill text-right">No Actions</span>';
                    }
                    return $btn;
                })
                ->setRowClass(function ($row) {
                    if ($row->flag_id == 2) {
                        return 'table-success';
                    } elseif ($row->flag_id == 3) {
                        return 'table-danger';
                    } else {
                        return 'table-primary';
                    }
                })
                ->rawColumns(['action'])
                ->toJson();

            return $allData;
        }
    }



    public function getAllDeliveredPCs(Request $request)
    {
            $PCs = DB::table('delivered_pc_inventory as t1')
                ->join('pc_inventory as t2', 't1.pc_id', '=', 't2.id')
                ->join('inventory_models as t3', 't2.model_id', '=', 't3.id')
                ->join('brands as t4', 't3.brand_id', '=', 't4.id')
                ->join('sites_activities as t5', 't2.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('employees as t9', 't1.employee_id', 't9.id')
                ->leftJoin('employees_departments as t15', 't9.department_id', 't15.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->leftJoin('users as t11', 't1.backed_by', '=', 't11.id')
                ->select('t1.id as id', 't2.serial_number as serial_number', 't4.brand_name as brand_name', 't3.model_name as model_name',
                    't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't9.emp_name as emp_name', 't15.department_name as department_name', 't11.name as backed_by', 't1.pc_id as pc_id')
                ->whereNull('t1.deleted_at');
            if (Auth::user()->role_id != 1) {
                $PCs->where('t6.id', '=', Auth::user()->site_id);
            }

        if ($request->ajax()) {
            $allData = DataTables::of($PCs)
                ->addColumn('action', function ($row) {
                    if ($row->updated_at == NULL) {
                        $btn = ' <a href="javascript:void(0)" id="returnPCToStock" class="btn btn-outline-primary btn-sm" data-delivered_id="' . $row->id . '" data-pc_id="' . $row->pc_id . '"><i class="fa fa-reply"></i> Return to stock</a>';
                    } else {
                        $btn = '<span class="mr-2 pt-1 pr-4 pb-2 pl-4 bg-success text-white rounded-pill text-right">Employee returned this PC</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $allData;
        }
    }


    public function update(UpdatePCRequest $request)
    {
        try {
            PCInventory::where('id', $request->up_id)->update(
                [
                    'serial_number' => $request->serial_number,
                    'model_id' => $request->pc_model,
                    'cpu_id' => $request->pc_cpu,
                    'flag_id' => $request->pc_flag,
                    'gpu1_id' => $request->pc_gpu1,
                    'gpu2_id' => $request->pc_gpu2,
                    'os_id' => $request->pc_os,
                    'hdd_storage' => $request->pc_hdd,
                    'ssd_storage' => $request->pc_ssd,
                    'ram' => $request->pc_ram,
                    'site_activity_id' => $request->pc_location,
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

    public function softDelete(SoftDeletePCRequest $request)
    {
        try {
            PCInventory::where('id', $request->id)->update(
                [
                    'created_by' => Auth::user()->id,
                ]
            );
            PCInventory::destroy($request->id);
            return response()->json(
                [
                    'status' => 'success'
                ]
            );
        } catch (\Exception $e) {

            $errorCode = $e->getCode();

            if ($errorCode === '23000') {
                $errorMessage = "This PC has a relationship with another table. You can't delete it.";
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


    public function storeModels(Request $request)
    {
        $request->validate([
                'model_name' => 'required|string|max:50|unique:inventory_models,model_name',
                'brand_id' => 'required|numeric|min:1|exists:brands,id',
            ]
        );

        try {
            InvnetoryModelsModel::create([
                'category_name' => 'pc',
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


    public function deliveryToEmployee(DeliveryPCToEmployeeRequest $request)
    {

        try {
            PCInventory::where('id', $request->PCDeliveryId)->update([
                'employee_id' => $request->employeeNumberDelivery,
                'flag_id' => 2,
                'created_by' => Auth::user()->id
            ]);

            DeliveredPCInventory::create([
                'pc_id' => $request->PCDeliveryId,
                'employee_id' => $request->employeeNumberDelivery,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now()
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

    public function printDelivered($PCDeliveryId, $employeeNumberDelivery)
    {

        $employee = DB::table('employees as t1')
            ->join('users as t2', 't1.created_by', '=', 't2.id')
            ->select('t1.id as id', 't1.emp_name as emp_name')
            ->whereNull('t1.deleted_at')
            ->where('t1.id', '=', $employeeNumberDelivery)->first();

        $PC = DB::table('pc_inventory as t1')
            ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
            ->join('brands as t2', 't3.brand_id', '=', 't2.id')
            ->join('cpu_tb as t4', 't1.cpu_id', '=', 't4.id')
            ->leftJoin('gpu_tb as t5', 't1.gpu1_id', '=', 't5.id')
            ->leftJoin('gpu_tb as t6', 't1.gpu2_id', '=', 't6.id')
            ->join('sites_activities as t9', 't1.site_activity_id', '=', 't9.id')
            ->join('sites as t10', 't9.site_id', '=', 't10.id')
            ->join('activities as t11', 't9.activity_id', '=', 't11.id')
            ->join('governorates as t12', 't10.governorate_id', '=', 't12.id')
            ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                't3.model_name as model_name', 't4.cpu_name as cpu_name', 't5.gpu_name as gpu1_name',
                't6.gpu_name as gpu2_name', 't1.hdd_storage as hdd_storage', 't1.ssd_storage as ssd_storage',
                't1.ram as ram', 't12.governorate_name as governorate_name', 't10.site_name as site_name'
            )
            ->whereNull('t1.deleted_at')
            ->where('t1.id', '=', $PCDeliveryId)
            ->first();

        $user = DB::table('users as t1')
            ->join('sites as t3', 't1.site_id', '=', 't3.id')
            ->join('roles as t4', 't1.role_id', '=', 't4.id')
            ->join('users as t2', 't2.id', '=', 't1.created_by')
            ->join('governorates as t5', 't3.governorate_id', '=', 't5.id')
            ->select('t1.name as name', 't1.updated_at as updated_at', 't3.site_name as site_name', 't5.governorate_name as governorate_name')
            ->whereNull('t1.deleted_at')
            ->where('t1.id', '=', Auth::user()->id)
            ->first();

        return view('inventories.PCs_inventories.PC_invoice_print', compact('employee', 'PC', 'user'));

    }


    public function deliveredPCsIndex()
    {
        return view('inventories.PCs_inventories.deliveredPCsIndex');
    }

    public function returnPCToStock(BackedPCToStockRequest $request)
    {

        try {

            PCInventory::where('id', $request->pcId)->update(
                [
                    'flag_id' => 1,
                    'employee_id' => NULL,
                ]
            );
            DeliveredPCInventory::where('id', $request->deliveredId)->update([
                'updated_at' => Carbon::now(),
                'backed_by' => Auth::user()->id,
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

}

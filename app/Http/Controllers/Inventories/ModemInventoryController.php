<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\Modem\BackedModemToStockRequest;
use App\Http\Requests\inventories\Modem\DeliveryModemToEmployeeRequest;
use App\Http\Requests\inventories\Modem\SoftDeleteModemRequest;
use App\Http\Requests\inventories\Modem\StoreModemRequest;
use App\Http\Requests\inventories\Modem\UpdateModemRequest;
use App\Models\EmployeesData\Department;
use App\Models\EmployeesData\Employee;
use App\Models\Inventories\Brand;
use App\Models\Inventories\DeliveredModemInventory;
use App\Models\Inventories\Flag;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\ModemInventory;
use App\Models\Inventories\ModemType;
use App\Models\Places\SiteActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModemInventoryController extends Controller
{
    public function index()
    {
        $modemsTypes = ModemType::select('id', 'type_name')->get();
        $flags = Flag::select('id', 'flag_name')->get();
        $brands = Brand::select('id', 'brand_name')->get();
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

        return view('inventories.modems_inventories.index', compact('locations', 'brands', 'flags', 'modemsTypes', 'departments'));
    }

    public function store(StoreModemRequest $request)
    {
        try {
            ModemInventory::create([
                'serial_number' => $request->serial_number,
                'model_id' => $request->modemModel,
                'type_id' => $request->modemType,
                'flag_id' => $request->modemFlag,
                'site_activity_id' => $request->modemLocation,
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

    public function getAllModems(Request $request)
    {

        if (Auth::user()->role_id == 1) {
            $modems = DB::table('modems_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('flags as t9', 't1.flag_id', '=', 't9.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->join('modems_types as t11', 't1.type_id', '=', 't11.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name', 't1.employee_id as employee_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't9.flag_name as flag_name', 't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.type_id as type_id', 't11.type_name as type_name'
                )
                ->whereNull('t1.deleted_at');
        } else {
            $modems = DB::table('modems_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('flags as t9', 't1.flag_id', '=', 't9.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->join('modems_types as t11', 't1.type_id', '=', 't11.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name', 't1.employee_id as employee_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't9.flag_name as flag_name', 't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.type_id as type_id', 't11.type_name as type_name'
                )
                ->where('t6.id', '=', Auth::user()->site_id)
                ->whereNull('t1.deleted_at');
        }

        if ($request->ajax()) {
            $allData = DataTables::of($modems)
                ->addColumn('action', function ($row) {
                    if ($row->employee_id == NULL && $row->flag_id == 1) {
                        $btn = '<a href="javascript:void(0)" id="editModemLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editModemModal"
                    data-modem_id="' . $row->id . '"
                    data-modem_serial="' . $row->serial_number . '"
                    data-modem_brand="' . $row->brand_id . '"
                    data-modem_brand_name="' . $row->brand_name . '"
                    data-modem_model="' . $row->model_id . '"
                    data-modem_model_name="' . $row->model_name . '"
                    data-modem_type="' . $row->type_id . '"
                    data-modem_location="' . $row->location_id . '"
                    data-modem_flag="' . $row->flag_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deleteModemLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteModemModal" data-modem_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deliveryToEmployeeLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#deliveryToEmployeeModal" data-modem_id="' . $row->id . '"><i class="fa fa-arrow-up"></i> Assign To</a>';
                    } else {
                        $btn = '<span class="mr-2 pt-1 pr-4 pb-2 pl-4 bg-warning text-white rounded-pill text-right">No Actions</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $allData;
        }
    }


    public function getAllDeliveredModems(Request $request)
    {

        if (Auth::user()->role_id == 1) {
            $modems = DB::table('delivered_modems_inventory as t1')
                ->join('modems_inventory as t16', 't1.modem_id', '=', 't16.id')
                ->join('inventory_models as t3', 't16.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('sites_activities as t5', 't16.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->join('modems_types as t11', 't16.type_id', '=', 't11.id')
                ->join('employees as t13', 't1.employee_id', '=', 't13.id')
                ->leftJoin('employees_departments as t18', 't13.department_id', 't18.id')
                ->leftJoin('users as t17', 't1.backed_by', '=', 't17.id')
                ->select('t1.id as id', 't16.serial_number as serial_number', 't2.brand_name as brand_name', 't1.modem_id as modem_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at', 't11.type_name as type_name', 't18.department_name as department_name', 't13.emp_name as emp_name', 't17.name as backed_by')
                ->whereNull('t1.deleted_at');
        } else {
            $modems = DB::table('delivered_modems_inventory as t1')
                ->join('modems_inventory as t16', 't1.modem_id', '=', 't16.id')
                ->join('inventory_models as t3', 't16.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('sites_activities as t5', 't16.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->join('modems_types as t11', 't16.type_id', '=', 't11.id')
                ->join('employees as t13', 't1.employee_id', '=', 't13.id')
                ->leftJoin('employees_departments as t18', 't13.department_id', 't18.id')
                ->leftJoin('users as t17', 't1.backed_by', '=', 't17.id')
                ->select('t1.id as id', 't16.serial_number as serial_number', 't2.brand_name as brand_name', 't1.modem_id as modem_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at', 't11.type_name as type_name', 't18.department_name as department_name', 't13.emp_name as emp_name', 't17.name as backed_by')
                ->where('t6.id', '=', Auth::user()->site_id)
                ->whereNull('t1.deleted_at');
        }

        if ($request->ajax()) {
            $allData = DataTables::of($modems)
                ->addColumn('action', function ($row) {
                    if ($row->updated_at == NULL) {
                        $btn = ' <a href="javascript:void(0)" id="returnModemToStock" class="btn btn-outline-primary btn-sm" data-delivered_id="' . $row->id . '" data-modem_id="' . $row->modem_id . '"><i class="fa fa-reply"></i> Return to stock</a>';
                    } else {
                        $btn = '<span class="mr-2 pt-1 pr-4 pb-2 pl-4 bg-success text-white rounded-pill text-right">Employee returned this Modem</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $allData;
        }
    }


    public function update(UpdateModemRequest $request)
    {
        try {

            ModemInventory::where('id', $request->upModemId)->update(
                [
                    'serial_number' => $request->serial_number,
                    'model_id' => $request->upModemModel,
                    'type_id' => $request->upModemType,
                    'flag_id' => $request->upModemFlag,
                    'site_activity_id' => $request->upModemLocation,
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

    public function softDelete(SoftDeleteModemRequest $request)
    {
        try {
            ModemInventory::where('id', $request->id)->update(
                [
                    'created_by' => Auth::user()->id,
                ]
            );
            ModemInventory::destroy($request->id);
            return response()->json(
                [
                    'status' => 'success'
                ]
            );
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            if ($errorCode === '23000') {
                $errorMessage = "This modem has a relationship with another table. You can't delete it.";
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
                'category_name' => 'modem',
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
            ['category_name', '=', 'modem']
        ])->get();

        $data = '<option value="0" disabled selected>Select Model</option>';
        foreach ($models as $model) {
            $data .= '<option value="' . $model->id . '">' . $model->model_name . '</option>';
        }
        return $data;
    }

    public function deliveryToEmployee(DeliveryModemToEmployeeRequest $request)
    {

        try {
            ModemInventory::where('id', $request->modemDeliveryId)->update([
                'employee_id' => $request->employeeNumberDelivery,
                'flag_id' => 2,
                'created_by' => Auth::user()->id
            ]);

            DeliveredModemInventory::create([
                'modem_id' => $request->modemDeliveryId,
                'employee_id' => $request->employeeNumberDelivery,
                'created_at' => Carbon::now(),
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

    public function printDelivered($modemDeliveryId, $employeeNumberDelivery)
    {
        $employee = DB::table('employees as t1')
            ->join('users as t2', 't1.created_by', '=', 't2.id')
            ->select('t1.id as id', 't1.emp_name as emp_name')
            ->whereNull('t1.deleted_at')
            ->where('t1.id', '=', $employeeNumberDelivery)->first();

        $modem = DB::table('modems_inventory as t1')
            ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
            ->join('brands as t2', 't3.brand_id', '=', 't2.id')
            ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
            ->join('sites as t6', 't5.site_id', '=', 't6.id')
            ->join('activities as t7', 't5.activity_id', '=', 't7.id')
            ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
            ->join('users as t10', 't1.created_by', '=', 't10.id')
            ->join('modems_types as t11', 't1.type_id', '=', 't11.id')
            ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                't3.model_name as model_name', 't10.name as creator', 't1.created_at as created_at', 't11.type_name as type_name')
            ->where('t1.id', '=', $modemDeliveryId)
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

        return view('inventories.modems_inventories.modem_invoice_print', compact('employee', 'modem', 'user'));
    }

    public function deliveredModemsIndex()
    {

        return view('inventories.modems_inventories.deliveredModemsIndex');

    }

    public function returnModemToStock(BackedModemToStockRequest $request)
    {

        try {

            ModemInventory::where('id', $request->modemId)->update(
                [
                    'flag_id' => 1,
                    'employee_id' => NULL,
                ]
            );
            DeliveredModemInventory::where('id', $request->deliveredId)->update([
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

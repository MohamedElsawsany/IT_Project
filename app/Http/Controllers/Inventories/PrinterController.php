<?php

namespace App\Http\Controllers\Inventories;

use App\Http\Controllers\Controller;
use App\Http\Requests\inventories\Printer\BackedPrinterToStockRequest;
use App\Http\Requests\inventories\Printer\DeliveryPrinterToEmployeeRequest;
use App\Http\Requests\inventories\Printer\SoftDeletePrinterRequest;
use App\Http\Requests\inventories\Printer\StorePrinterRequest;
use App\Http\Requests\inventories\Printer\UpdatePrinterRequest;
use App\Models\EmployeesData\Department;
use App\Models\EmployeesData\Employee;
use App\Models\Inventories\Brand;
use App\Models\Inventories\DeliveredPrinterInventory;
use App\Models\Inventories\Flag;
use App\Models\Inventories\InvnetoryModelsModel;
use App\Models\Inventories\PrinterCategory;
use App\Models\Inventories\PrinterInventory;
use App\Models\Places\SiteActivity;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Printer;

class PrinterController extends Controller
{
    public function index()
    {
        $printersCategories = PrinterCategory::select('id', 'category_name')->get();
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

        return view('inventories.printers_inventories.index', compact('locations', 'brands', 'flags', 'printersCategories', 'departments'));
    }

    public function store(StorePrinterRequest $request)
    {
        try {
            PrinterInventory::create([
                'serial_number' => $request->serial_number,
                'model_id' => $request->printerModel,
                'category_id' => $request->printerCategory,
                'flag_id' => $request->printerFlag,
                'site_activity_id' => $request->printerLocation,
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

    public function getAllPrinters(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            $printers = DB::table('printers_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('printers_category as t4', 't1.category_id', '=', 't4.id')
                ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('flags as t9', 't1.flag_id', '=', 't9.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name', 't1.employee_id as employee_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't9.flag_name as flag_name', 't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.category_id as category_id', 't4.category_name as category_name')
                ->whereNull('t1.deleted_at');
        } else {
            $printers = DB::table('printers_inventory as t1')
                ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
                ->join('brands as t2', 't3.brand_id', '=', 't2.id')
                ->join('printers_category as t4', 't1.category_id', '=', 't4.id')
                ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('flags as t9', 't1.flag_id', '=', 't9.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name', 't1.employee_id as employee_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't9.flag_name as flag_name', 't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at',
                    't3.brand_id as brand_id', 't1.model_id as model_id', 't1.site_activity_id as location_id', 't1.flag_id as flag_id', 't1.category_id as category_id', 't4.category_name as category_name')
                ->where('t6.id', '=', Auth::user()->site_id)
                ->whereNull('t1.deleted_at');
        }


        if ($request->ajax()) {
            $allData = DataTables::of($printers)
                ->addColumn('action', function ($row) {
                    if ($row->employee_id == NULL && $row->flag_id == 1) {
                        $btn = '<a href="javascript:void(0)" id="editPrinterLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editPrinterModal"
                    data-printer_id="' . $row->id . '"
                    data-printer_serial="' . $row->serial_number . '"
                    data-printer_category="' . $row->category_id . '"
                    data-printer_brand="' . $row->brand_id . '"
                    data-printer_brand_name="' . $row->brand_name . '"
                    data-printer_model="' . $row->model_id . '"
                    data-printer_model_name="' . $row->model_name . '"
                    data-printer_location="' . $row->location_id . '"
                    data-printer_flag="' . $row->flag_id . '"
                    ><i class="fa fa-edit"></i> Edit</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deletePrinterLink" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deletePrinterModal" data-printer_id="' . $row->id . '"><i class="fa fa-trash"></i> Delete</a>';
                        $btn .= ' <a href="javascript:void(0)" id="deliveryToEmployeeLink" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#deliveryToEmployeeModal" data-printer_id="' . $row->id . '"><i class="fa fa-arrow-up"></i> Assign To</a>';
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


    public function getAllDeliveredPrinters(Request $request)
    {
        if (Auth::user()->role_id == 1) {

            $printers = DB::table('delivered_printers_inventory as t1')
                ->join('printers_inventory as t2', 't1.printer_id', '=', 't2.id')
                ->join('inventory_models as t3', 't2.model_id', '=', 't3.id')
                ->join('brands as t12', 't3.brand_id', '=', 't12.id')
                ->join('printers_category as t4', 't2.category_id', '=', 't4.id')
                ->join('sites_activities as t5', 't2.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->join('employees as t11', 't1.employee_id', 't11.id')
                ->leftJoin('employees_departments as t15', 't11.department_id', 't15.id')
                ->leftJoin('users as t13', 't1.backed_by', 't13.id')
                ->select('t1.id as id', 't2.serial_number as serial_number', 't12.brand_name as brand_name', 't1.printer_id as printer_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at', 't4.category_name as category_name',
                    't11.emp_name as emp_name', 't15.department_name as department_name', 't1.employee_id as employee_id', 't13.name as backed_by'
                )
                ->whereNull('t1.deleted_at');

        } else {

            $printers = DB::table('delivered_printers_inventory as t1')
                ->join('printers_inventory as t2', 't1.printer_id', '=', 't2.id')
                ->join('inventory_models as t3', 't2.model_id', '=', 't3.id')
                ->join('brands as t12', 't3.brand_id', '=', 't12.id')
                ->join('printers_category as t4', 't2.category_id', '=', 't4.id')
                ->join('sites_activities as t5', 't2.site_activity_id', '=', 't5.id')
                ->join('sites as t6', 't5.site_id', '=', 't6.id')
                ->join('activities as t7', 't5.activity_id', '=', 't7.id')
                ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
                ->join('users as t10', 't1.created_by', '=', 't10.id')
                ->join('employees as t11', 't1.employee_id', 't11.id')
                ->leftJoin('employees_departments as t15', 't11.department_id', 't15.id')
                ->leftJoin('users as t13', 't1.backed_by', 't13.id')
                ->select('t1.id as id', 't2.serial_number as serial_number', 't12.brand_name as brand_name', 't1.printer_id as printer_id',
                    't3.model_name as model_name', 't8.governorate_name as governorate_name', 't6.site_name as site_name', 't7.activity_name as activity_name',
                    't10.name as creator', 't1.created_at as created_at', 't1.updated_at as updated_at', 't4.category_name as category_name',
                    't11.emp_name as emp_name', 't15.department_name as department_name', 't1.employee_id as employee_id', 't13.name as backed_by'
                )
                ->where('t6.id', '=', Auth::user()->site_id)
                ->whereNull('t1.deleted_at');

        }

        if ($request->ajax()) {
            $allData = DataTables::of($printers)
                ->addColumn('action', function ($row) {
                    if ($row->updated_at == NULL) {
                        $btn = ' <a href="javascript:void(0)" id="returnPrinterToStock" class="btn btn-outline-primary btn-sm" data-delivered_id="' . $row->id . '" data-printer_id="' . $row->printer_id . '"><i class="fa fa-reply"></i> Return to stock</a>';
                    } else {
                        $btn = '<span class="mr-2 pt-1 pr-4 pb-2 pl-4 bg-success text-white rounded-pill text-right">Employee returned this Printer</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
            return $allData;
        }
    }


    public function update(UpdatePrinterRequest $request)
    {
        try {
            PrinterInventory::where('id', $request->upPrinterId)->update(
                [
                    'serial_number' => $request->serial_number,
                    'category_id' => $request->upPrinterCategory,
                    'model_id' => $request->upPrinterModel,
                    'flag_id' => $request->upPrinterFlag,
                    'site_activity_id' => $request->upPrinterLocation,
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

    public function softDelete(SoftDeletePrinterRequest $request)
    {
        try {
            PrinterInventory::where('id', $request->id)->update(
                [
                    'created_by' => Auth::user()->id,
                ]
            );
            PrinterInventory::destroy($request->id);
            return response()->json(
                [
                    'status' => 'success'
                ]
            );
        } catch (\Exception $e) {
            $errorCode = $e->getCode();

            if ($errorCode === '23000') {
                $errorMessage = "This printer/scanner has a relationship with another table. You can't delete it.";
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
                'category_name' => 'printer',
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
            ['category_name', '=', 'printer']
        ])->get();

        $data = '<option value="0" disabled selected>Select Model</option>';
        foreach ($models as $model) {
            $data .= '<option value="' . $model->id . '">' . $model->model_name . '</option>';
        }
        return $data;
    }

    public function deliveryToEmployee(DeliveryPrinterToEmployeeRequest $request)
    {
        try {
            PrinterInventory::where('id', $request->printerDeliveryId)->update([
                'employee_id' => $request->employeeNumberDelivery,
                'flag_id' => 2,
                'created_by' => Auth::user()->id
            ]);

            DeliveredPrinterInventory::create([
                'printer_id' => $request->printerDeliveryId,
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

    public function printDelivered($printerDeliveryId, $employeeNumberDelivery)
    {
        $employee = DB::table('employees as t1')
            ->join('users as t2', 't1.created_by', '=', 't2.id')
            ->select('t1.id as id', 't1.emp_name as emp_name')
            ->whereNull('t1.deleted_at')
            ->where('t1.id', '=', $employeeNumberDelivery)->first();

        $printer = DB::table('printers_inventory as t1')
            ->join('inventory_models as t3', 't1.model_id', '=', 't3.id')
            ->join('brands as t2', 't3.brand_id', '=', 't2.id')
            ->join('printers_category as t4', 't1.category_id', '=', 't4.id')
            ->join('sites_activities as t5', 't1.site_activity_id', '=', 't5.id')
            ->join('sites as t6', 't5.site_id', '=', 't6.id')
            ->join('activities as t7', 't5.activity_id', '=', 't7.id')
            ->join('governorates as t8', 't6.governorate_id', '=', 't8.id')
            ->select('t1.id as id', 't1.serial_number as serial_number', 't2.brand_name as brand_name',
                't3.model_name as model_name', 't4.category_name as category_name'
            )
            ->whereNull('t1.deleted_at')
            ->where('t1.id', '=', $printerDeliveryId)
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


        return view('inventories.printers_inventories.printer_invoice_print', compact('employee', 'printer', 'user'));

    }

    public function deliveredPrintersIndex()
    {

        return view('inventories.printers_inventories.deliveredPrintersIndex');

    }

    public function returnPrinterToStock(BackedPrinterToStockRequest $request)
    {

        try {

            PrinterInventory::where('id', $request->printerId)->update(
                [
                    'flag_id' => 1,
                    'employee_id' => NULL,
                ]
            );
            DeliveredPrinterInventory::where('id', $request->deliveredId)->update([
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

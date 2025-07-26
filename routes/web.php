<?php

use App\Http\Controllers\EmployeesData\EmployeeController;
use App\Http\Controllers\EmployeesData\EmployeeDepartmentController;
use App\Http\Controllers\Inventories\BrandController;
use App\Http\Controllers\Inventories\MobileSimController;
use App\Http\Controllers\Inventories\CPUController;
use App\Http\Controllers\Inventories\GPUController;
use App\Http\Controllers\Inventories\InventoryController;
use App\Http\Controllers\Inventories\SwitchInventoryController;
use App\Http\Controllers\Inventories\AccessPointInventoryController;
use App\Http\Controllers\Inventories\ModemInventoryController;
use App\Http\Controllers\Inventories\BarcodeInventoryController;
use App\Http\Controllers\Inventories\RouterInventoryController;
use App\Http\Controllers\Inventories\LaptopController;
use App\Http\Controllers\Inventories\PrinterController;
use App\Http\Controllers\Inventories\ScreenController;
use App\Http\Controllers\Inventories\ServerController;
use App\Http\Controllers\Inventories\OSController;
use App\Http\Controllers\Inventories\PCController;
use App\Http\Controllers\Places\ActivityController;
use App\Http\Controllers\Places\SiteActivityController;
use App\Http\Controllers\Places\SiteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::controller(UserController::class)->prefix('users')->middleware(['auth'])->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::put('/update', 'update')->name('update');
        Route::post('/users', 'getAllUsers')->name('users');
        Route::delete('/delete', 'softDelete')->name('soft_delete');
//        Route::get('/view_deleted_index', 'viewDeletedIndex')->name('view.deleted.index');
//        Route::get('/view_deleted_users', 'viewDeletedUsers')->name('deleted.users');
//        Route::delete('/force_delete', 'forceDelete')->name('force.delete');
//        Route::post('/restore_users', 'restoreDeletedUsers')->name('restore');
        Route::put('/reset_pass', 'resetUserPassword')->name('reset_password');
});


Route::controller(SiteController::class)->prefix('sites')->middleware(['auth'])->name('sites.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/sites', 'getAllSites')->name('sites');
    Route::post('/store', 'store')->name('store');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::put('/update', 'update')->name('update');
//    Route::get('/view_deleted_index', 'viewDeletedIndex')->name('view.deleted.index');
//    Route::get('/view_deleted_sites', 'viewDeletedSites')->name('deleted.sites');
//    Route::delete('/force_delete', 'forceDelete')->name('force.delete');
//    Route::post('/restore_sites', 'restoreDeletedSites')->name('restore');
});


Route::controller(ActivityController::class)->prefix('activities')->middleware(['auth'])->name('activities.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/activities', 'getAllActivities')->name('activities');
    Route::post('/store', 'store')->name('store');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::put('/update', 'update')->name('update');
//    Route::get('/view_deleted_index', 'viewDeletedIndex')->name('view.deleted.index');
//    Route::get('/view_deleted_activities', 'viewDeletedActivites')->name('deleted.activities');
//    Route::delete('/force_delete', 'forceDelete')->name('force.delete');
//    Route::post('/restore_activities', 'restoreDeletedActivities')->name('restore');
});

Route::controller(SiteActivityController::class)->prefix('sites_activities')->middleware(['auth'])->name('sites_activities.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/sites_activities', 'getAllSitesActivities')->name('sites_activities');
    Route::post('/store', 'store')->name('store');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::put('/update', 'update')->name('update');
//    Route::get('/view_deleted_index', 'viewDeletedIndex')->name('view.deleted.index');
//    Route::get('/view_deleted_sites_activities', 'viewDeletedSitesActivites')->name('deleted.sites_activities');
//    Route::delete('/force_delete', 'forceDelete')->name('force.delete');
//    Route::post('/restore_sites_activities', 'restoreDeletedSiteActivities')->name('restore');
});


Route::controller(EmployeeController::class)->prefix('employees')->middleware(['auth'])->name('employees.')->group(function () {

    Route::get('/', 'index')->name('index');
    Route::get('/employees', 'getAllEmployees')->name('employees');
    Route::post('/store', 'store')->name('store');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::put('/update', 'update')->name('update');
//    Route::get('/view_deleted_index', 'viewDeletedIndex')->name('view.deleted.index');
//    Route::get('/view_deleted_employees', 'viewDeletedEmployees')->name('deleted.employees');
//    Route::delete('/force_delete', 'forceDelete')->name('force.delete');
//    Route::post('/restore_employees', 'restoreDeletedEmployees')->name('restore');
    Route::post('/edit_employee', 'viewToEditEmployees')->name('edit');
    Route::post('/get_all_employees_json', 'getAllEmployeesJson')->name('get_all_employees_json');
});

Route::controller(EmployeeDepartmentController::class)->prefix('employees_departments')->middleware(['auth'])->name('employees_departments.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/employees_departments', 'getAllEmployeesDepartments')->name('employees_departments');
    Route::post('/store', 'store')->name('store');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::put('/update', 'update')->name('update');
//    Route::get('/view_deleted_index', 'viewDeletedIndex')->name('view.deleted.index');
//    Route::get('/view_deleted_employees_departments', 'viewDeletedEmployeesDepartments')->name('deleted.employees_departments');
//    Route::delete('/force_delete', 'forceDelete')->name('force.delete');
//    Route::post('/restore_employees_departments', 'restoreDeletedEmployeesDepartments')->name('restore');

});

Route::controller(BrandController::class)->prefix('brands')->middleware(['auth'])->name('brands.')->group(function () {
    Route::get('/brands', 'getAllBrands')->name('brands');
    Route::post('/store', 'store')->name('store');
});


Route::controller(CPUController::class)->prefix('cpu')->middleware(['auth'])->name('cpu.')->group(function () {
    Route::get('/cpu', 'getAllCPU')->name('cpu');
    Route::post('/store', 'store')->name('store');
});

Route::controller(GPUController::class)->prefix('gpu')->middleware(['auth'])->name('gpu.')->group(function () {
    Route::get('/gpu', 'getAllGPU')->name('gpu');
    Route::post('/store', 'store')->name('store');
});

Route::controller(OSController::class)->prefix('operating_systems')->middleware(['auth'])->name('operating_systems.')->group(function () {
    Route::get('/operating_systems', 'getAllOperatingSystems')->name('operating_systems');
    Route::post('/store', 'store')->name('store');
});


Route::controller(PCController::class)->prefix('pcs')->middleware(['auth'])->name('pcs.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_pcs_index', 'deliveredPCsIndex')->name('delivered_pcs_index');
    Route::put('/back_to_stock', 'returnPCToStock')->name('back_to_stock');
    Route::post('/pcs', 'getAllPCs')->name('pcs');
    Route::post('/delivered_pc', 'getAllDeliveredPCs')->name('delivered_pc');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{PCDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(LaptopController::class)->prefix('laptops')->middleware(['auth'])->name('laptops.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_laptops_index', 'deliveredLaptopsIndex')->name('delivered_laptops_index');
    Route::put('/back_to_stock', 'returnLaptopToStock')->name('back_to_stock');
    Route::post('/laptops', 'getAllLaptops')->name('laptops');
    Route::post('/delivered_laptop', 'getAllDeliveredLaptops')->name('delivered_laptop');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{laptopDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(ServerController::class)->prefix('servers')->middleware(['auth'])->name('servers.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/servers', 'getAllServers')->name('servers');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
});


Route::controller(PrinterController::class)->prefix('printers')->middleware(['auth'])->name('printers.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_printers_index', 'deliveredPrintersIndex')->name('delivered_printers_index');
    Route::put('/back_to_stock', 'returnPrinterToStock')->name('back_to_stock');
    Route::post('/printers', 'getAllPrinters')->name('printers');
    Route::post('/delivered_printer', 'getAllDeliveredPrinters')->name('delivered_printer');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{printerDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(ScreenController::class)->prefix('screens')->middleware(['auth'])->name('screens.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_screens_index', 'deliveredScreensIndex')->name('delivered_screens_index');
    Route::put('/back_to_stock', 'returnScreenToStock')->name('back_to_stock');
    Route::post('/screens', 'getAllScreens')->name('screens');
    Route::post('/delivered_screen', 'getAllDeliveredScreens')->name('delivered_screen');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{screenDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(RouterInventoryController::class)->prefix('routers')->middleware(['auth'])->name('routers.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/routers', 'getAllRouters')->name('routers');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
});

Route::controller(SwitchInventoryController::class)->prefix('switches')->middleware(['auth'])->name('switches.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/switches', 'getAllSwitches')->name('switches');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
});

Route::controller(BarcodeInventoryController::class)->prefix('barcodes')->middleware(['auth'])->name('barcodes.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_barcodes_index', 'deliveredBarcodesIndex')->name('delivered_barcodes_index');
    Route::put('/back_to_stock', 'returnBarcodeToStock')->name('back_to_stock');
    Route::post('/barcodes', 'getAllBarcodes')->name('barcodes');
    Route::post('/delivered_Barcode', 'getAllDeliveredBarcodes')->name('delivered_Barcode');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{barcodeDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(ModemInventoryController::class)->prefix('modems')->middleware(['auth'])->name('modems.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_modems_index', 'deliveredModemsIndex')->name('delivered_modems_index');
    Route::put('/back_to_stock', 'returnModemToStock')->name('back_to_stock');
    Route::post('/modems', 'getAllModems')->name('modems');
    Route::post('/delivered_modems', 'getAllDeliveredModems')->name('delivered_modems');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{modemDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(AccessPointInventoryController::class)->prefix('access_points')->middleware(['auth'])->name('access_points.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/delivered_access_points_index', 'deliveredAccessPointsIndex')->name('delivered_access_points_index');
    Route::put('/back_to_stock', 'returnAccessPointToStock')->name('back_to_stock');
    Route::post('/access_points', 'getAllAccessPoints')->name('access_points');
    Route::post('/delivered_access_points', 'getAllDeliveredAccessPoints')->name('delivered_access_points');
    Route::post('/store', 'store')->name('store');
    Route::post('/store_and_print', 'storeAndPrint')->name('store_and_print');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
    Route::post('/get_models', 'getModels')->name('get_models');
    Route::post('/models_store', 'storeModels')->name('models_store');
    Route::put('/delivery_to_employee', 'deliveryToEmployee')->name('delivery_to_employee');
    Route::get('/print_delivered/{accessPointDeliveryId}/{employeeNumberDelivery}', 'printDelivered')->name('print_delivered');
});

Route::controller(MobileSimController::class)->prefix('mobiles')->middleware(['auth'])->name('mobiles.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/mobiles', 'getAllMobiles')->name('mobiles');
    Route::post('/store', 'store')->name('store');
    Route::put('/update', 'update')->name('update');
    Route::delete('/delete', 'softDelete')->name('soft_delete');
});



require __DIR__ . '/auth.php';

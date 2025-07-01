<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Vapp\Admin\OrderController as AdminOrderController;
// use App\Http\Controllers\Cms\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Vapp\Setting\EventController;
use App\Http\Controllers\Cms\Setting\ProductController;
use App\Http\Controllers\GeneralSettings\AttachmentController;
use App\Http\Controllers\GeneralSettings\CompanyAddressController;
use App\Http\Controllers\GeneralSettings\CompanyController;
use App\Http\Controllers\GeneralSettings\CurrencyController;
use App\Http\Controllers\Vapp\Setting\FunctionalAreaController;

use App\Http\Controllers\Mds\Admin\DashboardController;
use App\Http\Controllers\Vapp\Admin\UserController as AdminUserController;
use App\Http\Controllers\Cms\Agency\InventoryController;
use App\Http\Controllers\Cms\Agency\OrderController as AgencyOrderController;
use App\Http\Controllers\Cms\Caterer\OrderController as CatererOrderController;
use App\Http\Controllers\Cms\Contractor\OrderController;
use App\Http\Controllers\Cms\Setting\ContractorController;
use App\Http\Controllers\Cms\Setting\ServicePeriodController;
use App\Http\Controllers\Mds\Auth\AdminController as AuthAdminController;
use App\Http\Controllers\Mds\Customer\UserController as CustomerUserController;
use App\Http\Controllers\Cms\Operator\OperatorController;
use App\Http\Controllers\Cms\Setting\AppSettingController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Vapp\Setting\VehicleTypeController;
use App\Http\Controllers\Vapp\Setting\VenueController;
use App\Http\Controllers\UtilController;
use App\Http\Controllers\Vapp\Admin\BookingController;
use App\Http\Controllers\Vapp\Setting\MatchController;
use App\Http\Controllers\Vapp\Setting\ParkingCapacityController;
use App\Http\Controllers\Vapp\Setting\ParkingMasterController;
use App\Http\Controllers\Vapp\Setting\VappInventoryController;
use App\Http\Controllers\Vapp\Setting\VappPrintBatchConroller;
use App\Http\Controllers\Vapp\Setting\VappSizeController;
use App\Http\Controllers\Vapp\Setting\VappVariationController;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->is_admin) {
            return redirect()->route('vapp.admin');
        } elseif (auth()->user()->hasRole('Customer')) {
            Log::info('Redirecting to vapp.customer');
            return redirect()->route('cms.agency');
        }
    } else {
        return redirect()->route('login');
    }
})->name('home');


Route::group(['middleware' => 'prevent-back-history', 'XssSanitizer'], function () {

    // Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'role:SuperAdmin|SuperMDS|Customer', 'prevent-back-history', 'auth.session'])->group(function () {

    //     // Event Image
    //     Route::controller(EventImageController::class)->group(function () {
    //         Route::get('/mds/setting/event/file/{file}', 'getPrivateFile')->name('mds.setting.event.file');
    //     });
    // });


    // Booking MANAGEMENT ******************************************************************** Admin All Route
    // 'roles:admin',
    Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'firstlogin', 'role:SuperAdmin|SuperMDS',  'prevent-back-history', 'auth.session'])->group(function () {

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/cms/admin/dashboard', 'dashboard')->name('cms.admin.dashboard');
        });

        // Route::controller(OperatorController::class)->group(function () {
        //     Route::get('/mds/operator', 'index')->name('mds.operator');
        //     Route::get('/mds/operator/booking/rsp/status', 'index')->name('mds.operator.booking.rsp.status');
        // });

        Route::controller(BookingController::class)->group(function () {
            Route::get('/vapp/admin', 'index')->name('vapp.admin');
            Route::get('/vapp/admin/booking', 'index')->name('vapp.admin.booking');
            Route::get('/vapp/admin/booking/list', 'list')->name('vapp.admin.booking.list');
            Route::get('/vapp/admin/booking/create', 'create')->name('vapp.admin.booking.create');
            Route::delete('/vapp/admin/booking/delete/{id}', 'delete')->name('vapp.admin.booking.delete');
            Route::get('/vapp/admin/booking/request/{id}', 'showRequest')->name('vapp.admin.booking.request');
            Route::post('/vapp/admin/booking/request/save', 'saveRequest')->name('vapp.admin.booking.request.save');
            Route::get('vapp/admin/booking/edit/{id}', 'edit')->name('vapp.admin.booking.edit');
            Route::post('/vapp/admin/request/store', 'store')->name('vapp.admin.request.store');


            // for event switching
            Route::get('/vapp/admin/events/{id}/switch',  'switch')->name('vapp.admin.booking.switch');
            Route::get('/vapp/admin/dashboard', 'dashboard')->name('vapp.admin.dashboard');

            // used to get list dependencies
            Route::get('/vapp/admin/booking/get/match/{id}', 'getMatchesFromVappVenue')->name('vapp.admin.booking.get.match');
            // Route::get('/get-matches', 'getMatchesFromVappVenue')->name('vapp.admin.booking.get.matches');
            Route::get('/get-catergory', 'getVariationsFromParkingCode')->name('vapp.admin.booking.get.category');
            Route::get('/get-matches', 'getMatchesFromMatchCategory')->name('vapp.admin.booking.get.matches');
            Route::get('/get-venues', 'getVenuesFromMatch')->name('vapp.admin.booking.get.venues');
            Route::get('/get-variation', 'getVariation')->name('vapp.admin.booking.get.variation');
            Route::get('/get-parking-color', 'getParkingColor')->name('vapp.admin.parking.get.color');

            // update booking status
            Route::post('/vapp/admin/booking/status/update', 'updateStatus')->name('vapp.admin.booking.status.update');
            Route::get('/vapp/admin/booking/status/edit/{id}', 'editStatus')->name('vapp.admin.booking.status.edit');

            // Route::get('/cms/admin/', 'index')->name('cms.admin');
            // Route::get('/cms/admin/orders/', 'index')->name('cms.admin.orders');
            // Route::get('/cms/admin/orders/list/{id?}', 'list')->name('cms.admin.orders.list');
            // Route::get('/cms/admin/orders/lines/list/{id?}', 'lines')->name('cms.admin.orders.lines.list');
            // Route::post('/cms/orders/admin/store', 'store')->name('cms.orders.admin.store');
            // Route::post('/cms/orders/update', 'update')->name('cms.orders.update');
            // Route::get('/cms/admin/orders/mv/edit/{id}', 'get')->name('cms.admin.orders.mv.get');
            // Route::delete('/cms/admin/orders/delete/{id}', 'destroy')->name('cms.admin.orders.delete');
            // Route::get('/cms/admin/item/get/{id}', 'getItem')->name('cms.admin.item.get');
            // Route::get('/cms/admin/orders-order/{id}', 'viewPo')->name('cms.admin.orders.order');
            // Route::get('/cms/admin/orders/po/pdf/{id?}', 'ordersPDF')->name('cms.admin.orders.po.pdf');
            // Route::get('/cms/admin/orders/po/pdf/{id?}', 'orderPDF')->name('cms.admin.orders.po.pdf');
            // Route::get('/cms/admin/orders/po/pdf/download/{id?}', 'downloadordersPDF')->name('cms.admin.orders.po.pdf.download');

            // Route::get('/cms/admin/orders/{id}/switch',  'switch')->name('cms.admin.orders.switch');
            // Route::get('/cms/admin', 'index')->name('cms.admin');

            // Route::post('/cms/admin/orders/status/update', 'updateStatus')->name('cms.admin.orders.status.update');
            // Route::get('/cms/admin/orders/status/edit/{id}', 'editStatus')->name('cms.admin.orders.status.edit');

            // // Order Details
            // Route::get('/cms/admin/orders/{order}/modal', 'getLines')->name('cms.admin.orders.modal');

            // // Attachments
            // Route::get('/cms/admin/orders/attachments/{id}', 'getAttachmentView')->name('cms.admin.orders.attachments');
        });

                Route::controller(VappSizeController::class)->group(function () {
            // Vehicle Type
            Route::get('/vapp/setting/vapp_size', 'index')->name('vapp.setting.vapp_size');
            Route::get('/vapp/setting/vapp_size/list', 'list')->name('vapp.setting.vapp_size.list');
            Route::get('/vapp/setting/vapp_size/get/{id}', 'get')->name('vapp.setting.vapp_size.get');
            Route::post('vapp/setting/vapp_size/update', 'update')->name('vapp.setting.vapp_size.update');
            Route::delete('/vapp/setting/vapp_size/delete/{id}', 'delete')->name('vapp.setting.vapp_size.delete');
            Route::post('/vapp/setting/vapp_size/store', 'store')->name('vapp.setting.vapp_size.store');
        });

        Route::controller(VehicleTypeController::class)->group(function () {
            // Vehicle Type
            Route::get('/vapp/setting/vehicle_type', 'index')->name('vapp.setting.vehicle_type');
            Route::get('/vapp/setting/vehicle_type/list', 'list')->name('vapp.setting.vehicle_type.list');
            Route::get('/vapp/setting/vehicle_type/get/{id}', 'get')->name('vapp.setting.vehicle_type.get');
            Route::post('vapp/setting/vehicle_type/update', 'update')->name('vapp.setting.vehicle_type.update');
            Route::delete('/vapp/setting/vehicle_type/delete/{id}', 'delete')->name('vapp.setting.vehicle_type.delete');
            Route::post('/vapp/setting/vehicle_type/store', 'store')->name('vapp.setting.vehicle_type.store');
        });

        // Parking Master
        Route::controller(ParkingMasterController::class)->group(function () {
            Route::get('/vapp/setting/parking/master', 'index')->name('vapp.setting.parking.master');
            Route::get('/vapp/setting/parking/master/list', 'list')->name('vapp.setting.parking.master.list');
            Route::get('/vapp/setting/parking/master/get/{id}', 'get')->name('vapp.setting.parking.master.get');
            Route::post('vapp/setting/parking/master/update', 'update')->name('vapp.setting.parking.master.update');
            Route::delete('/vapp/setting/parking/master/delete/{id}', 'delete')->name('vapp.setting.parking.master.delete');
            Route::post('/vapp/setting/parking/master/store', 'store')->name('vapp.setting.parking.master.store');
            Route::get('/vapp/setting/parking/master/mv/get/{id}', 'getView')->name('vapp.setting.parking.master.get.mv');
        });

        // VAPP Variation
        Route::controller(VappVariationController::class)->group(function () {
            Route::get('/vapp/setting/parking/variation', 'index')->name('vapp.setting.parking.variation');
            Route::get('/vapp/setting/parking/variation/list', 'list')->name('vapp.setting.parking.variation.list');
            Route::get('/vapp/setting/parking/variation/get/{id}', 'get')->name('vapp.setting.parking.variation.get');
            Route::post('vapp/setting/parking/variation/update', 'update')->name('vapp.setting.parking.variation.update');
            Route::delete('/vapp/setting/parking/variation/delete/{id}', 'delete')->name('vapp.setting.parking.variation.delete');
            Route::post('/vapp/setting/parking/variation/store', 'store')->name('vapp.setting.parking.variation.store');
            // add inventroy to this variation
            Route::post('/vapp/setting/inventory/variation/store', 'inventory_store')->name('vapp.setting.inventory.variation.store');
            Route::get('/vapp/setting/inventory/variation/get/{id}', 'get_inventory_variation_info')->name('vapp.setting.inventory.variation.get');
            // end inventroy to this variation

            Route::get('/vapp/setting/parking/variation/mv/get/{id}', 'getView')->name('vapp.setting.parking.variation.get.mv');
            
            // functional areas and vapp sizes associated with parking code
            Route::get('/vapp/setting/parking/code/functional_areas/{id}', 'getAssicatedFunctionalAreas')->name('vapp.setting.parking.code.functional_areas');
            Route::get('vapp_get_parking_code_from_event/{id}', 'getParkingCodeFromEvent')->name('vapp.setting.parking.code.get_from_event');

        });

                // VAPP Print Batch
        Route::controller(VappPrintBatchConroller::class)->group(function () {
            Route::get('/vapp/setting/print/batch', 'index')->name('vapp.setting.print.batch');
            Route::get('/vapp/setting/print/batch/list', 'list')->name('vapp.setting.print.batch.list');
            Route::get('/vapp/setting/print/batch/get/{id}', 'get')->name('vapp.setting.print.batch.get');
            Route::post('vapp/setting/print/batch/update', 'update')->name('vapp.setting.print.batch.update');
            Route::delete('/vapp/setting/print/batch/delete/{id}', 'delete')->name('vapp.setting.print.batch.delete');
            Route::post('/vapp/setting/print/batch/store', 'store')->name('vapp.setting.print.batch.store');
            Route::get('/vapp/setting/print/batch/mv/get/{id}', 'getView')->name('vapp.setting.print.batch.get.mv');

            // functional areas associated with parking code
            Route::get('/vapp/setting/print/batch/vapp_sizes/{id}', 'getAssicatedVaapSizes')->name('vapp.setting.print.batch.vapp_sizes');

        });

        // Parking Capacity
        Route::controller(ParkingCapacityController::class)->group(function () {
            Route::get('/vapp/setting/parking', 'index')->name('vapp.setting.parking');
            Route::get('/vapp/setting/parking/list', 'list')->name('vapp.setting.parking.list');
            Route::get('/vapp/setting/parking/get/{id}', 'get')->name('vapp.setting.parking.get');
            Route::post('vapp/setting/parking/update', 'update')->name('vapp.setting.parking.update');
            Route::delete('/vapp/setting/parking/delete/{id}', 'delete')->name('vapp.setting.parking.delete');
            Route::post('/vapp/setting/parking/store', 'store')->name('vapp.setting.parking.store');
            Route::get('/vapp/setting/parking/mv/get/{id}', 'getParkingView')->name('vapp.setting.parking.get.mv');
        });

        // Matches
        Route::controller(MatchController::class)->group(function () {
            Route::get('/vapp/setting/match', 'index')->name('vapp.setting.match');
            Route::get('/vapp/setting/match/list', 'list')->name('vapp.setting.match.list');
            Route::get('/vapp/setting/match/get/{id}', 'get')->name('vapp.setting.match.get');
            Route::post('vapp/setting/match/update', 'update')->name('vapp.setting.match.update');
            Route::delete('/vapp/setting/match/delete/{id}', 'delete')->name('vapp.setting.match.delete');
            Route::post('/vapp/setting/match/store', 'store')->name('vapp.setting.match.store');
            Route::get('/vapp/setting/match/mv/get/{id}', 'getMatchView')->name('vapp.setting.match.get.mv');
        });

        // VAPP Inventory
        Route::controller(VappInventoryController::class)->group(function () {
            Route::get('/vapp/setting/inventory', 'index')->name('vapp.setting.inventory');
            Route::get('/vapp/setting/inventory/list', 'list')->name('vapp.setting.inventory.list');
            Route::get('/vapp/setting/inventory/get/{id}', 'get')->name('vapp.setting.inventory.get');
            Route::post('vapp/setting/inventory/update', 'update')->name('vapp.setting.inventory.update');
            Route::delete('/vapp/setting/inventory/delete/{id}', 'delete')->name('vapp.setting.inventory.delete');
            Route::post('/vapp/setting/inventory/store', 'store')->name('vapp.setting.inventory.store');
            Route::get('/vapp/setting/inventory/mv/get/{id}', 'getVappInventoryView')->name('vapp.setting.inventory.get.mv');
        });


        // Venue
        Route::controller(VenueController::class)->group(function () {
            Route::get('/vapp/setting/venue', 'index')->name('vapp.setting.venue');
            Route::get('/vapp/setting/venue/list', 'list')->name('vapp.setting.venue.list');
            Route::get('/vapp/setting/venue/get/{id}', 'get')->name('vapp.setting.venue.get');
            Route::post('vapp/setting/venue/update', 'update')->name('vapp.setting.venue.update');
            Route::delete('/vapp/setting/venue/delete/{id}', 'delete')->name('vapp.setting.venue.delete');
            Route::post('/vapp/setting/venue/store', 'store')->name('vapp.setting.venue.store');
        });

        // Functional Area
        Route::controller(FunctionalAreaController::class)->group(function () {
            Route::get('/vapp/setting/funcareas', 'index')->name('vapp.setting.funcareas');
            Route::get('/vapp/setting/funcareas/list', 'list')->name('vapp.setting.funcareas.list');
            Route::get('/vapp/setting/funcareas/get/{id}', 'get')->name('vapp.setting.funcareas.get');
            Route::post('vapp/setting/funcareas/update', 'update')->name('vapp.setting.funcareas.update');
            Route::delete('/vapp/setting/funcareas/delete/{id}', 'delete')->name('vapp.setting.funcareas.delete');
            Route::post('/vapp/setting/funcareas/store', 'store')->name('vapp.setting.funcareas.store');
        });

        //Event
        Route::controller(EventController::class)->group(function () {
            Route::get('/vapp/setting/event', 'index')->name('vapp.setting.event');
            Route::get('/vapp/setting/event/list', 'list')->name('vapp.setting.event.list');
            Route::get('/vapp/setting/event/get/{id}', 'get')->name('vapp.setting.event.get');
            Route::post('vapp/setting/event/update', 'update')->name('vapp.setting.event.update');
            Route::delete('/vapp/setting/event/delete/{id}', 'delete')->name('vapp.setting.event.delete');
            Route::post('/vapp/setting/event/store', 'store')->name('vapp.setting.event.store');
        });


        Route::controller(AdminUserController::class)->group(function () {
            Route::get('/vapp/admin/users/profile', 'profile')->name('vapp.admin.users.profile');
            Route::post('/vapp/admin/users/profile/update', 'update')->name('vapp.admin.users.profile.update');
            Route::post('/vapp/admin/users/profile/password/update', 'updatePassword')->name('vapp.admin.users.profile.password.update');
        });


        // General Settings MANAGEMENT ******************************************************************** Admin All Route
        // company Routes
        Route::controller(CompanyController::class)->group(function () {
            Route::get('/general/settings/company/', 'index')->name('general.settings.company');
            Route::post('/general/settings/update', 'update')->name('general.settings.update');
        });

        // Address Routes
        Route::controller(CompanyAddressController::class)->group(function () {
            Route::get('/general/settings/address/', 'index')->name('general.settings.address');
            Route::get('/general/settings/address/list/{id?}', 'list')->name('general.settings.address.list');
            Route::get('/general/settings/address/mv/edit/{id}', 'getAddressEditView')->name('general.settings.address.mv.edit');
            Route::post('/general/settings/address/update',  'update')->name('general.settings.address.update');
            Route::get('/general/settings/address/add', 'add')->name('general.settings.address.add');
            Route::post('/general/settings/address/store', 'store')->name('general.settings.address.store');
            Route::get('general/settings/address/delete/{id}', 'delete')->name('general.settings.address.delete');
        });

        // Currency Routes
        Route::controller(CurrencyController::class)->group(function () {
            Route::get('/general/settings/currency/', 'index')->name('general.settings.currency');
            Route::get('/general/settings/currency/list/{id?}', 'list')->name('general.settings.currency.list');
            Route::get('/general/settings/currency/get/{id}', 'get')->name('general.settings.currency.get');
            Route::post('/general/settings/currency/update',  'update')->name('general.settings.currency.update');
            Route::get('/general/settings/currency/add', 'add')->name('general.settings.currency.add');
            Route::post('/general/settings/currency/store', 'store')->name('general.settings.currency.store');
            Route::get('general/settings/currency/delete/{id}', 'delete')->name('general.settings.currency.delete');
        });
    });


});


// ****************** ADMIN *********************
Route::group(['middleware' => 'prevent-back-history'], function () {

    // Add User
    Route::get('/mds/auth/signup', [AuthAdminController::class, 'signUp'])->name('auth.signup');
    Route::post('/signup/store', [UserController::class, 'store'])->name('admin.signup.store');

    Route::middleware(['auth', 'prevent-back-history'])->group(function () {

        Route::get('auth/otp', [AuthAdminController::class, 'showOtp'])->name('otp.get');
        Route::post('verify-otp', [AuthAdminController::class, 'verifyOtpAndLogin'])->name('auth.otp.post');
        Route::get('auth/resend', [AuthAdminController::class, 'resendOTP'])->name('otp.resend.get');

        //used to show images in private folder
        Route::get('/doc/{file}', [UtilController::class, 'showImage'])->name('a');

        /*************************************** Play ground */
        // Route::get('/a/{GlobalAttachment}', [UtilController::class, 'serve'])->name('a');
        Route::get('/doc/{file}', [UtilController::class, 'showImage'])->name('a');
        Route::get('/a', function () {
            return response()->file(storage_path('app/private/users/502828276250308124600avatar-2.png'));
        })->name('b');
        /*************************************** End Play ground */

        // Route::get('/mds/admin/booking/pick', function () {
        //     return view('/mds/admin/booking/pick');
        // })->name('mds.admin.booking.pick')->middleware('role:SuperAdmin');
        // Route::post('/mds/admin/events/switch', [AdminBookingController::class, 'pickEvent'])->name('mds.admin.booking.event.switch')->middleware('role:SuperAdmin');

        // Route::get('/mds/customer/booking/pick', function () {
        //     return view('/mds/customer/booking/pick');
        // })->name('mds.customer.booking.pick')->middleware('role:Customer');
        // Route::post('/mds/customer/events/switch', [CustomerBookingController::class, 'pickEvent'])->name('mds.customer.booking.event.switch')->middleware('role:Customer');
        Route::get('/cms/agency/orders/pick', function () {
            return view('/cms/agency/orders/pick');
        })->name('cms.agency.orders.pick')->middleware('role:Agency');
        Route::post('/cms/agency/events/switch', [AgencyOrderController::class, 'pickEvent'])->name('cms.agency.orders.event.switch')->middleware('role:Agency');

        Route::get('/cms/caterer/orders/pick', function () {
            return view('/cms/caterer/orders/pick');
        })->name('cms.caterer.orders.pick')->middleware('role:Caterer');
        Route::post('/cms/caterer/events/switch', [CatererOrderController::class, 'pickEvent'])->name('cms.caterer.orders.event.switch')->middleware('role:Caterer');



        Route::get('/cms/contractor/orders/pick', function () {
            return view('/cms/contractor/orders/pick');
        })->name('cms.contractor.orders.pick')->middleware('role:Customer');
        Route::post('/cms/contractor/events/switch', [OrderController::class, 'pickEvent'])->name('cms.contractor.orders.event.switch')->middleware('role:Customer');

        Route::get('/mds/logout', [AuthAdminController::class, 'logout'])->name('mds.logout');

        // Route::get('/mds/admin/booking/confirmation', function () {
        //     return view('/mds/admin/booking/confirmation');
        // })->name('mds.admin.booking.confirmation');

        // Route::get('/mds/booking/pass/pdf/{id}', [BookingController::class, 'passPdf'])->name('mds.booking.pass.pdf');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        // Route::get('/mds/users/profile', [UserController::class, 'profile'])->name('mds.users.profile');


        // //Status
        // Route::get('/mds/setup/status/manage', [StatusController::class, 'index'])->name('mds.setup.status.manage');
        // Route::get('/mds/setup/status/list', [StatusController::class, 'list'])->name('mds.setup.status.list');
        // Route::get('/mds/setup/status/{id}/get', [StatusController::class, 'get'])->name('mds.setup.status.get');
        // Route::post('mds/setup/status/update', [StatusController::class, 'update'])->name('mds.setup.status.update');
        // Route::delete('/mds/setup/status/{id}/delete', [StatusController::class, 'delete'])->name('mds.setup.status.delete');
        // Route::post('/mds/setup/status/store', [StatusController::class, 'store'])->name('mds.setup.status.store');

        // // Charts
        // Route::get('/charts/piechart', [ChartsController::class, 'pieChart'])->name('charts.pie');
        // Route::get('/charts/piechart2', [ChartsController::class, 'pieChart'])->name('charts.pie2');
        // Route::get('/charts/charts', [ChartsController::class, 'eventDash'])->name('charts.dashboard');
    });

    require __DIR__ . '/auth.php';

    // file manager routes
    Route::middleware(['auth', 'otp', 'XssSanitizer', 'role:SuperAdmin|Procurement|Contractor|Customer|Agency', 'prevent-back-history', 'auth.session'])->group(function () {
        Route::controller(AttachmentController::class)->group(function () {
            Route::post('file/store', 'store')->name('file.store');
            Route::get('/global/files/list/{id?}', 'list')->name('global.files.list')->middleware('permission:employee.file.list');
            // Route::get('/global/files/list/{project?}', 'list')->name('global.files.list')->middleware('permission:employee.file.list');
            Route::get('/global/file/serve/{file}', 'serve')->name('global.file.serve');
            Route::delete('/global/files/delete/{id}', 'delete')->name('global.files.delete');
        });
    });

    // Admin Group Middleware
    // Route::middleware(['auth', 'role:admin', 'prevent-back-history'])->group(function () {
    // Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    // Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');
    // Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    // Route::post('/admin/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
    // });  // End groupd admin middleware

    // Route::middleware(['auth', 'role:agent'])->group(function () {
    //     Route::get('/agent/dashboard', [AgentController::class, 'agentDashboard'])->name('agent.dashboard');
    // });  // End groupd agent middleware

    Route::middleware(['prevent-back-history'])->group(function () {

        // Route::get('/tracki/auth/login', [AdminController::class, 'login'])->name('tracki.auth.login')->middleware('prevent-back-history');
        Route::get('/mds/auth/login', [AuthAdminController::class, 'login'])->name('mds.auth.login')->middleware('prevent-back-history');

        Route::get('/mds/auth/forgot', [AdminController::class, 'forgotPassword'])->name('mds.auth.forgot');
        Route::post('forget-password', [AdminController::class, 'submitForgetPasswordForm'])->name('forgot.password.post');
        // Route::get('mds/auth/reset/{token}', [AuthAdminController::class, 'showResetPasswordForm'])->name('mds.auth.reset');
        Route::get('mds/auth/first/reset/{token}', [AuthAdminController::class, 'showResetPasswordForm'])->name('mds.auth.first.reset');
        Route::post('reset-first-time-password', [AdminController::class, 'resetFirstPassword'])->name('reset.first.password.post');
        Route::post('reset-password', [AdminController::class, 'submitResetPasswordForm'])->name('reset.password.post');


        // Route::get('/send-mail/nb', [SendMailController::class, 'newBookingEmail']);
        Route::get('/send-mail', [SendMailController::class, 'index']);
        // Route::get('/send-mail2', [SendMailController::class, 'sendTaskAssignmentEmail']);
    });

    // HR Security Settings all routes
    Route::middleware(['auth', 'otp', 'XssSanitizer', 'role:SuperAdmin', 'prevent-back-history', 'auth.session'])->group(function () {

        Route::controller(RoleController::class)->group(function () {
            //Admin User
            Route::get('/sec/adminuser/list', 'listAdminUser')->name('sec.adminuser.list');
            Route::post('updateadminuser', 'updateAdminUser')->name('sec.adminuser.update');
            Route::post('createadminuser', 'createAdminUser')->name('sec.adminuser.create');
            Route::get('/sec/adminuser/{id}/edit', 'editAdminUser')->name('sec.adminuser.edit');
            Route::get('/sec/adminuser/{id}/delete', 'deleteAdminUser')->name('sec.adminuser.delete');
            Route::get('/sec/adminuser/add', 'addAdminUser')->name('sec.adminuser.add');
            Route::get('/sec/adminuser/add2', 'addAdminUser2')->name('sec.adminuser.add2');

            // Roles
            Route::get('/sec/roles/add', function () {
                return view('/sec/roles/add');
            })->name('sec.roles.add');
            Route::get('/sec/roles/roles/list', 'listRole')->name('sec.roles.list');
            Route::post('updaterole', 'updateRole')->name('sec.roles.update');
            Route::post('createrole', 'createRole')->name('sec.roles.create');
            Route::get('/sec/roles/{id}/edit', 'editRole')->name('sec.roles.edit');
            Route::get('/sec/roles/{id}/delete', 'deleteRole')->name('sec.roles.delete');

            // group
            Route::get('/sec/groups/add', function () {
                return view('/sec/groups/add');
            })->name('sec.groups.add');
            Route::get('/sec/groups/list', 'listGroup')->name('sec.groups.list');
            Route::post('updategroup', 'updateGroup')->name('sec.groups.update');
            Route::post('creategroup', 'createGroup')->name('sec.groups.create');
            Route::get('/sec/groups/{id}/edit', 'editGroup')->name('sec.groups.edit');
            Route::get('/sec/groups/{id}/delete', 'deleteGroup')->name('sec.groups.delete');

            // Permission
            Route::get('/sec/permissions/list', 'listPermission')->name('sec.perm.list');
            Route::post('updatepermission', 'updatePermission')->name('sec.perm.update');
            Route::post('createpermission', 'createPermission')->name('sec.perm.create');
            Route::get('/sec/perm/{id}/edit', 'editPermission')->name('sec.perm.edit');
            Route::get('/sec/perm/{id}/delete', 'deletePermission')->name('sec.perm.delete');
            Route::get('/sec/permissions/add', 'addPermission')->name('sec.perm.add');

            Route::get('/sec/perm/import', 'ImportPermission')->name('sec.perm.import');
            Route::post('importnow', 'ImportNowPermission')->name('sec.perm.import.now');


            // Roles in Permission
            Route::get('/sec/rolesetup/list', 'listRolePermission')->name('sec.rolesetup.list');
            Route::post('updaterolesetup', 'updateRolePermission')->name('sec.rolesetup.update');
            Route::post('createrolesetup', 'createRolePermission')->name('sec.rolesetup.create');
            Route::get('/sec/rolesetup/{id}/edit', 'editRolePermission')->name('sec.rolesetup.edit');
            Route::get('/sec/rolesetup/{id}/delete', 'deleteRolePermission')->name('sec.rolesetup.delete');
            Route::get('/sec/rolesetup/add', 'addRolePermission')->name('sec.rolesetup.add');
        });  //
    });  //
    // Route::get('/run-migration', function () {
    //     Artisan::call('optimize:clear');

    //     Artisan::call('migrate:refresh --seed');
    //     return "Migration executed successfully";
    // });


});

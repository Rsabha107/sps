<?php

use App\Http\Controllers\Sps\Admin\StorageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Setting\EventController;
use App\Http\Controllers\GeneralSettings\AttachmentController;
use App\Http\Controllers\GeneralSettings\CompanyController;
use App\Http\Controllers\Mds\Admin\DashboardController;
use App\Http\Controllers\Cms\Admin\UserController as AdminUserController;
use App\Http\Controllers\Cms\Agency\OrderController as AgencyOrderController;
use App\Http\Controllers\Cms\Contractor\OrderController;
use App\Http\Controllers\Mds\Auth\AdminController as AuthAdminController;
use App\Http\Controllers\Setting\AppSettingController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Setting\VenueController;
use App\Http\Controllers\Setting\LocationController;
use App\Http\Controllers\Setting\StorageTypeController;
use App\Http\Controllers\Sps\Customer\ProfileController;
use App\Http\Controllers\UtilController;
use Barryvdh\DomPDF\ServiceProvider;

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
            return redirect()->route('sps.admin');
        } elseif (auth()->user()->hasRole('Agency')) {
            Log::info('Redirecting to cms.agency');
            return redirect()->route('cms.agency');
        } else {
            return redirect()->route('cms.contractor');
        }
    } else {
        return redirect()->route('index');
    }
})->name('home');

Route::get('/index', [ProfileController::class, 'index'])->name('index');
Route::get('/spectator', [ProfileController::class, 'spectator'])->name('spectator')->middleware('signed');
Route::post('/visitors/store', [ProfileController::class, 'store'])->name('visitor.store');
Route::get('/sps/customer/confirmation/{token}', [ProfileController::class, 'confirmation'])->name('sps.customer.confirmation');

Route::group(['middleware' => 'prevent-back-history', 'XssSanitizer'], function () {



    // SPS MANAGEMENT ******************************************************************** Admin All Route
    // 'roles:admin',
    Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'firstlogin', 'role:SuperAdmin',  'prevent-back-history', 'auth.session'])->group(function () {

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/cms/admin/dashboard', 'dashboard')->name('cms.admin.dashboard');
        });

        Route::controller(StorageController::class)->group(function () {
            Route::get('/sps/admin', 'index')->name('sps.admin');
            Route::get('/sps/admin/list', 'list')->name('sps.admin.list');
            Route::get('/sps/admin/create', 'create')->name('sps.admin.create');
            Route::post('/sps/admin/visitor/store', 'store')->name('sps.admin.visitor.store');
            Route::post('/sps/admin/item/store', 'ItemStore')->name('sps.admin.item.store');
            Route::get('/sps/admin/item/mv/edit/{id}', 'getItemDescriptionView')->name('sps.admin.item.mv.edit');
            Route::get('/sps/admin/visitor/mv/get/{id}', 'getVisitorResultView')->name('sps.admin.visitor.mv.get');
            Route::get('/sps/admin/find', 'find')->name('sps.admin.find');
            Route::post('/sps/admin/find', 'get')->name('sps.admin.get');
            Route::delete('/sps/admin/visitor/delete/{id}', 'deleteVisitor')->name('sps.admin.visitor.delete');
            // update status routes
            Route::post('/sps/admin/item/status/update', 'updateStatus')->name('sps.admin.item.status.update');
            Route::get('/sps/admin/item/status/edit/{id}', 'editStatus')->name('sps.admin.item.status.edit');
            // update inline fields
            Route::post('/sps/admin/item/update-field/{id}',  'updateField')->name('sps.admin.item.update.field');

            Route::get('/sps/admin/orders/{id}/switch',  'switch')->name('sps.admin.orders.switch');
            Route::get('/sps/admin', 'index')->name('sps.admin');
        });

        // Venue
        Route::controller(VenueController::class)->group(function () {
            Route::get('/setting/venue', 'index')->name('setting.venue');
            Route::get('/setting/venue/list', 'list')->name('setting.venue.list');
            Route::get('/setting/venue/get/{id}', 'get')->name('setting.venue.get');
            Route::post('setting/venue/update', 'update')->name('setting.venue.update');
            Route::delete('/setting/venue/delete/{id}', 'delete')->name('setting.venue.delete');
            Route::post('/setting/venue/store', 'store')->name('setting.venue.store');
        });

        //Event
        Route::controller(EventController::class)->group(function () {
            Route::get('/setting/event', 'index')->name('setting.event');
            Route::get('/setting/event/list', 'list')->name('setting.event.list');
            Route::get('/setting/event/get/{id}', 'get')->name('setting.event.get');
            Route::post('setting/event/update', 'update')->name('setting.event.update');
            Route::delete('/setting/event/delete/{id}', 'delete')->name('setting.event.delete');
            Route::post('/setting/event/store', 'store')->name('setting.event.store');
            Route::get('/setting/event/mv/get/{id}', 'getEventView')->name('setting.event.get.mv');
            // Route::get('/cms/setting/event/file/{file}', 'getPrivateFile')->name('cms.setting.event.file');
        });

        // Location
        Route::controller(LocationController::class)->group(function () {
            Route::get('/setting/location', 'index')->name('setting.location');
            Route::get('/setting/location/list', 'list')->name('setting.location.list');
            Route::get('/setting/location/get/{id}', 'get')->name('setting.location.get');
            Route::post('setting/location/update', 'update')->name('setting.location.update');
            Route::delete('/setting/location/delete/{id}', 'delete')->name('setting.location.delete');
            Route::post('/setting/location/store', 'store')->name('setting.location.store');
        });

        // Storage Type
        Route::controller(StorageTypeController::class)->group(function () {
            Route::get('/setting/storage-type', 'index')->name('setting.storage.type');
            Route::get('/setting/storage-type/list', 'list')->name('setting.storage.type.list');
            Route::get('/setting/storage-type/get/{id}', 'get')->name('setting.storage.type.get');
            Route::post('setting/storage-type/update', 'update')->name('setting.storage.type.update');
            Route::delete('/setting/storage-type/delete/{id}', 'delete')->name('setting.storage.type.delete');
            Route::post('/setting/storage-type/store', 'store')->name('setting.storage.type.store');
        });

        //Application Setting
        Route::controller(AppSettingController::class)->group(function () {
            Route::get('/setting/application', 'index')->name('setting.application');
            Route::get('/setting/application/list', 'list')->name('setting.application.list');
            Route::get('/setting/application/get/{id}', 'get')->name('setting.application.get');
            Route::post('setting/application/update', 'update')->name('setting.application.update');
            Route::delete('/setting/application/delete/{id}', 'delete')->name('setting.application.delete');
            Route::post('/setting/application/store', 'store')->name('setting.application.store');
        });


        Route::controller(AdminUserController::class)->group(function () {
            Route::get('/cms/admin/users/profile', 'profile')->name('cms.admin.users.profile');
            Route::post('/mds/admin/users/profile/update', 'update')->name('mds.admin.users.profile.update');
            Route::post('/mds/admin/users/profile/password/update', 'updatePassword')->name('mds.admin.users.profile.password.update');
        });

        // General Settings MANAGEMENT ******************************************************************** Admin All Route
        // company Routes
        Route::controller(CompanyController::class)->group(function () {
            Route::get('/general/settings/company/', 'index')->name('general.settings.company');
            Route::post('/general/settings/update', 'update')->name('general.settings.update');
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

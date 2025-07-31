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
        return redirect()->route('login');
    }
})->name('home');

Route::get('/', [ProfileController::class, 'index'])->name('home');
Route::post('/visitors/store', [ProfileController::class, 'store'])->name('visitor.store');
Route::get('/sps/customer/confirmation/{profile}', [ProfileController::class, 'confirmation'])->name('sps.customer.confirmation');

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

        // Route::controller(OperatorController::class)->group(function () {
        //     Route::get('/mds/operator', 'index')->name('mds.operator');
        //     Route::get('/mds/operator/booking/rsp/status', 'index')->name('mds.operator.booking.rsp.status');
        // });

        // Route::controller(AdminOrderController::class)->group(function () {
        //     Route::get('/cms/admin/', 'index')->name('cms.admin');
        //     Route::get('/cms/admin/orders/', 'index')->name('cms.admin.orders');
        //     Route::get('/cms/admin/orders/list/{id?}', 'list')->name('cms.admin.orders.list');
        //     Route::get('/cms/admin/orders/lines/list/{id?}', 'lines')->name('cms.admin.orders.lines.list');
        //     Route::post('/cms/orders/admin/store', 'store')->name('cms.orders.admin.store');
        //     Route::post('/cms/orders/update', 'update')->name('cms.orders.update');
        //     Route::get('/cms/admin/orders/mv/edit/{id}', 'get')->name('cms.admin.orders.mv.get');
        //     Route::delete('/cms/admin/orders/delete/{id}', 'destroy')->name('cms.admin.orders.delete');
        //     Route::get('/cms/admin/item/get/{id}', 'getItem')->name('cms.admin.item.get');
        //     Route::get('/cms/admin/orders-order/{id}', 'viewPo')->name('cms.admin.orders.order');
        //     Route::get('/cms/admin/orders/po/pdf/{id?}', 'ordersPDF')->name('cms.admin.orders.po.pdf');
        //     Route::get('/cms/admin/orders/po/pdf/{id?}', 'orderPDF')->name('cms.admin.orders.po.pdf');
        //     Route::get('/cms/admin/orders/po/pdf/download/{id?}', 'downloadordersPDF')->name('cms.admin.orders.po.pdf.download');

        //     Route::get('/cms/admin/orders/{id}/switch',  'switch')->name('cms.admin.orders.switch');
        //     Route::get('/cms/admin', 'index')->name('cms.admin');

        //     Route::post('/cms/admin/orders/status/update', 'updateStatus')->name('cms.admin.orders.status.update');
        //     Route::get('/cms/admin/orders/status/edit/{id}', 'editStatus')->name('cms.admin.orders.status.edit');

        //     // Order Details
        //     Route::get('/cms/admin/orders/{order}/modal', 'getLines')->name('cms.admin.orders.modal');

        //     // Attachments
        //     Route::get('/cms/admin/orders/attachments/{id}', 'getAttachmentView')->name('cms.admin.orders.attachments');
        // });

        // // schedules
        // Route::controller(ProductController::class)->group(function () {
        //     Route::get('/cms/setting/product', 'index')->name('cms.setting.product');
        //     Route::get('/cms/setting/product/list', 'list')->name('cms.setting.product.list');
        //     Route::get('/cms/setting/product/get/{id}', 'get')->name('cms.setting.product.get');
        //     Route::post('cms/setting/product/update', 'update')->name('cms.setting.product.update');
        //     Route::delete('/cms/setting/product/delete/{id}', 'delete')->name('cms.setting.product.delete');
        //     Route::post('/cms/setting/product/store', 'store')->name('cms.setting.product.store');
        //     Route::get('/cms/setting/product/mv/get/{id}', 'getView')->name('cms.setting.product.get.mv');

        //     // import and export
        //     Route::get('/cms/setting/product/import', 'showImportForm')->name('cms.setting.product.import');
        //     Route::post('/cms/setting/product/import/store', 'import')->name('cms.setting.product.import.store');
        //     Route::get('/cms/setting/product/export', 'export')->name('cms.setting.product.export.store');
        // });

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

        //Service Period
        // Route::controller(ServicePeriodController::class)->group(function () {
        //     Route::get('/cms/setting/service/period', 'index')->name('cms.setting.service.period');
        //     Route::get('/cms/setting/service/period/list', 'list')->name('cms.setting.service.period.list');
        //     Route::get('/cms/setting/service/period/get/{id}', 'get')->name('cms.setting.service.period.get');
        //     Route::post('cms/setting/service/period/update', 'update')->name('cms.setting.service.period.update');
        //     Route::delete('/cms/setting/service/period/delete/{id}', 'delete')->name('cms.setting.service.period.delete');
        //     Route::post('/cms/setting/service/period/store', 'store')->name('cms.setting.service.period.store');
        //     Route::get('/cms/setting/service/period/mv/get/{id}', 'getEventView')->name('cms.setting.service.period.get.mv');
        //     // Route::get('/cms/setting/event/file/{file}', 'getPrivateFile')->name('cms.setting.event.file');
        //     Route::get('/cms/setting/service/period/{event}/venues', 'byEvent')->name('cms.setting.service.period.by.event');
        // });

        // //Contractor Setup
        // Route::controller(ContractorController::class)->group(function () {
        //     Route::get('/cms/setting/contractor', 'index')->name('cms.setting.contractor');
        //     Route::get('/cms/setting/contractor/list', 'list')->name('cms.setting.contractor.list');
        //     Route::get('/cms/setting/contractor/get/{id}', 'get')->name('cms.setting.contractor.get');
        //     Route::post('cms/setting/contractor/update', 'update')->name('cms.setting.contractor.update');
        //     Route::delete('/cms/setting/contractor/delete/{id}', 'delete')->name('cms.setting.contractor.delete');
        //     Route::post('/cms/setting/contractor/store', 'store')->name('cms.setting.contractor.store');
        //     Route::get('/cms/setting/contractor/mv/get/{id}', 'getView')->name('cms.setting.contractor.get.mv');
        //     // Route::get('/cms/setting/event/file/{file}', 'getPrivateFile')->name('cms.setting.event.file');
        //     // venues associated with events for picklist
        //     Route::get('/cms/setting/contractor/get/venues/{id}', 'getAssicatedVenues')->name('cms.setting.contractor.get.venues');
        // });

        //Application Setting
        Route::controller(AppSettingController::class)->group(function () {
            Route::get('/setting/application', 'index')->name('setting.application');
            Route::get('/setting/application/list', 'list')->name('setting.application.list');
            Route::get('/setting/application/get/{id}', 'get')->name('setting.application.get');
            Route::post('setting/application/update', 'update')->name('setting.application.update');
            Route::delete('/setting/application/delete/{id}', 'delete')->name('setting.application.delete');
            Route::post('/setting/application/store', 'store')->name('setting.application.store');
        });

        // //Booking Status
        // Route::controller(BookingStatusController::class)->group(function () {
        //     Route::get('/mds/setting/status/booking', 'index')->name('mds.setting.status.booking');
        //     Route::get('/mds/setting/status/booking/list', 'list')->name('mds.setting.status.booking.list');
        //     Route::get('/mds/setting/status/booking/get/{id}', 'get')->name('mds.setting.status.booking.get');
        //     Route::post('mds/setting/status/booking/update', 'update')->name('mds.setting.status.booking.update');
        //     Route::delete('/mds/setting/status/booking/delete/{id}', 'delete')->name('mds.setting.status.booking.delete');
        //     Route::post('/mds/setting/status/booking/store', 'store')->name('mds.setting.status.booking.store');
        // });

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

        // // Address Routes
        // Route::controller(CompanyAddressController::class)->group(function () {
        //     Route::get('/general/settings/address/', 'index')->name('general.settings.address');
        //     Route::get('/general/settings/address/list/{id?}', 'list')->name('general.settings.address.list');
        //     Route::get('/general/settings/address/mv/edit/{id}', 'getAddressEditView')->name('general.settings.address.mv.edit');
        //     Route::post('/general/settings/address/update',  'update')->name('general.settings.address.update');
        //     Route::get('/general/settings/address/add', 'add')->name('general.settings.address.add');
        //     Route::post('/general/settings/address/store', 'store')->name('general.settings.address.store');
        //     Route::get('general/settings/address/delete/{id}', 'delete')->name('general.settings.address.delete');
        // });

        // // Currency Routes
        // Route::controller(CurrencyController::class)->group(function () {
        //     Route::get('/general/settings/currency/', 'index')->name('general.settings.currency');
        //     Route::get('/general/settings/currency/list/{id?}', 'list')->name('general.settings.currency.list');
        //     Route::get('/general/settings/currency/get/{id}', 'get')->name('general.settings.currency.get');
        //     Route::post('/general/settings/currency/update',  'update')->name('general.settings.currency.update');
        //     Route::get('/general/settings/currency/add', 'add')->name('general.settings.currency.add');
        //     Route::post('/general/settings/currency/store', 'store')->name('general.settings.currency.store');
        //     Route::get('general/settings/currency/delete/{id}', 'delete')->name('general.settings.currency.delete');
        // });
    });

    // Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'firstlogin', 'role:Agency',  'prevent-back-history', 'auth.session'])->group(function () {

    //     Route::controller(DashboardController::class)->group(function () {
    //         Route::get('/cms/admin/dashboard', 'dashboard')->name('cms.admin.dashboard');
    //     });

    //     Route::controller(AgencyOrderController::class)->group(function () {
    //         Route::get('/cms/agency/', 'index')->name('cms.agency');
    //         Route::get('/cms/agency/orders/', 'index')->name('cms.agency.orders');
    //         Route::get('/cms/agency/orders/list/{id?}', 'list')->name('cms.agency.orders.list');
    //         Route::post('/cms/orders/agency/store', 'store')->name('cms.orders.agency.store');
    //         Route::post('/cms/orders/agency/update', 'update')->name('cms.orders.agency.update');
    //         Route::get('/cms/agency/orders/mv/edit/{id}', 'get')->name('cms.agency.orders.mv.get');
    //         Route::delete('/cms/agency/orders/delete/{id}', 'destroy')->name('cms.agency.orders.delete');
    //         Route::get('/cms/agency/item/get/{id}', 'getItem')->name('cms.agency.item.get');
    //         Route::get('/cms/agency/orders-order/{id}', 'viewPo')->name('cms.agency.orders.order');
    //         Route::get('/cms/agency/orders/po/pdf/{id?}', 'ordersPDF')->name('cms.agency.orders.po.pdf');
    //         Route::get('/cms/agency/orders/po/pdf/{id?}', 'orderPDF')->name('cms.agency.orders.po.pdf');
    //         Route::get('/cms/agency/orders/po/pdf/download/{id?}', 'downloadordersPDF')->name('cms.agency.orders.po.pdf.download');

    //         Route::get('/cms/agency/orders/{id}/switch',  'switch')->name('cms.agency.orders.switch');
    //         Route::get('/cms/agency', 'index')->name('cms.agency');

    //         Route::post('/cms/agency/orders/status/update', 'updateStatus')->name('cms.agency.orders.status.update');
    //         Route::get('/cms/agency/orders/status/edit/{id}', 'editStatus')->name('cms.agency.orders.status.edit');

    //         // Order Details
    //         Route::get('/cms/agency/orders/{order}/modal', 'getLines')->name('cms.agency.orders.modal');

    //         // Attachments
    //         Route::get('/cms/agency/orders/attachments/{id}', 'getAttachmentView')->name('cms.agency.orders.attachments');
    //     });
    // });

    // Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'firstlogin', 'role:Caterer',  'prevent-back-history', 'auth.session'])->group(function () {

    //     Route::controller(DashboardController::class)->group(function () {
    //         Route::get('/cms/admin/dashboard', 'dashboard')->name('cms.admin.dashboard');
    //     });

    //     Route::controller(CatererOrderController::class)->group(function () {
    //         Route::get('/cms/caterer/', 'index')->name('cms.caterer');
    //         Route::get('/cms/caterer/orders/', 'index')->name('cms.caterer.orders');
    //         Route::get('/cms/caterer/orders/list/{id?}', 'list')->name('cms.caterer.orders.list');
    //         Route::post('/cms/orders/caterer/store', 'store')->name('cms.orders.caterer.store');
    //         Route::post('/cms/orders/caterer/update', 'update')->name('cms.orders.caterer.update');
    //         Route::get('/cms/caterer/orders/mv/edit/{id}', 'get')->name('cms.caterer.orders.mv.get');
    //         Route::delete('/cms/caterer/orders/delete/{id}', 'destroy')->name('cms.caterer.orders.delete');
    //         Route::get('/cms/caterer/item/get/{id}', 'getItem')->name('cms.caterer.item.get');
    //         Route::get('/cms/caterer/orders-order/{id}', 'viewPo')->name('cms.caterer.orders.order');
    //         Route::get('/cms/caterer/orders/po/pdf/{id?}', 'ordersPDF')->name('cms.caterer.orders.po.pdf');
    //         Route::get('/cms/caterer/orders/po/pdf/{id?}', 'orderPDF')->name('cms.caterer.orders.po.pdf');
    //         Route::get('/cms/caterer/orders/po/pdf/download/{id?}', 'downloadordersPDF')->name('cms.caterer.orders.po.pdf.download');

    //         Route::get('/cms/caterer/orders/{id}/switch',  'switch')->name('cms.caterer.orders.switch');
    //         Route::get('/cms/caterer', 'index')->name('cms.caterer');

    //         Route::post('/cms/caterer/orders/status/update', 'updateStatus')->name('cms.caterer.orders.status.update');
    //         Route::get('/cms/caterer/orders/status/edit/{id}', 'editStatus')->name('cms.caterer.orders.status.edit');

    //         // Order Details
    //         Route::get('/cms/caterer/orders/{order}/modal', 'getLines')->name('cms.caterer.orders.modal');
    //     });
    // });


    // // Customer ******************************************************************** user All Route
    // Route::middleware(['auth', 'otp', 'mutli.event', 'XssSanitizer', 'role:Customer', 'prevent-back-history', 'auth.session'])->group(function () {

    //     // Customer Booking Routes
    //     // Route::controller(CustomerBookingController::class)->group(function () {

    //     Route::controller(OrderController::class)->group(function () {
    //         Route::get('/cms/contractor/', 'index')->name('cms.contractor');
    //         Route::get('/cms/contractor/orders/', 'index')->name('cms.contractor.orders');
    //         Route::get('/cms/contractor/orders/list/{id?}', 'list')->name('cms.contractor.orders.list');
    //         Route::get('/cms/contractor/orders/lines/list/{id?}', 'lines')->name('cms.contractor.orders.lines.list');
    //         Route::post('/cms/orders/contractor/store', 'store')->name('cms.orders.contractor.store');
    //         Route::post('/cms/orders/update', 'update')->name('cms.orders.update');
    //         Route::get('/cms/contractor/orders/mv/edit/{id}', 'get')->name('cms.contractor.orders.mv.get');
    //         Route::delete('/cms/contractor/orders/delete/{id}', 'destroy')->name('cms.contractor.orders.delete');
    //         Route::get('/cms/contractor/item/get/{id}', 'getItem')->name('cms.contractor.item.get');
    //         Route::get('/cms/contractor/orders-order/{id}', 'viewPo')->name('cms.contractor.orders.order');
    //         Route::get('/cms/contractor/orders/po/pdf/{id?}', 'orderPDF')->name('cms.contractor.orders.po.pdf');
    //         Route::get('/cms/contractor/orders/po/pdf/download/{id?}', 'downloadordersPDF')->name('cms.contractor.orders.po.pdf.download');

    //         Route::get('/download-qr-pdf/{id}', 'downloadQrPdf')->name('cms.contractor.orders.voucher.qr.pdf');
    //         Route::get('/cms/contractor/vouchers/vpdf/{id}', 'downloadQrPdf')->name('cms.contractor.orders.voucher.qr');

    //         Route::get('/cms/contractor', 'index')->name('cms.contractor');
    //         Route::get('/cms/contractor/events/{id}/switch',  'switch')->name('cms.contractor.orders.switch');

    //         // Order Details
    //         Route::get('/orders/{order}/modal', 'getLines')->name('orders.modal');

    //         // Attachments
    //         Route::get('/cms/contractor/orders/attachments/{id}', 'getAttachmentView')->name('cms.contractor.orders.attachments');
    //         // Route::get('/hr/admin/bank/mv/attachment/{id}', 'getAttachmentView')->name('hr.admin.bank.rv.attachment');

    //     });


    //     // Route::get('/cms/customer/events/{id}/switch',  'switch')->name('cms.customer.events.switch');

    //     // Route::get('/mds/customer/dashboard', 'dashboard')->name('mds.customer.dashboard');


    //     // //Booking note
    //     // Route::get('/mds/customer/booking/mv/notes/{id}', 'getNotesView')->name('mds.customer.booking.mv.notes');
    //     // Route::post('mds/customer/booking/note/store', 'noteStore')->name('mds.customer.booking.note.store');
    //     // Route::delete('mds/customer/booking/note/delete/{id}', 'deleteNote')->name('mds.customer.booking.note.delete');

    //     //Booking file upload
    //     // Route::post('mds/customer/booking/file/store', 'fileStore')->name('mds.customer.booking.file.store');
    //     // Route::delete('mds/customer/booking/file/{id}/delete', 'fileDelete')->name('mds.customer.booking.file.delete');
    //     // });


    //     Route::controller(CustomerUserController::class)->group(function () {
    //         Route::get('/mds/customer/users/profile', 'profile')->name('mds.customer.users.profile');
    //         Route::post('/mds/customer/users/profile/update', 'update')->name('mds.customer.users.profile.update');
    //         Route::post('/mds/customer/users/profile/password/update', 'updatePassword')->name('mds.customer.users.profile.password.update');
    //     });
    // });
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

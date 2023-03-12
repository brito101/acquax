<?php

use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ApartmentReportController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\Chat\MessageController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\DealershipReadingController;
use App\Http\Controllers\Admin\DealershipReadingGasController;
use App\Http\Controllers\Admin\Management\CondominiumReportsController;
use App\Http\Controllers\Admin\Management\MeterReadersController;
use App\Http\Controllers\Admin\MeterController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReadingController;
use App\Http\Controllers\Admin\ReadingScheduleController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\Settings\DealershipController;
use App\Http\Controllers\Admin\Settings\GenreController;
use App\Http\Controllers\Admin\Settings\TypeMetersController;
use App\Http\Controllers\Admin\SyndicController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Aplication\ApartmentController as AplicationApartmentController;
use App\Http\Controllers\Aplication\AppController;
use App\Http\Controllers\Aplication\MeterReadingController;
use App\Http\Controllers\Aplication\SupportController;
use App\Http\Controllers\Aplication\UserController as AplicationUserController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\PoliceController;
use App\Http\Controllers\Site\PostController as SitePostController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['log']], function () {
        Route::prefix('app')->name('app.')->group(function () {
            /** Dash */
            Route::get('/', [AppController::class, 'index'])->name('home');

            /** Notifications */
            Route::post('read-notification/{notification}', [AppController::class, 'notificationRead'])->name('notificationRead');

            /** Apartments Readings */
            Route::get('residences-readings', [AplicationApartmentController::class, 'index'])->name('residences.readings');
            Route::get('residences-readings/{reading}', [AplicationApartmentController::class, 'apartmentReading'])->name('residences.readings.apartment');
            Route::get('residences-readings-pdf/{reading}', [AplicationApartmentController::class, 'apartmentPrint'])->name('residences.readings.print');

            /** Ajax request */
            Route::get('residences-readings-ajax/{apartment}', [AplicationApartmentController::class, 'residencesReadingAjax'])->name('residences.readings.ajax');
            Route::get('complex-readings-ajax/{complex}', [AplicationApartmentController::class, 'complexReadingAjax'])->name('complex.readings.ajax');
            Route::get('complex-residences-readings-ajax/{complex}', [AplicationApartmentController::class, 'complexResidencesReadingAjax'])->name('complex.residences.readings.ajax');

            /** Complex Reading */
            Route::get('complex-readings/{reading}/', [AplicationApartmentController::class, 'complexReading'])->name('residences.readings.complex');
            Route::get('complex-readings-pdf/{reading}', [AplicationApartmentController::class, 'complexPrint'])->name('complex.readings.print');
            /** Ajax request */
            Route::get('complex-readings-report-ajax/{dealership_reading}', [AplicationApartmentController::class, 'readingsReportAjax'])->name('complex.readings.report.ajax');

            /** User Edit */
            Route::get('user', [AplicationUserController::class, 'edit'])->name('user.edit');
            Route::put('user', [AplicationUserController::class, 'update'])->name('user.update');

            /** Meter Readings */
            Route::get('meter-readings', [MeterReadingController::class, 'index'])->name('meter.readings.index');
            Route::get('meter-readings/{reading}', [MeterReadingController::class, 'show'])->name('meter.readings.show');
            /** Ajax request */
            Route::get('meters-readings-ajax', [MeterReadingController::class, 'metersReadingAjax'])->name('meters.readings.ajax');
            Route::get('meters-complex-readings-ajax', [MeterReadingController::class, 'metersComplexReadingAjax'])->name('meters.complex.readings.ajax');

            /** Support */
            Route::get('support', [SupportController::class, 'index'])->name('support.index');
            Route::post('support', [SupportController::class, 'sendMail'])->name('support.send.mail');
        });
    });

    Route::prefix('admin')->name('admin.')->group(function () {
        /** Chart home */
        Route::get('/chart', [AdminController::class, 'chart'])->name('home.chart');

        /** Chat */
        Route::get('chat/read', [MessageController::class, 'read']);
        Route::get('chat', [MessageController::class, 'index'])->name('chat.index');
        Route::post('chat', [MessageController::class, 'store'])->name('chat.store');

        Route::group(['middleware' => ['log']], function () {
            /** Home */
            Route::get('/', [AdminController::class, 'index'])->name('home');

            /** Users */
            Route::post('users-import-email', [UserController::class, 'fileImportEmail'])->name('users.importEmail');
            Route::post('/users/batchDelete', [UserController::class, 'batchDelete'])->name('users.batchDelete');
            Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::get('/users/destroy/{id}', [UserController::class, 'destroy']);
            Route::resource('users', UserController::class);

            /** Complex */
            Route::get('/complexes/photo', [ComplexController::class, 'photo']);
            Route::post('/complexes/photo', [ComplexController::class, 'photoImport'])->name('complexes.photo.import');
            Route::post('complex-import', [ComplexController::class, 'fileImport'])->name('complex.import');
            Route::match(['get', 'post'], 'complex-search', [ComplexController::class, 'search'])->name('complex.search');
            Route::post('/complex/batchDelete', [ComplexController::class, 'batchDelete'])->name('complexes.batchDelete');
            Route::get('/complexes/destroy/{id}', [ComplexController::class, 'destroy']);
            Route::resource('complexes', ComplexController::class);

            /** Blocks */
            Route::post('blocks-import', [BlockController::class, 'fileImport'])->name('blocks.import');
            Route::post('/blocks/batchDelete', [BlockController::class, 'batchDelete'])->name('blocks.batchDelete');
            Route::get('blocks/destroy/{id}', [BlockController::class, 'destroy']);
            Route::resource('blocks', BlockController::class);

            /** Apartments */
            Route::post('apartments-import', [ApartmentController::class, 'fileImport'])->name('apartments.import');
            Route::post('/apartments/batchDelete', [ApartmentController::class, 'batchDelete'])->name('apartments.batchDelete');
            Route::get('/apartments/destroy/{id}', [ApartmentController::class, 'destroy']);
            Route::resource('apartments', ApartmentController::class);

            /** Meters */
            Route::post('meters-import', [MeterController::class, 'fileImport'])->name('meters.import');
            Route::post('/meters/batchDelete', [MeterController::class, 'batchDelete'])->name('meters.batchDelete');
            Route::get('/meters/destroy/{id}', [MeterController::class, 'destroy']);
            Route::resource('meters', MeterController::class);

            /** Residents */
            Route::post('residents-import', [ResidentController::class, 'fileImport'])->name('residents.import');
            Route::post('/residents/batchDelete', [ResidentController::class, 'batchDelete'])->name('residents.batchDelete');
            Route::get('/residents/destroy/{id}', [ResidentController::class, 'destroy']);
            Route::resource('residents', ResidentController::class);

            /** Syndics */
            Route::post('/syndics/batchDelete', [SyndicController::class, 'batchDelete'])->name('syndics.batchDelete');
            Route::get('/syndics/destroy/{id}', [SyndicController::class, 'destroy']);
            Route::resource('syndics', SyndicController::class);

            /** Readings */
            Route::get('/readings/photo', [ReadingController::class, 'photo']);
            Route::post('/readings/photo', [ReadingController::class, 'photoImport'])->name('readings.photo.import');
            Route::post('readings-import', [ReadingController::class, 'fileImport'])->name('readings.import');
            Route::match(['get', 'post'], '/readings-search', [ReadingController::class, 'search'])->name('readings.search');
            Route::post('/readings/batchDelete', [ReadingController::class, 'batchDelete'])->name('readings.batchDelete');
            Route::get('/readings/destroy/{id}', [ReadingController::class, 'destroy']);
            Route::resource('readings', ReadingController::class);

            /** Apartments Reports */
            Route::post('reports-import', [ApartmentReportController::class, 'fileImport'])->name('reports.import');
            Route::post('/reports/batchDelete', [ApartmentReportController::class, 'batchDelete'])->name('reports.batchDelete');
            Route::get('/reports/destroy/{id}', [ApartmentReportController::class, 'destroy']);
            Route::resource('reports', ApartmentReportController::class);

            /** Dealerships Readings */
            Route::post('/dealerships-readings/batchDelete', [DealershipReadingController::class, 'batchDelete'])->name('dealerships-readings.batchDelete');
            Route::get('/dealerships-readings/destroy/{id}', [DealershipReadingController::class, 'destroy']);
            Route::resource('dealerships-readings', DealershipReadingController::class);

            /** Dealerships Readings Gas */
            Route::post('/dealerships-readings-gas/batchDelete', [DealershipReadingGasController::class, 'batchDelete'])->name('dealerships-readings-gas.batchDelete');
            Route::get('/dealerships-readings-gas/destroy/{id}', [DealershipReadingGasController::class, 'destroy']);
            Route::resource('dealerships-readings-gas', DealershipReadingGasController::class);

            /** Advertisements */
            Route::get('/advertisements/destroy/{id}', [AdvertisementController::class, 'destroy']);
            Route::resource('advertisements', AdvertisementController::class);

            /** Blog */
            Route::get('/posts/destroy/{id}', [PostController::class, 'destroy']);
            Route::resource('posts', PostController::class);

            /** Schedule */
            Route::get('schedule-day/{day?}', [ScheduleController::class, 'day']);
            Route::resource('schedule', ScheduleController::class);

            /** Reading Schedule */
            Route::get('/reading-schedule/executed/{id}', [ReadingScheduleController::class, 'executed']);
            Route::post('/reading-schedule/batchDelete', [ReadingScheduleController::class, 'batchDelete'])->name('reading-schedule.batchDelete');
            Route::get('/reading-schedule/destroy/{id}', [ReadingScheduleController::class, 'destroy']);
            Route::resource('reading-schedule', ReadingScheduleController::class);

            /** Management */
            Route::get('/management-reports-condominiums', [CondominiumReportsController::class, 'index'])->name('management-reports-condominiums');
            Route::get('/management-meter-readers', [MeterReadersController::class, 'index'])->name('management-meter-readers');

            /**
             * Configurations
             * */
            /** Dealerships */
            Route::get('/settings/dealerships/destroy/{id}', [DealershipController::class, 'destroy']);
            Route::resource('settings/dealerships', DealershipController::class);
            /** Type Meters */
            Route::get('/settings/type-meters/destroy/{id}', [TypeMetersController::class, 'destroy']);
            Route::resource('settings/type-meters', TypeMetersController::class);
            /** Genres */
            Route::get('/settings/genres/destroy/{id}', [GenreController::class, 'destroy']);
            Route::resource('settings/genres', GenreController::class);

            /**
             * ACL
             * */
            /** Permissions */
            Route::get('/permission/destroy/{id}', [PermissionController::class, 'destroy']);
            Route::resource('permission', PermissionController::class);
            /** Roles */
            Route::get('/role/destroy/{id}', [RoleController::class, 'destroy']);
            Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permissions');
            Route::put('role/{role}/permission/sync', [RoleController::class, 'permissionsSync'])->name('role.permissionsSync');
            Route::resource('role', RoleController::class);
        });
    });
});

/**
 * Site
 * */

Route::group(['middleware' => ['log']], function () {
    Route::name('site.')->group(function () {

        /** Home */
        Route::get('/', [HomeController::class, 'index'])->name('home');

        /** Services */
        /** Air Block */
        Route::get('/servicos/bloqueador-de-ar', [ServiceController::class, 'airBlock'])->name('service.airBlock');
        /** Anti Suction Device */
        Route::get('/servicos/dispositivo-anti-succao', [ServiceController::class, 'antiSuctionDevice'])->name('service.antiSuctionDevice');
        /** Water Individualization */
        Route::get('/servicos/individualizacao-de-agua', [ServiceController::class, 'waterIndividualization'])->name('service.waterIndividualization');
        /** Pump Maintenance */
        Route::get('/servicos/manutencao-de-bomba', [ServiceController::class, 'pumpMaintenance'])->name('service.pumpMaintenance');
        /** Hydrometer Measurement */
        Route::get('/servicos/medicao-de-hidrometro', [ServiceController::class, 'hydrometerMeasurement'])->name('service.hydrometerMeasurement');

        /** Blog */
        Route::get('/blog/{slug}', [SitePostController::class, 'post'])->name('post');
        Route::get('/blog', [SitePostController::class, 'index'])->name('posts');

        /** Contact */
        Route::get('/contato', [ContactController::class, 'index'])->name('contact');
        Route::post('/sendEmail', [ContactController::class, 'sendEmail'])->name('sendEmail');

        /** Police */
        Route::get('/politica-de-privacidade', [PoliceController::class, 'index'])->name('police');
    });

    Auth::routes([
        'register' => false,
    ]);

    Route::fallback(function () {
        return view('site.404');
    });
});

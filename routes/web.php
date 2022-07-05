<?php

use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\DealershipReadingController;
use App\Http\Controllers\Admin\MeterController;
use App\Http\Controllers\Admin\ReadingController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\Settings\DealershipController;
use App\Http\Controllers\Admin\Settings\GenreController;
use App\Http\Controllers\Admin\Settings\TypeMetersController;
use App\Http\Controllers\Admin\SyndicController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Aplication\ApartmentController as AplicationApartmentController;
use App\Http\Controllers\Aplication\AppController;
use App\Http\Controllers\Aplication\MeterReadingController;
use App\Http\Controllers\Aplication\SupportControler;
use App\Http\Controllers\Aplication\UserController as AplicationUserController;
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
    Route::get('app', [AppController::class, 'index'])->name('app.home');
    Route::prefix('app')->name('app.')->group(function () {

        /** Apartments Readings */
        Route::get('residences-readings', [AplicationApartmentController::class, 'index'])->name('residences.readings');
        Route::get('residences-readings/{reading}/apartment/{apartment}', [AplicationApartmentController::class, 'apartmentReading'])->name('residences.readings.apartment');
        Route::get('residences-readings-pdf/{reading}/apartment/{apartment}', [AplicationApartmentController::class, 'apartmentPrint'])->name('residences.readings.print');

        Route::get('residences-readings/{reading}/complex/{complex}', [AplicationApartmentController::class, 'complexReading'])->name('residences.readings.complex');
        Route::get('residences-readings-pdf/{reading}/complex/{complex}', [AplicationApartmentController::class, 'complexPrint'])->name('complex.readings.print');

        /** User Edit */
        Route::get('user', [AplicationUserController::class, 'edit'])->name('user.edit');
        Route::put('user', [AplicationUserController::class, 'update'])->name('user.update');

        /** Meter Readings */
        Route::get('meter-readings', [MeterReadingController::class, 'index'])->name('meter.readings.index');
        Route::get('meter-readings/{reading}', [MeterReadingController::class, 'show'])->name('meter.readings.show');

        /** Support */
        Route::get('support', [SupportControler::class, 'index'])->name('support.index');
        Route::post('support', [SupportControler::class, 'sendMail'])->name('support.send.mail');
    });

    Route::get('admin', [AdminController::class, 'index'])->name('admin.home');
    Route::prefix('admin')->name('admin.')->group(function () {
        /** Chart home */
        Route::get('/chart', [AdminController::class, 'chart'])->name('home.chart');

        /** Users */
        Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::get('/users/destroy/{id}', [UserController::class, 'destroy']);
        Route::resource('users', UserController::class);

        /** Complex */
        Route::get('/complexes/photo', [ComplexController::class, 'photo']);
        Route::post('/complexes/photo', [ComplexController::class, 'photoImport'])->name('complexes.photo.import');
        Route::post('complex-import', [ComplexController::class, 'fileImport'])->name('complex.import');
        Route::match(['get', 'post'], 'complex-search', [ComplexController::class, 'search'])->name('complex.search');
        Route::get('/complexes/destroy/{id}', [ComplexController::class, 'destroy']);
        Route::resource('complexes', ComplexController::class);

        /** Blocks */
        Route::post('blocks-import', [BlockController::class, 'fileImport'])->name('blocks.import');
        Route::get('blocks/destroy/{id}', [BlockController::class, 'destroy']);
        Route::resource('blocks', BlockController::class);

        /** Apartments */
        Route::post('apartments-import', [ApartmentController::class, 'fileImport'])->name('apartments.import');
        Route::get('/apartments/destroy/{id}', [ApartmentController::class, 'destroy']);
        Route::resource('apartments', ApartmentController::class);

        /** Meters */
        Route::post('meters-import', [MeterController::class, 'fileImport'])->name('meters.import');
        Route::get('/meters/destroy/{id}', [MeterController::class, 'destroy']);
        Route::resource('meters', MeterController::class);

        /** Residents */
        Route::post('residents-import', [ResidentController::class, 'fileImport'])->name('residents.import');
        Route::get('/residents/destroy/{id}', [ResidentController::class, 'destroy']);
        Route::resource('residents', ResidentController::class);

        /** Syndics */
        Route::get('/syndics/destroy/{id}', [SyndicController::class, 'destroy']);
        Route::resource('syndics', SyndicController::class);

        /** Readings */
        Route::get('/readings/photo', [ReadingController::class, 'photo']);
        Route::post('/readings/photo', [ReadingController::class, 'photoImport'])->name('readings.photo.import');
        Route::post('readings-import', [ReadingController::class, 'fileImport'])->name('readings.import');
        Route::match(['get', 'post'], '/readings-search', [ReadingController::class, 'search'])->name('readings.search');
        Route::get('/readings/destroy/{id}', [ReadingController::class, 'destroy']);
        Route::resource('readings', ReadingController::class);

        /** Dealerships Readings */
        Route::get('/dealerships-readings/destroy/{id}', [DealershipReadingController::class, 'destroy']);
        Route::resource('dealerships-readings', DealershipReadingController::class);

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

/** Web */
/** Home */
// Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('/', function () {
    return redirect('admin');
});

Auth::routes();

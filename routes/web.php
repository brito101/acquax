<?php

use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\ACL\PermissionController;
use App\Http\Controllers\Admin\ACL\RoleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\BlockController;
use App\Http\Controllers\Admin\ComplexController;
use App\Http\Controllers\Admin\MeterController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\Settings\GenreController;
use App\Http\Controllers\Admin\Settings\TypeMetersController;
use App\Http\Controllers\Admin\UserController;
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
    Route::get('admin', [AdminController::class, 'index'])->name('admin.home');
    Route::prefix('admin')->name('admin.')->group(function () {
        /** Chart home */
        Route::get('/chart', [AdminController::class, 'chart'])->name('home.chart');

        /** Users */
        Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::get('/users/destroy/{id}', [UserController::class, 'destroy']);
        Route::resource('users', UserController::class);

        /** Complex */
        Route::get('/complexes/destroy/{id}', [ComplexController::class, 'destroy']);
        Route::resource('complexes', ComplexController::class);

        /** Blocks */
        Route::get('blocks/destroy/{id}', [BlockController::class, 'destroy']);
        Route::resource('blocks', BlockController::class);

        /** Apartments */
        Route::get('/apartments/destroy/{id}', [ApartmentController::class, 'destroy']);
        Route::resource('apartments', ApartmentController::class);

        /** Meters */
        Route::get('/meters/destroy/{id}', [MeterController::class, 'destroy']);
        Route::resource('meters', MeterController::class);

        /** Residents */
        Route::get('/residents/destroy/{id}', [ResidentController::class, 'destroy']);
        Route::resource('residents', ResidentController::class);


        /**
         * Configurations
         * */
        /** Genres */
        Route::get('/settings/genres/destroy/{id}', [GenreController::class, 'destroy']);
        Route::resource('settings/genres', GenreController::class);
        /** Type Meters */
        Route::get('/settings/type-meters/destroy/{id}', [TypeMetersController::class, 'destroy']);
        Route::resource('settings/type-meters', TypeMetersController::class);

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
Route::get('/', [SiteController::class, 'index'])->name('home');

Auth::routes();

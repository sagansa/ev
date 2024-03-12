<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TypeVehicleController;
use App\Http\Controllers\MerkVehicleController;
use App\Http\Controllers\ChargerTypeController;
use App\Http\Controllers\FuelOilCostController;
use App\Http\Controllers\StateOfHealthController;
use App\Http\Controllers\SubMerkVehicleController;
use App\Http\Controllers\ChargerLocationController;
use App\Http\Controllers\ElectricCurrentController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::resource('sub-merk-vehicles', SubMerkVehicleController::class);
        Route::resource('providers', ProviderController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('charges', ChargeController::class);
        Route::resource('state-of-healths', StateOfHealthController::class);
        Route::resource('type-vehicles', TypeVehicleController::class);
        Route::resource('merk-vehicles', MerkVehicleController::class);
        Route::resource('charger-locations', ChargerLocationController::class);
        Route::resource('charger-types', ChargerTypeController::class);
        Route::resource('fuel-oil-costs', FuelOilCostController::class);
        Route::resource('chargers', ChargerController::class);
        Route::resource('electric-currents', ElectricCurrentController::class);
        Route::resource('cities', CityController::class);
        Route::resource('provinces', ProvinceController::class);
        Route::resource('trips', TripController::class);
    });

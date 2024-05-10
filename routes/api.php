<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChargeController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\ChargerController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\UserTripsController;
use App\Http\Controllers\Api\CityUsersController;
use App\Http\Controllers\Api\DetailTripController;
use App\Http\Controllers\Api\UserChargesController;
use App\Http\Controllers\Api\TypeVehicleController;
use App\Http\Controllers\Api\MerkVehicleController;
use App\Http\Controllers\Api\ChargerTypeController;
use App\Http\Controllers\Api\FuelOilCostController;
use App\Http\Controllers\Api\UserChargersController;
use App\Http\Controllers\Api\UserVehiclesController;
use App\Http\Controllers\Api\VehicleTripsController;
use App\Http\Controllers\Api\UserProvidersController;
use App\Http\Controllers\Api\StateOfHealthController;
use App\Http\Controllers\Api\ProvinceUsersController;
use App\Http\Controllers\Api\SubMerkVehicleController;
use App\Http\Controllers\Api\VehicleChargesController;
use App\Http\Controllers\Api\ChargerChargesController;
use App\Http\Controllers\Api\ProvinceCitiesController;
use App\Http\Controllers\Api\ChargerLocationController;
use App\Http\Controllers\Api\ElectricCurrentController;
use App\Http\Controllers\Api\TripDetailTripsController;
use App\Http\Controllers\Api\UserFuelOilCostsController;
use App\Http\Controllers\Api\UserStateOfHealthsController;
use App\Http\Controllers\Api\VehicleFuelOilCostsController;
use App\Http\Controllers\Api\TypeVehicleVehiclesController;
use App\Http\Controllers\Api\MerkVehicleVehiclesController;
use App\Http\Controllers\Api\ChargerTypeChargersController;
use App\Http\Controllers\Api\UserChargerLocationsController;
use App\Http\Controllers\Api\CityChargerLocationsController;
use App\Http\Controllers\Api\VehicleStateOfHealthsController;
use App\Http\Controllers\Api\SubMerkVehicleVehiclesController;
use App\Http\Controllers\Api\ChargerLocationChargesController;
use App\Http\Controllers\Api\TypeVehicleMerkVehiclesController;
use App\Http\Controllers\Api\ChargerLocationChargersController;
use App\Http\Controllers\Api\ElectricCurrentChargersController;
use App\Http\Controllers\Api\ProviderChargerLocationsController;
use App\Http\Controllers\Api\ProvinceChargerLocationsController;
use App\Http\Controllers\Api\TypeVehicleSubMerkVehiclesController;
use App\Http\Controllers\Api\MerkVehicleSubMerkVehiclesController;
use App\Http\Controllers\Api\ChargerLocationDetailTripsController;
use App\Http\Controllers\Api\ChargerTypeSubMerkVehiclesController;
use App\Http\Controllers\Api\SubMerkVehicleElectricCurrentsController;
use App\Http\Controllers\Api\ElectricCurrentSubMerkVehiclesController;
use App\Http\Controllers\Api\electric_current_sub_merk_vehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class);

        // User State Of Healths
        Route::get('/users/{user}/state-of-healths', [
            UserStateOfHealthsController::class,
            'index',
        ])->name('users.state-of-healths.index');
        Route::post('/users/{user}/state-of-healths', [
            UserStateOfHealthsController::class,
            'store',
        ])->name('users.state-of-healths.store');

        // User Fuel Oil Costs
        Route::get('/users/{user}/fuel-oil-costs', [
            UserFuelOilCostsController::class,
            'index',
        ])->name('users.fuel-oil-costs.index');
        Route::post('/users/{user}/fuel-oil-costs', [
            UserFuelOilCostsController::class,
            'store',
        ])->name('users.fuel-oil-costs.store');

        // User Chargers
        Route::get('/users/{user}/chargers', [
            UserChargersController::class,
            'index',
        ])->name('users.chargers.index');
        Route::post('/users/{user}/chargers', [
            UserChargersController::class,
            'store',
        ])->name('users.chargers.store');

        // User Charges
        Route::get('/users/{user}/charges', [
            UserChargesController::class,
            'index',
        ])->name('users.charges.index');
        Route::post('/users/{user}/charges', [
            UserChargesController::class,
            'store',
        ])->name('users.charges.store');

        // User Vehicles
        Route::get('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'index',
        ])->name('users.vehicles.index');
        Route::post('/users/{user}/vehicles', [
            UserVehiclesController::class,
            'store',
        ])->name('users.vehicles.store');

        // User Providers
        Route::get('/users/{user}/providers', [
            UserProvidersController::class,
            'index',
        ])->name('users.providers.index');
        Route::post('/users/{user}/providers', [
            UserProvidersController::class,
            'store',
        ])->name('users.providers.store');

        // User Trips
        Route::get('/users/{user}/trips', [
            UserTripsController::class,
            'index',
        ])->name('users.trips.index');
        Route::post('/users/{user}/trips', [
            UserTripsController::class,
            'store',
        ])->name('users.trips.store');

        // User Charger Locations
        Route::get('/users/{user}/charger-locations', [
            UserChargerLocationsController::class,
            'index',
        ])->name('users.charger-locations.index');
        Route::post('/users/{user}/charger-locations', [
            UserChargerLocationsController::class,
            'store',
        ])->name('users.charger-locations.store');

        Route::apiResource(
            'sub-merk-vehicles',
            SubMerkVehicleController::class
        );

        // SubMerkVehicle Vehicles
        Route::get('/sub-merk-vehicles/{subMerkVehicle}/vehicles', [
            SubMerkVehicleVehiclesController::class,
            'index',
        ])->name('sub-merk-vehicles.vehicles.index');
        Route::post('/sub-merk-vehicles/{subMerkVehicle}/vehicles', [
            SubMerkVehicleVehiclesController::class,
            'store',
        ])->name('sub-merk-vehicles.vehicles.store');

        // SubMerkVehicle Electric Currents
        Route::get('/sub-merk-vehicles/{subMerkVehicle}/electric-currents', [
            SubMerkVehicleElectricCurrentsController::class,
            'index',
        ])->name('sub-merk-vehicles.electric-currents.index');
        Route::post(
            '/sub-merk-vehicles/{subMerkVehicle}/electric-currents/{electricCurrent}',
            [SubMerkVehicleElectricCurrentsController::class, 'store']
        )->name('sub-merk-vehicles.electric-currents.store');
        Route::delete(
            '/sub-merk-vehicles/{subMerkVehicle}/electric-currents/{electricCurrent}',
            [SubMerkVehicleElectricCurrentsController::class, 'destroy']
        )->name('sub-merk-vehicles.electric-currents.destroy');

        Route::apiResource('providers', ProviderController::class);

        // Provider Charger Locations
        Route::get('/providers/{provider}/charger-locations', [
            ProviderChargerLocationsController::class,
            'index',
        ])->name('providers.charger-locations.index');
        Route::post('/providers/{provider}/charger-locations', [
            ProviderChargerLocationsController::class,
            'store',
        ])->name('providers.charger-locations.store');

        Route::apiResource('vehicles', VehicleController::class);

        // Vehicle Charges
        Route::get('/vehicles/{vehicle}/charges', [
            VehicleChargesController::class,
            'index',
        ])->name('vehicles.charges.index');
        Route::post('/vehicles/{vehicle}/charges', [
            VehicleChargesController::class,
            'store',
        ])->name('vehicles.charges.store');

        // Vehicle Fuel Oil Costs
        Route::get('/vehicles/{vehicle}/fuel-oil-costs', [
            VehicleFuelOilCostsController::class,
            'index',
        ])->name('vehicles.fuel-oil-costs.index');
        Route::post('/vehicles/{vehicle}/fuel-oil-costs', [
            VehicleFuelOilCostsController::class,
            'store',
        ])->name('vehicles.fuel-oil-costs.store');

        // Vehicle State Of Healths
        Route::get('/vehicles/{vehicle}/state-of-healths', [
            VehicleStateOfHealthsController::class,
            'index',
        ])->name('vehicles.state-of-healths.index');
        Route::post('/vehicles/{vehicle}/state-of-healths', [
            VehicleStateOfHealthsController::class,
            'store',
        ])->name('vehicles.state-of-healths.store');

        // Vehicle Trips
        Route::get('/vehicles/{vehicle}/trips', [
            VehicleTripsController::class,
            'index',
        ])->name('vehicles.trips.index');
        Route::post('/vehicles/{vehicle}/trips', [
            VehicleTripsController::class,
            'store',
        ])->name('vehicles.trips.store');

        Route::apiResource('charges', ChargeController::class);

        Route::apiResource('state-of-healths', StateOfHealthController::class);

        Route::apiResource('type-vehicles', TypeVehicleController::class);

        // TypeVehicle Sub Merk Vehicles
        Route::get('/type-vehicles/{typeVehicle}/sub-merk-vehicles', [
            TypeVehicleSubMerkVehiclesController::class,
            'index',
        ])->name('type-vehicles.sub-merk-vehicles.index');
        Route::post('/type-vehicles/{typeVehicle}/sub-merk-vehicles', [
            TypeVehicleSubMerkVehiclesController::class,
            'store',
        ])->name('type-vehicles.sub-merk-vehicles.store');

        // TypeVehicle Vehicles
        Route::get('/type-vehicles/{typeVehicle}/vehicles', [
            TypeVehicleVehiclesController::class,
            'index',
        ])->name('type-vehicles.vehicles.index');
        Route::post('/type-vehicles/{typeVehicle}/vehicles', [
            TypeVehicleVehiclesController::class,
            'store',
        ])->name('type-vehicles.vehicles.store');

        // TypeVehicle Merk Vehicles
        Route::get('/type-vehicles/{typeVehicle}/merk-vehicles', [
            TypeVehicleMerkVehiclesController::class,
            'index',
        ])->name('type-vehicles.merk-vehicles.index');
        Route::post('/type-vehicles/{typeVehicle}/merk-vehicles', [
            TypeVehicleMerkVehiclesController::class,
            'store',
        ])->name('type-vehicles.merk-vehicles.store');

        Route::apiResource('merk-vehicles', MerkVehicleController::class);

        // MerkVehicle Sub Merk Vehicles
        Route::get('/merk-vehicles/{merkVehicle}/sub-merk-vehicles', [
            MerkVehicleSubMerkVehiclesController::class,
            'index',
        ])->name('merk-vehicles.sub-merk-vehicles.index');
        Route::post('/merk-vehicles/{merkVehicle}/sub-merk-vehicles', [
            MerkVehicleSubMerkVehiclesController::class,
            'store',
        ])->name('merk-vehicles.sub-merk-vehicles.store');

        // MerkVehicle Vehicles
        Route::get('/merk-vehicles/{merkVehicle}/vehicles', [
            MerkVehicleVehiclesController::class,
            'index',
        ])->name('merk-vehicles.vehicles.index');
        Route::post('/merk-vehicles/{merkVehicle}/vehicles', [
            MerkVehicleVehiclesController::class,
            'store',
        ])->name('merk-vehicles.vehicles.store');

        Route::apiResource(
            'charger-locations',
            ChargerLocationController::class
        );

        // ChargerLocation Chargers
        Route::get('/charger-locations/{chargerLocation}/chargers', [
            ChargerLocationChargersController::class,
            'index',
        ])->name('charger-locations.chargers.index');
        Route::post('/charger-locations/{chargerLocation}/chargers', [
            ChargerLocationChargersController::class,
            'store',
        ])->name('charger-locations.chargers.store');

        // ChargerLocation Charges
        Route::get('/charger-locations/{chargerLocation}/charges', [
            ChargerLocationChargesController::class,
            'index',
        ])->name('charger-locations.charges.index');
        Route::post('/charger-locations/{chargerLocation}/charges', [
            ChargerLocationChargesController::class,
            'store',
        ])->name('charger-locations.charges.store');

        // ChargerLocation Detail Trips
        Route::get('/charger-locations/{chargerLocation}/detail-trips', [
            ChargerLocationDetailTripsController::class,
            'index',
        ])->name('charger-locations.detail-trips.index');
        Route::post('/charger-locations/{chargerLocation}/detail-trips', [
            ChargerLocationDetailTripsController::class,
            'store',
        ])->name('charger-locations.detail-trips.store');

        Route::apiResource('charger-types', ChargerTypeController::class);

        // ChargerType Chargers
        Route::get('/charger-types/{chargerType}/chargers', [
            ChargerTypeChargersController::class,
            'index',
        ])->name('charger-types.chargers.index');
        Route::post('/charger-types/{chargerType}/chargers', [
            ChargerTypeChargersController::class,
            'store',
        ])->name('charger-types.chargers.store');

        // ChargerType Sub Merk Vehicles
        Route::get('/charger-types/{chargerType}/sub-merk-vehicles', [
            ChargerTypeSubMerkVehiclesController::class,
            'index',
        ])->name('charger-types.sub-merk-vehicles.index');
        Route::post('/charger-types/{chargerType}/sub-merk-vehicles', [
            ChargerTypeSubMerkVehiclesController::class,
            'store',
        ])->name('charger-types.sub-merk-vehicles.store');

        Route::apiResource('fuel-oil-costs', FuelOilCostController::class);

        Route::apiResource('chargers', ChargerController::class);

        // Charger Charges
        Route::get('/chargers/{charger}/charges', [
            ChargerChargesController::class,
            'index',
        ])->name('chargers.charges.index');
        Route::post('/chargers/{charger}/charges', [
            ChargerChargesController::class,
            'store',
        ])->name('chargers.charges.store');

        Route::apiResource(
            'electric-currents',
            ElectricCurrentController::class
        );

        // ElectricCurrent Chargers
        Route::get('/electric-currents/{electricCurrent}/chargers', [
            ElectricCurrentChargersController::class,
            'index',
        ])->name('electric-currents.chargers.index');
        Route::post('/electric-currents/{electricCurrent}/chargers', [
            ElectricCurrentChargersController::class,
            'store',
        ])->name('electric-currents.chargers.store');

        // ElectricCurrent Sub Merk Vehicles
        Route::get('/electric-currents/{electricCurrent}/sub-merk-vehicles', [
            ElectricCurrentSubMerkVehiclesController::class,
            'index',
        ])->name('electric-currents.sub-merk-vehicles.index');
        Route::post(
            '/electric-currents/{electricCurrent}/sub-merk-vehicles/{subMerkVehicle}',
            [ElectricCurrentSubMerkVehiclesController::class, 'store']
        )->name('electric-currents.sub-merk-vehicles.store');
        Route::delete(
            '/electric-currents/{electricCurrent}/sub-merk-vehicles/{subMerkVehicle}',
            [ElectricCurrentSubMerkVehiclesController::class, 'destroy']
        )->name('electric-currents.sub-merk-vehicles.destroy');

        Route::apiResource('cities', CityController::class);

        // City Charger Locations
        Route::get('/cities/{city}/charger-locations', [
            CityChargerLocationsController::class,
            'index',
        ])->name('cities.charger-locations.index');
        Route::post('/cities/{city}/charger-locations', [
            CityChargerLocationsController::class,
            'store',
        ])->name('cities.charger-locations.store');

        // City Users
        Route::get('/cities/{city}/users', [
            CityUsersController::class,
            'index',
        ])->name('cities.users.index');
        Route::post('/cities/{city}/users', [
            CityUsersController::class,
            'store',
        ])->name('cities.users.store');

        Route::apiResource('provinces', ProvinceController::class);

        // Province Cities
        Route::get('/provinces/{province}/cities', [
            ProvinceCitiesController::class,
            'index',
        ])->name('provinces.cities.index');
        Route::post('/provinces/{province}/cities', [
            ProvinceCitiesController::class,
            'store',
        ])->name('provinces.cities.store');

        // Province Charger Locations
        Route::get('/provinces/{province}/charger-locations', [
            ProvinceChargerLocationsController::class,
            'index',
        ])->name('provinces.charger-locations.index');
        Route::post('/provinces/{province}/charger-locations', [
            ProvinceChargerLocationsController::class,
            'store',
        ])->name('provinces.charger-locations.store');

        // Province Users
        Route::get('/provinces/{province}/users', [
            ProvinceUsersController::class,
            'index',
        ])->name('provinces.users.index');
        Route::post('/provinces/{province}/users', [
            ProvinceUsersController::class,
            'store',
        ])->name('provinces.users.store');

        Route::apiResource('trips', TripController::class);

        // Trip Detail Trips
        Route::get('/trips/{trip}/detail-trips', [
            TripDetailTripsController::class,
            'index',
        ])->name('trips.detail-trips.index');
        Route::post('/trips/{trip}/detail-trips', [
            TripDetailTripsController::class,
            'store',
        ])->name('trips.detail-trips.store');
    });

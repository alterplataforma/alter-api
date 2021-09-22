<?php

use App\Http\Controllers\Admin\AlterConfigurationController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComidaController;
use App\Http\Controllers\User\AddressController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\NequiAccountController;
use App\Http\Controllers\User\UserCashController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\UtilController;
use Illuminate\Support\Facades\Route;

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


//**********USUARIOS****
Route::post('register',            [UserController::class, 'register']);
Route::post('login',               [UserController::class, 'login']);
Route::get('users',                [UserController::class, 'users']);
Route::post('password/email',      [ForgotPasswordController::class, 'forgot']);
Route::get('user/recomended/{id}', [UserController::class, 'getRecommended'])->where('id','[0-9]+');

Route::post('google',              [UtilController::class, 'google']);


Route::group(['middleware' => 'jwt'], function () {

    //GRUPO DE ENDPOINT DE RECURSOS
    Route::apiResources([//apiResources no toma los método create y edit
        //DIRECCIÓN FAVORITA
        'address'        => AddressController::class,
        //CRUD TIPOS DE SERVICIOS
        'typeService'    => TypeServiceController::class,
        //CRUD DE VEHÍCULOS
        'vehicle'        => VehicleController::class,
        // CUENTA NEQUI
        'nequi'          => NequiAccountController::class,
    ]);
    Route::post('nequi/validate',               [NequiAccountController::class, 'send_invitation_to_account']);

    Route::prefix('user')->group(function () {
        Route::get('me',                        [UserController::class, 'me']);
        Route::post('logout',                   [UserController::class, 'logout']);
        Route::post('update',                   [UserController::class, 'update']);
        Route::post('change/password',          [UserController::class, '_change_password']);
    });

    //obtener servicios de un usuario
    Route::prefix('service')->group(function () {
        Route::post('',                         [ServiceController::class, 'getService']);
        Route::post('create',                   [ServiceController::class, 'store']);
        Route::post('me',                       [ServiceController::class, 'my_service']);
        Route::post('change',                   [ServiceController::class, 'change_type_vehicle_to_service']);
        Route::post('rate',                     [ServiceController::class, 'getRate']);
        Route::post('domicile',                 [ServiceController::class, 'register_domicile']);
        Route::get('detail/{service}',          [ServiceController::class, 'serviceDetail'])->where('service','[0-9]+');
    });

    // ******VEHICULOS******** 
    Route::prefix('vehicle')->group(function () {
        Route::post('edit/{id}',                [VehicleController::class, 'edit'])->where('id','[0-9]+');
        Route::get('user/{id}',                 [VehicleController::class, 'UserVehicle'])->where('id','[0-9]+');
        Route::get('type/{id}',                 [VehicleController::class, 'VehicleType'])->where('id','[0-9]+');
    });

    // *******SUPPORT********
    Route::prefix('support')->group(function () {
        Route::post('/ticket',                  [SupportController::class, 'store']);
        Route::get('/ticket/detail/{ticket}',   [SupportController::class, 'show'])->where('ticket','[0-9]+');
        Route::get('/ticket/find/{user}',       [SupportController::class, 'findTicket'])->where('user','[0-9]+');
        Route::get('/question/{keyWord?}',      [SupportController::class, 'findFrequentQuestionWord'])->where('keyWord','[A-Za-z]+');
        Route::get('/question/{theme?}',        [SupportController::class, 'findFrequentQuestionTheme'])->where('theme','[0-9]+');
        Route::get('/theme',                    [SupportController::class, 'supporTheme']);
    });

    // *******RETIRO DE DINERO Y ENVIO********
    Route::prefix('cash')->group(function () {
        Route::post('/retirement',              [UserCashController::class, 'cash_retirement']);
        Route::post('/shipping',                [UserCashController::class, 'shipping_cash']);
        Route::post('/shipping/me',             [UserCashController::class, 'my_shipping']);
        Route::post('/shipping/pin',            [UserCashController::class, 'shipping_cash_pin']);
        Route::get('/retirement/me',            [UserCashController::class, 'my_retirement']);
        Route::get('/account/state',            [UserCashController::class, 'account_state']);
    });

    // *****BUSCADOR DE TIENDAS Y PRODUCTOS*******
    Route::prefix('search')->group(function(){
        Route::post('/items',                   [SearchController::class, 'search_place_items']);
        Route::post('/product',                 [SearchController::class, 'search_place_product']);
    });

    // *****ALTER CONFIGURACION*******
    Route::prefix('configuration')->group(function(){
        Route::post('/alter',                   [AlterConfigurationController::class, 'get_row']);
    });

    // *****REGISTRO CATEGORÍAS*****
    Route::prefix('categories')->group(function(){
        Route::post('/register/food',           [CategoryController::class, 'register_food']);
        Route::post('/register/liqueur',        [CategoryController::class, 'register_liqueur']);
        Route::post('/register/market',         [CategoryController::class, 'register_market']);
    });
});

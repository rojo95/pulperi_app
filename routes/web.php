<?php

//use App\Actions\Fortify\CreateNewUser;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ToDiscountController;
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

Route::middleware(['valAuth'])->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::middleware(['auth'])->group(function () {

        Route::get('/home', [HomeController::class, 'home'])->name('home');
        // Usuarios
        // mostrar todos los usuarios
        Route::get('/users', [UserController::class, 'indexUsers'])->name('usrs.index');
        // vista crear usuario
        Route::get('/users/create', [UserController::class, 'createUser'])->name('usrs.create');
        // almacenar usuario
        Route::post('/users', [UserController::class, 'storeUser'])->name('usrs.store');
        // mostrar información de usuario
        Route::get('/users/{id}', [UserController::class, 'showUser'])->name('usrs.show');
        // mostrar formulario de edición de usuario
        Route::get('/users/{id}/edit', [UserController::class, 'editUser'])->name('usrs.edit');
        // actualizar data del usuario
        Route::put('/users/{id}', [UserController::class, 'updateUser'])->name('usrs.update');
        // activar/desactivar usuarios
        Route::put('/users/{id}/status', [UserController::class, 'statusUser'])->name('usrs.status');
        // vista de información del perfil propio
        Route::get('/user', [UserController::class, 'showProfile'])->name('prfl.show');
        Route::get('/user/edit', [UserController::class, 'editProfile'])->name('prfl.edit');
        Route::put('/user', [UserController::class, 'updateProfile'])->name('prfl.update');


        // Rutas de permisos
        Route::resource('/permissions', PermissionController::class)->names('prmssns');

        //Rutas de roles
        Route::resource('/roles', RoleController::class)->names('rls');

        // Rutas de inventario
        Route::post('/products', [InventoryController::class,'productByName'])->name('products');
        Route::post('/prod', [InventoryController::class,'productById'])->name('prod');
        Route::resource('/inventory', InventoryController::class)->names('invntry');

        // Rutas para los lotes
        Route::post('/lots/{id}', [LotController::class,'store'])->name('lts.store');
        Route::get('/lots/{id}', [LotController::class,'edit'])->name('lts.edit');
        Route::get('/lots', [LotController::class,'index'])->name('lts.index');
        Route::get('/lot/{id}', [LotController::class,'show'])->name('lts.show');
        Route::put('/lots/{id}', [LotController::class,'update'])->name('lts.update');
        Route::delete('/lots/{id}', [LotController::class,'destroy'])->name('lts.destroy');
        Route::get('/expiringLot', [LotController::class,'showExpiring'])->name('lts.showExpiring');

        // Rutas para el descuento del inventario
        // Route::resource('/todiscount', ToDiscountController::class)->names('tdscnt');
        Route::get('/todiscount', [ToDiscountController::class, 'index'])->name('tdscnt.index');
        Route::get('/todiscount/create', [ToDiscountController::class, 'create'])->name('tdscnt.create');
        Route::post('/todiscount', [ToDiscountController::class, 'store'])->name('tdscnt.store');
        Route::get('/todiscount/{id}', [ToDiscountController::class,'show'])->name('tdscnt.show');
        Route::delete('/todiscount/{id}', [ToDiscountController::class, 'destroy'])->name('tdscnt.destroy');

        // consultar lotes por id
        Route::get('/prodLot/{id}', [ToDiscountController::class, 'productByIdLot'])->name('tdscnt.productByIdLot');

        // rutas para las ventas
        Route::resource('/sales', SaleController::class)->names('sls');

        // rutas para los clientes
        Route::post('/clients_registered', [ClientController::class,'clients_registered'])->name('clients_registered');
        Route::resource('/clients', ClientController::class)->names('clnts');

        // rutas para las deudas
        Route::post('/debt/detail', [DebtController::class,'debt_detail'])->name('dbts.detail');
        Route::resource('/debts', DebtController::class)->names('dbts');


        Route::get('/settings', [SettingsController::class,'index'])->name('settings.index');
        Route::get('/config', [SettingsController::class,'update'])->name('settings.config');



    });
});


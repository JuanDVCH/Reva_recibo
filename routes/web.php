<?php
use App\Http\Controllers\ControllerEtiqueta;
use App\Http\Controllers\Controller_Format_Receipt;
use App\Http\Controllers\Controller_Create_Products;
use App\Http\Controllers\ControllerProfile;
use App\Http\Controllers\ControllerUsers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Auth;

// Rutas de autenticación proporcionadas por Laravel
Auth::routes();

// Ruta predeterminada para usuarios no autenticados
Route::get('/', function () {
    return Auth::check() ? redirect('/home') : view('auth.Login');
});

// Rutas que requieren autenticación
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    // Otras rutas autenticadas aquí si es necesario

    // Rutas agrupadas por recursos
    Route::group(['prefix' => 'recibo'], function () {
        Route::resource('/', Controller_Format_Receipt::class)->names('recibo');
        Route::get('/obtener-codigos-cliente/{id}', [Controller_Format_Receipt::class, 'obtenerCodigosCliente']);
    });

    Route::resource('users', ControllerUsers::class);
    

    Route::group(['prefix' => 'profile'], function () {
        Route::get('profile/edit', [ControllerProfile::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ControllerProfile::class, 'update'])->name('profile.update');
    });

    Route::group(['prefix' => 'productos'], function () {
        Route::resource('/', Controller_Create_Products::class)->names('productos');
        Route::post('/obtener-info-recibo', [Controller_Create_Products::class, 'obtenerInfoRecibo'])->name('obtenerInfoRecibo');
        Route::get('/obtener-productos-por-orden/{orderNum}', [Controller_Create_Products::class, 'obtenerProductosPorOrden'])
            ->name('obtener.productos.por.orden');
        Route::post('/obtener-sku-por-descripcion', [Controller_Create_Products::class, 'obtenerSkuPorDescripcion'])->name('obtenerSkuPorDescripcion');
    });

    Route::group(['prefix' => 'etiquetas'], function () {
        Route::resource('/', ControllerEtiqueta::class)->names('etiqueta');
        Route::get('/obtener-skus-y-customer', [ControllerEtiqueta::class, 'obtenerSkusYCustomer'])->name('etiqueta.obtener-skus-y-customer');
        Route::post('/obtener-descripcion-por-sku', [ControllerEtiqueta::class, 'obtenerDescripcionPorSku'])->name('etiqueta.obtener-descripcion-por-sku');
        Route::post('/obtener-barcode-por-sku', [ControllerEtiqueta::class, 'obtenerBarcodePorSku'])->name('etiqueta.obtener-barcode-por-sku');
        Route::get('/{id_tag}/imprimir', [ControllerEtiqueta::class, 'imprimir'])->name('etiquetas.imprimir');
        Route::post('/obtener-info-reciboetiquetas', [ControllerEtiqueta::class, 'obtenerInfoReciboetiquetas'])->name('obtenerInfoReciboetiquetas');
    });

    // Ruta para asignar el rol de administrador
    Route::get('/assign-admin-role', [RolePermissionController::class, 'assignAdminRole']);

});